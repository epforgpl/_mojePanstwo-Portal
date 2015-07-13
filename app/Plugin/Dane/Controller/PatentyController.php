<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class PatentyController extends DocsObjectsController
{
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(),
    );
} 