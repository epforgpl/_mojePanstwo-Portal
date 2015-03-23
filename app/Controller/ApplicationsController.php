<?php

class ApplicationsController extends AppController
{
	
	public $settings = array();
	public $_settings = array(
		'menu' => array(),
		'menuSelected' => false,
		'title' => '',
		'subtitle' => '',
		'headerImg' => false,
	);
	
	public function beforeFilter() {
				
		$this->settings = array_merge($this->_settings, $this->settings);
		parent::beforeFilter();
					
	}
	
	public function beforeRender()
    {
	    	      
	    if( $this->settings['menuSelected'] === false )
	    	$this->settings['menuSelected'] = $this->request->params['action'];
	    
        $this->set('appSettings', $this->settings);
        
        if( isset($this->settings['title']) )
	        $this->set('title_for_layout', $this->settings['title']);
        
        if( isset($this->settings['subtitle']) )
	        $this->setMetaDesc($this->settings['subtitle']);
    }
    
    public function setMenuSelected( $selected = '' )
    {
	    
	    $this->settings['menuSelected'] = $selected;
    
    }
    
    public function loadDatasetBrowser($dataset, $options = array())
    {
	    
	    $options = array_merge(array(
            'conditions' => array(
	            'dataset' => $dataset,
            ),
            'aggsPreset' => $dataset,
        ), $options);
	    	    
	    $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
        	    
    }
    
    public function index()
    {
	    
        $this->set('apps', $this->Application->find('all'));
    
    }
	
}