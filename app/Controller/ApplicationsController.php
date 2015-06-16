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
	
	public $_layout = array(
        'header' => array(
            'element' => 'app',
        ),
        'body' => array(
            'theme' => 'simply',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );
	
    public $title = false;
    public $description = false;
    public $appSelected = 'dane';
    
    public $appDatasets = array();
    public $mainMenuLabel = false;

    public function beforeFilter()
    {
        $this->settings = array_merge($this->_settings, $this->settings);

        $this->Auth->authenticate = array(
            'Paszport'
        );

        parent::beforeFilter();

    }

    public function beforeRender()
    {		
					
        if(
	        isset($this->settings['id']) && 
        	( $app = $this->getApplication($this->settings['id']) ) 
        ) {
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
	    	( $data = $this->getDatasetByAlias(@$this->settings['id'], $this->request->params['id']) )
	    ) {
		    		    
			$fields = array('searchTitle', 'order');
			$params = array();
			
			foreach( $fields as $field )
				if( isset($data['dataset_name'][ $field ]) )
					$params[ $field ] = $data['dataset_name'][ $field ];
			
			$this->menu_selected = $this->request->params['id'];
			$this->title = $data['dataset_name']['label'];
	        $this->loadDatasetBrowser($data['dataset_id'], $params);
		    
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
			'icon' => array(
				'src' => 'glyphicon',
				'id' => 'home',
			),
		);
		
		if( array_key_exists($this->settings['id'], $this->datasets) ) {
			foreach($this->datasets[ $this->settings['id'] ] as $dataset => $params) {
								
				if( @$params['menu_id'] )
				$menu['items'][] = array(
					'id' => $params['menu_id'],
					'label' => $params['label'],
					'icon' => array(
						'src' => 'datasets',
						'id' => $dataset,
					),
				);
				
			}
		}				
				
		return $menu;

    }

}