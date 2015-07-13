<?php

App::uses('DataobjectsController', 'Dane.Controller');

class RadniDzielnicController extends DataobjectsController
{

    /*
    public $menu = array();
	
    public $objectOptions = array(
        'hlFields' => array('gminy.nazwa', 'dzielnice.nazwa'),
    );
    */

    public function view()
    {

        parent::view();
        $this->redirect($this->object->getUrl());

    }
} 