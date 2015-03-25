<?php

App::uses('ApplicationsController', 'Controller');
App::import('Model', 'Paszport.User');

class AjaxRequestController extends ApplicationsController {

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->autoRender = false;
    }

    public function beforeFilter() {
        parent::beforeFilter();

        if(!$this->Auth->loggedIn()) {
            $this->redirect('/paszport');
        }
    }

    public function setUserName() {
        $user = new User();
        $response = $user->setUserName(
            (isset($this->data['value']) ? $this->data['value'] : null)
        );

        return json_encode($response);
    }

    public function setEmail() {
        $user = new User();
        $response = $user->setEmail(
            (isset($this->data['value']) ? $this->data['value'] : null)
        );

        return json_encode($response);
    }

    public function setPassword() {
        $user = new User();
        $response = $user->setPassword($this->data);
        return json_encode($response);
    }

}