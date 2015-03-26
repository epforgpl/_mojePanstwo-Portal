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

    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'paszport',
                'plugin' => 'paszport',
                'action' => 'login'
            ),
            'logoutRedirect' => array(
                'controller' => 'paszport',
                'plugin' => 'paszport',
                'action' => 'logout',
                'home'
            ),
            'authenticate' => array(
                'Paszport'
            )
        )
    );
	
	public $title = false;
	public $description = false;
	
	public function beforeFilter() {
				
		$this->settings = array_merge($this->_settings, $this->settings);

        $this->Auth->authenticate = array(
            'Paszport'
        );

		parent::beforeFilter();
					
	}
		
	public function beforeRender()
    {
	    	      
	    if( $this->settings['menuSelected'] === false )
	    	$this->settings['menuSelected'] = $this->request->params['action'];
	    
        $this->set('appSettings', $this->settings);
        
        if( $this->title )
	        $this->set('title_for_layout', $this->title);
        elseif( isset($this->settings['title']) )
	        $this->set('title_for_layout', $this->settings['title']);
        
        if( $this->description )
	        $this->setMetaDesc($this->description);
        elseif( isset($this->settings['subtitle']) )
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