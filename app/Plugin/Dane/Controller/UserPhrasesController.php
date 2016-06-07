<?php

App::uses('DataobjectsController', 'Dane.Controller');

class UserPhrasesController extends DataobjectsController {
	
    public $components = array('RequestHandler');
	
	public function phrase() {
		
		if( $q = trim($this->request->query['q']) ) {
			
			$phrase_id = $this->Dataobject->getDataSource()->request('dane/user_phrases/register', array(
	            'method' => 'POST',
	            'data' => array(
	                'q' => $q,
	            ),
	        ));
	        	        
	        $object = $this->Dataobject->find('first', array(
		        'conditions' => array(
			        'dataset' => 'users_phrases',
			        'id' => $phrase_id,
		        ),
		        'layers' => array('channels', 'subscription'),
	        ));	
	        
	        $data = array(
		        'data' => $object->getData(),
		        'layers' => $object->getLayers(),
		        'title' => $object->getData('q'),
		        'url' => '/?q=' . $object->getData('q'),
	        );		
			
		} else {
			
			$data = false;
			
		}
		
		$this->set('data', $data);
		$this->set('_serialize', 'data');
		
	}
	
}