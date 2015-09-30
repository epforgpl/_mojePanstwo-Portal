<?php

App::uses('ApplicationsController', 'Controller');

class MapaController extends ApplicationsController
{
	
	public $components = array('RequestHandler');
	
    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
    );

    public $submenus = array(
        'mapa' => array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Start',
                )
            )
        )
    );

    public function view()
    {
	    
	    if( 
	    	( @$this->request->params['ext'] == 'json' ) && 
	    	( isset($this->request->query['q']) )
	    ) {
		    
		    
		    
	    } else {
	    
	        $this->title = 'Mapa';
        
        }
        
    }
}
