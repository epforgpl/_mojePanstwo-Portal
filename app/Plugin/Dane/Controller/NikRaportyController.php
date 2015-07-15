<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class NikRaportyController extends DocsObjectsController
{
	
	public function view() {
		
		parent::load();
		return $this->redirect( $this->object->getUrl() );
		
	}
	
} 