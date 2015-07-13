<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmWystapieniaController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public function view()
    {

        parent::view();

        $this->redirect($this->object->getUrl());
        die();

    }
} 