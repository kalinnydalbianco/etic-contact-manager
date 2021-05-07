<?php 

class Request {

    public static function valueIfExists($data, $key, $default) {
        return !empty($data[$key]) ? $data[$key] : $default;
    }

    public static function get($key, $defaultValue = null) {
        return Request::valueIfExists($_GET, $key, $defaultValue);
    }

    public static function post($key, $defaultValue = null) {
        // return isset($_POST[$key]) ? $_POST[$key] : $defaultValue;
        return Request::valueIfExists($_POST, $key, $defaultValue);
    }

    public static function file($key) {
        // return isset($_FILES[$key]) ? $_FILES[$key] : null;
        return Request::valueIfExists($_FILES, $key, null);
    }

    public static function session($key, $value = null) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (is_null($value)) {
            // return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
            return Request::valueIfExists($_SESSION, $key, null);
        }

        $_SESSION[$key] = $value;
        return $value;
    }

    public static function cookie($key, $value = null) {
        if (is_null($value)) {
            return Request::valueIfExists($_COOKIE, $key, null);
        }

        setcookie($key, $value);
        return $value;
    }
}