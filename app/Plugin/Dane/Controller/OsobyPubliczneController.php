<?php

App::uses('DataobjectsController', 'Dane.Controller');

class OsobyPubliczneController extends DataobjectsController
{
    
    public $components = array(
        'RequestHandler'
    );
    
    public $initLayers = array('naukapolska');
    
    public function view() {
	    
	    parent::view();
	    
	    // $naukapolska = $this->object->getLayer('naukapolska');
	    // debug( $naukapolska ); die();
	    
	    if( 
	    	( $wiki_id = $this->object->getData('wiki_id') ) && 
	    	( $wiki_data = file_get_contents('https://pl.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=' . $wiki_id) ) && 
	    	( $wiki_data = json_decode($wiki_data, true) ) && 
	    	( $wiki_data = $wiki_data['query']['pages'] )
    	) {
		    
		    foreach( $wiki_data as $data ) {
			    break;
		    }
		    
		    $this->set('wiki_txt', $data['extract']);		    
		    
	    }
	    
	    if( $krs_id = $this->object->getData('krs_id') ) {
		    
		    $krs_osoba = $this->Dataobject->find('first', array(
			    'conditions' => array(
				    'dataset' => 'krs_osoby',
				    'id' => $krs_id
			    ),
			    'layers' => array('organizacje'),
		    ));
		    $this->set('krs_osoba', $krs_osoba);
		    		    
	    }
	    
    }

}