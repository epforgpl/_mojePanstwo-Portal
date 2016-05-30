<?php
App::uses('DataobjectsController', 'Dane.Controller');
App::uses('Set', 'Utility');

class FbPostsController extends DataobjectsController
{

    public $breadcrumbsMode = 'app';

    public $components = array(
        'RequestHandler',
    );

    public $helpers = array(
        'Time',
    );
    public $menu = array();

    public $objectOptions = array(
        'hlFields' => array(),
        'renderTitle' => false,
    );

    public function view()
    {

        $this->load();

    }

} 