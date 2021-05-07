<?php 

require_once '../core/Router.php';

class Application {

    private $defaultRoute = '/';
    private $router;

    public function __construct() {
        $this->router = new Router('../configs/routes.config.php');
    }
 
    public function run() {
        $uri = $this->getUri();

        try {
            $route = $this->router->get($uri);
            $this->invoke($route);            
        } catch (Exception $e) {
            header("HTTP/1.1 404 Not Found");
            die($e->getMessage());
        }
    }

    private function invoke($route) {
        extract($route);
        
        if ($this->validateInvocation($controller, $action)) {
            $controllerInstance = new $controller();
            $controllerInstance->$action();
            return;
        }
        
        throw new Exception('404 Not Found');
    }

    private function validateInvocation($controller, $action) {
        $controllerPath = "../controllers/$controller.php";
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            return class_exists($controller) && method_exists($controller, $action);
        }
        return false;
    }

    private function getUri() {
        return isset($_SERVER['PATH_INFO']) 
            ? $_SERVER['PATH_INFO'] 
            : $this->defaultRoute;
    }
}