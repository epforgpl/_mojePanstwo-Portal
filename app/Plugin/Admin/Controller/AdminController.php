<?php

App::uses('AdminAppController', 'Admin.Controller');

class AdminController extends AdminAppController
{

    public function index() {
        $this->set('action', 'start');
    }

}
