<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SenatorowieController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public function view()
    {
        parent::_prepareView();

    }
} 