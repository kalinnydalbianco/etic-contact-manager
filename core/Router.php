<?php

class Router {

    private $routes = [];

    public function __construct(string $routesFile) {
        if (file_exists($routesFile)) {
            $this->routes = require $routesFile;
        }
    }

    public function get(string $uri): array {
        if (isset($this->routes[$uri])) {
            return $this->routes[$uri];
        }
        throw new Exception("404 Not Found");
    }
}