<?php

App::uses('DataobjectsController', 'Dane.Controller');

class NgoKonkursyController extends DataobjectsController
{

    public $initLayers = array('content');

    public $menu = array();
    public $objectOptions = array(
        'hlFields' => array('symbol'),
    );

}