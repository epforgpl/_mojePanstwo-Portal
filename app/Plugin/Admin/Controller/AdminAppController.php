<?php

App::uses('AppController', 'Controller');

class AdminAppController extends AppController
{

    public function beforeFilter() {
        parent::beforeFilter();

        if(!$this->hasUserRole('superadmin'))
            throw new ForbiddenException;
    }

}