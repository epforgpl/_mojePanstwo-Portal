<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmWystapieniaController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public function view()
    {
        
		if( @$this->request->params['ext']=='json' ) {
			
			$this->addInitLayers('html');
			parent::view();
			
			$this->set('data', $this->object->getData());
			$this->set('layers', array(
				'html' => $this->object->getLayer('html'),
			));
			$this->set('_serialize', array('data', 'layers'));
			
		} else {
			
			$this->load();			
			return $this->redirect( $this->object->getUrl() );
			
		}

    }
} 