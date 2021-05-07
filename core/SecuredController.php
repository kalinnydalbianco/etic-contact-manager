<?php

require_once '../core/Controller.php';
require_once '../models/UsersRepository.php';

abstract class SecuredController extends Controller {

    protected $users;
    protected $user;

    public function __construct() {
        $this->users = new UsersRepository();

        if (!$this->users->isAuthenticated()) {
            $this->redirect('/');
        }

        $this->user = $this->users->getLoggedInUser();
    }
}