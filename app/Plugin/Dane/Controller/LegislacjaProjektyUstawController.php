<?php

App::uses('DataobjectsController', 'Dane.Controller');

class LegislacjaProjektyUstawController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array('status_str'),
    );

    public function view()
    {

        $url = '/dane/prawo_projekty/' . $this->request->params['id'];
        $this->redirect($url, '301');

    }

} 