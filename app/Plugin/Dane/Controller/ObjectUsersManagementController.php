<?php

class ObjectUsersManagementController extends AppController {

    public $uses = array('Dane.ObjectUsersManagement');
    public $components = array('RequestHandler');

    public function __construct($request, $response) {
        parent::__construct($request, $response);
        $this->ObjectUsersManagement->setRequest($request);
    }

    public function getUserObjects() {
        $response = $this->ObjectUsersManagement->getUserObjects();
        $this->setResponse($response);
    }

    public function index() {
        $response = $this->ObjectUsersManagement->index();
        $this->setResponse($response);
    }

    public function add() {
        $response = $this->ObjectUsersManagement->add($this->data);
        $this->setResponse($response);
    }

    public function edit() {
        $response = $this->ObjectUsersManagement->edit($this->data);
        $this->setResponse($response);
    }

    public function delete() {
        $response = $this->ObjectUsersManagement->delete();
        $this->setResponse($response);
    }

    private function setResponse($response) {
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }

}
