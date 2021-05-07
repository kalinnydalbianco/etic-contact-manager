<?php

require '../core/Database.php';

class UsersRepository extends Database {

    public function getUserByUsername($username) {
        $users = $this->where('users', [
            'username' => $username
        ]);

        return isset($users[0]) ? $users[0] : null;
    }

    public function attemptLogin($username, $password) {
        $user = $this->getUserByUsername($username);

        if (is_null($user) || !password_verify($password, $user->password)) {
            throw new Exception("Bad credentials!");
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user'] = $user;
    }

    public function doLogout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
    }

    public function isAuthenticated() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']);
    }

    public function getLoggedInUser() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user'];
    }

    public function signUpUser($username, $password, $name) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $result = $this->insert('users', [
            'username' => $username,
            'password' => $password,
            'name' => $name
        ]);

        if ($result['stmt']->rowCount() < 1) {
            throw new Exception('Error signing up user');
        }
    }
}