<?php

class PrawoController extends AppController
{

	private $appMenu = array(
		array(
			'id' => '',
			'label' => 'Akty prawne',
		),
		array(
			'id' => 'tematy',
			'label' => 'Tematy',
		),
	);
	
	private $appMenuSelected = false;
	
    public function beforeRender()
    {
	    	    
	    if( $this->appMenuSelected === false )
	    	$this->appMenuSelected = $this->request->params['action'];
	    
        $this->set('appMenu', $this->appMenu);
        $this->set('appMenuSelected', $this->appMenuSelected);
        
    }



    public function akty()
    {
        
        $this->appMenuSelected = '';
        
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'prawo',
            ),
            'aggsPreset' => 'prawo',
        ));
        
    }

    public function tematy()
    {
	    
	    
    }

} 