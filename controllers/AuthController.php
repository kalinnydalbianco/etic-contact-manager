<?php

require_once '../core/Controller.php';
require_once '../models/UsersRepository.php';

class AuthController extends Controller {

    private $users;

    public function __construct() {
        $this->users = new UsersRepository();
    }

    public function login() {

        if ($this->isPost()) {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $this->users->attemptLogin($username, $password);
                $this->redirect('/contacts');
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        $this->render('login', ['message' => isset($message) ? $message : null]);
    }

    public function logout() {
        $this->users->doLogout();
        $this->redirect('/');
    }

    public function signUp() {
        if ($this->isPost()) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];

            try {
                $this->users->signUpUser($username, $password, $name);
                $this->redirect('/');
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        $this->render('signup', [
            'message' => isset($message) ? $message : null
        ]);
    }
}