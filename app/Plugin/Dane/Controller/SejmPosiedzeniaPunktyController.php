<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmPosiedzeniaPunktyController extends DataobjectsController
{
    public $uses = array('Dane.Dataobject');
    public $helpers = array('Dane.Dataobject');
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(),
        'routes' => array(
            'description' => false,
        ),
    );

    public $initLayers = array('related');

    public function view()
    {

        parent::view();
        return $this->redirect($this->object->getUrl());

    }

} 