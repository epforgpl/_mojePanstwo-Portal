<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmGlosowaniaController extends DataobjectsController
{
    public $menu = array(
        array(
            'id' => 'view',
            'label' => 'LC_INDYWIDUALNE_WYNIKI_GLOSWANIA',
        ),
    );
    public $breadcrumbsMode = 'app';

    public function view()
    {

        parent::view();

        $this->redirect($this->object->getUrl());
        die();

    }
} 