<?php

class ApplicationsController extends AppController
{

    public $settings = array();
    public $_settings = array(
        'title' => '',
        'subtitle' => '',
        'headerImg' => false,
    );

    public $components = array(
        'Session',
        'Facebook.Connect'
    );

    public $title = false;
    public $description = false;
    public $appSelected = 'dane';
    
    public $appDatasets = array();
    public $mainMenuLabel = 'Przeglądaj';

    public function beforeFilter()
    {
        $this->setLayout(array('body' => array('theme' => 'simply')));
        $this->settings = array_merge($this->_settings, $this->settings);

        $this->Auth->authenticate = array(
            'Paszport'
        );

        parent::beforeFilter();

    }

    public function beforeRender()
    {		
				
        if ($app = $this->getApplication($this->settings['id'])) {
            $this->set('_app', $app);
        };

        if ($this->menu_selected === false)
            $this->menu_selected = $this->request->params['action'];

        $this->set('appSettings', $this->settings);

        if ($this->title)
            $this->set('title_for_layout', $this->title);
        elseif (isset($this->settings['title']))
            $this->set('title_for_layout', $this->settings['title']);
            
       parent::beforeRender();

    }

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();

        if ($this->description)
            $this->setMeta('description', $this->description);
        elseif (isset($this->settings['subtitle']))
            $this->setMeta('description', $this->settings['subtitle']);

        if ($this->title)
            $this->setMeta('og:title', $this->title);
        elseif (isset($this->settings['title']))
            $this->setMeta('og:title', $this->settings['title']);
    }

    public function setMenuSelected($selected = '')
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
    
    public function action()
    {
	    
	    if( 
	    	isset($this->request->params['id']) && 
	    	array_key_exists($this->request->params['id'], $this->appDatasets) && 
	    	( $data = $this->appDatasets[$this->request->params['id']] )
	    ) {
		    
			$fields = array('searchTitle', 'order');
			$params = array();
			
			foreach( $fields as $field )
				if( isset($data[ $field ]) )
					$params[ $field ] = $data[ $field ];
			
			$this->menu_selected = $this->request->params['id'];
	        $this->loadDatasetBrowser($data['dataset'], $params);
		    
	    }
	    	    
    }
    
    public function getMenu()
    {
				
		$menu = array(
			'items' => array(),
			'base' => '/' . $this->settings['id'],
		);
		
		$menu['items'][] = array(
			'label' => $this->mainMenuLabel,
		);
		
		if( !empty($this->appDatasets) ) 
			foreach( $this->appDatasets as $dataset => $params )
				$menu['items'][] = array(
					'id' => $dataset,
					'label' => $params['label'],
				);
				
		return $menu;

    }

}