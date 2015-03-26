<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmKlubyController extends DataobjectsController
{

    public $menu = array();
    public $breadcrumbsMode = 'app';

    public function view()
    {
        
        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'poslowie',
	            'poslowie.klub_id' => $this->object->getId(),
            )
        ));
        $this->set('DataBrowserTitle', 'Posłowie w tym klubie');
        $this->render('DataBrowser/browser');        
   
    }
} 