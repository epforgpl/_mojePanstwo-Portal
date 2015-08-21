<?php

App::uses('DataobjectsController', 'Dane.Controller');

class BdlWskaznikiKategorieController extends DataobjectsController
{
	
	public function beforeRender() {
		
		return $this->redirect('/bdl/kategorie/' . $this->request->params['id']);
		
	}
	
} 