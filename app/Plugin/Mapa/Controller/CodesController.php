<?php

App::uses('ApplicationsController', 'Controller');

class CodesController extends ApplicationsController
{

    public $components = array('RequestHandler');

    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
    );

    public function view($code)
    {
	    
	    $this->loadModel('Mapa.Mapa');
	    $code = $this->Mapa->getCode( $code );	    
	    
	    // debug($code); die();
	    
	    $this->title = $code['kod']['slug'];
	    	    
	    
	    $this->set('code', $code);
	   	
	   	if( isset($this->request->query['widget']) ) {
        	$this->layout = 'blank';
        	$this->set('widget', true);
        }
	   	   
	    /*
        if ((@$this->request->params['ext'] == 'json') && (isset($this->request->query['q']))) {
            $data = $this->Mapa->geocode($this->request->query['q']);
            $this->set('data', $data);
            $this->set('_serialize', 'data');
        } else {
            $this->title = 'Mapa';
        }
        */
                
    }
}
