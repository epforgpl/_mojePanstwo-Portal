<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KulturaAnkietyController extends DataobjectsController
{
	
	public $addDatasetBreadcrumb = false;
	public $initLayers = array(
		'data'
	);
	
	public function beforeRender() {
		
		parent::beforeRender();
		
		if( $this->object->getData('file_slug') != 'kultura' ) {
			$this->addBreadcrumb(array(
	            'href' => '/kultura/' . $this->object->getData('file_slug'),
	            'label' => $this->object->getData('file'),
	        ));
        }
		
	}
	
}