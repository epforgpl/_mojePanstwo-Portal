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

        if(!$this->Auth->loggedIn())
            $this->redirect('/paszport');
    }

    /**
     * @desc Po każdej zmianie trzeba zaktualizować dane użytkownika w sesji
     * tak aby były one widoczne na stronie bez potrzeby przelogowywania.
     */
    private function updateLoggedUser($response, $field, $value) {
        $user = $this->Auth->user();
        if($response == 'true') {
            $user[$field] = $value;
            $this->Session->write('Auth.User', $user);
        }
    }

    public function setUserName() {
        $user = new User();
        $response = $user->setUserName(
            (isset($this->data['value']) ? $this->data['value'] : null)
        );

        $this->updateLoggedUser($response, 'username', $this->data['value']);
        return json_encode($response);
    }

    public function setEmail() {
        $user = new User();
        $response = $user->setEmail(
            (isset($this->data['value']) ? $this->data['value'] : null)
        );

        $this->updateLoggedUser($response, 'email', $this->data['value']);
        return json_encode($response);
    }

    public function setPassword() {
        $user = new User();
        $response = $user->setPassword($this->data);
        return json_encode($response);
    }

    public function delete() {
        $user = new User();
        $response = $user->deletePaszport(
            (isset($this->data['password']) ? $this->data['password'] : null)
        );

        return json_encode($response);
    }

}