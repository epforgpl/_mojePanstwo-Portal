<?php

App::uses('StartAppController', 'Start.Controller');
App::import('Model', 'Paszport.User');

class AccountController extends StartAppController
{
    public $chapter_selected = 'account';

    public function index() {
        $user = $this->Auth->User();
        $this->set('user', $user);
        $user = new User();
        $this->set('canCreatePassword', $user->canCreatePassword());
    }

}