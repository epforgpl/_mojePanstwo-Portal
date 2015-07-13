<?php

App::uses('DataobjectsController', 'Dane.Controller');

class DotacjeUeController extends DataobjectsController
{
    public $menu = array();
    public $objectOptions = array(
        'hlFields' => array('symbol'),
    );

}