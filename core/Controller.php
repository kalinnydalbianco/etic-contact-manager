<?php

abstract class Controller {

    protected function render($view, $data = null) {
        if (!is_null($data)) {
            extract($data);
        }

        include "../views/$view.phtml";
    }

    protected function redirect($url) {
        header("Location: $url");
        die();
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}