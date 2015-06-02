<?php

App::uses('DataobjectsController', 'Dane.Controller');
App::uses('Sanitize', 'Utility');

class SejmInterpelacjeController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';
	public $feed = false;
	
	public $loadChannels = true;
	
    public $objectOptions = array(
        'hlFields' => array(),
    );

    public function view()
    {
		
		$this->load();
		$feed = $this->feed(array(
	        'direction' => 'asc',
	        'timeline' => true,
	        'mode' => 'min',
        ));     

    }
    
    public function loadDoc($id = false) {
	    if( 
			$id && 
			( $dokument = $this->Dataobject->find('first', array(
				'conditions' => array(
					'dataset' => 'sejm_interpelacje_pisma',
					'id' => $id,
				),
				'layers' => array(
					'teksty'
				),
			)) )
		) {
								
	        $this->set('dokument', $dokument);
			
		}
	
    }
    
    public function pismo() {
				
		$this->load();
		$feed = $this->feed(array(
	        'direction' => 'asc',
	        'timeline' => true,
	        'mode' => 'min',
        ));
			        
        $this->view = 'view';
        
	} 
    
    public function beforeRender() {
	    
	    $id = false;
		
		if( isset($this->request->params['subid']) )
			$id = $this->request->params['subid'];
		elseif( $first_hit = $this->feed['hits'][0] )
			$id = $first_hit->getId();
	    
	    if( $id  )
	        $this->loadDoc( $id );
		    	    
	    parent::beforeRender();
	    
    }

} 