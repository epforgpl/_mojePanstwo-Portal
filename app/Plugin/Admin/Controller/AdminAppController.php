<?php

App::uses('AppController', 'Controller');

class AdminAppController extends AppController
{

    public function beforeFilter() {
        parent::beforeFilter();

        if(!$this->hasUserRole('2'))
            throw new ForbiddenException;
    }

}