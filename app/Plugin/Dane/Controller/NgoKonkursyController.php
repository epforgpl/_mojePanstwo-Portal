<?php

App::uses('DataobjectsController', 'Dane.Controller');

class NgoKonkursyController extends DataobjectsController
{
    public $menu = array();
    public $objectOptions = array(
        'hlFields' => array('symbol'),
    );

}