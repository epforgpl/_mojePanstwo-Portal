<?php

App::uses('AppController', 'Controller');

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
        'header' => false,
        'body' => array(
            'theme' => 'simply',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );

    public $title = false;
    public $description = false;
    public $appSelected = '';
    public $_app = array();

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
		
		$app = false;

        if(
	        isset($this->settings['id']) &&
        	( $app = $this->getApplication($this->settings['id']) )
        ) {
	        $app = array_merge($app, $this->_app);
            $this->set('_app', $app);
        };

        if ($this->menu_selected === false)
            $this->menu_selected = $this->request->params['action'];
            
        if ($this->chapter_selected === false)
            $this->chapter_selected = $this->request->params['action'];

        $this->set('appSettings', $this->settings);


		if( empty($this->app_menu[0]) )
			foreach( $this->applications as $id => $a )
				if( $a['tag']==1 )
					$this->app_menu[0][] = array(
						'id' => $id,
						'href' => $a['href'],
						'title' => $a['name'],
					);



		$active = false;
		$temp = array();
		$href = '/dane';
		if( isset($this->request->query['q']) && $this->request->query['q'] )
			$href .= '?q=' . urlencode($this->request->query['q']);
		$bufor = array(
			array(
				'id' => 'dane',
				'href' => $href,
				'title' => 'Dane publiczne',
			),
		);

		foreach( $this->app_menu[0] as $i => $a ) {

			if(
				isset($this->request->query['q']) &&
				( $q = $this->request->query['q'] )
			)
				$a['href'] .= '?q=' . urlencode($q);

			if( $app && ($app['id']==$a['id']) ) {

				$a['active'] = $active = true;
				$temp[] = $a;

			} else {

				$temp[] = $a;

			}

		}

		$this->app_menu[0] = array_merge($bufor, $temp);

		if( !$active )
			$this->app_menu[0][0]['active'] = true;


		$this->set('app_menu', $this->app_menu);
		$this->set('app_chapters', $this->getChapters());

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
	        'dataset' => $dataset,
            'conditions' => array(
                'dataset' => $dataset,
            ),
            'aggsPreset' => $dataset,
        ), $options);
        
        $this->Components->load('Dane.DataBrowser', $options);

        if(isset($options['menu'])) {
            $this->set('menu', $options['menu']);
        }

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
						
		    $datasets = $this->getDatasets($this->settings['id']);

			$fields = array('searchTitle', 'order', 'autocompletion');
			$params = array(
				'aggs' => array(
					'filter' => array(
						'filter' => array(
							'terms' => array(
								'dataset' => array_keys( $datasets ),
							),
						),
						'aggs' => array(
							'dataset' => array(
								'terms' => array(
									'field' => 'dataset',
								),
							),
						),
						'scope' => 'query',
						'visual' => array(
							'skin' => 'datasets',
	                        'field' => 'dataset',
	                        'dictionary' => $datasets,
	                        'forceKey' => 'dataset',
	                        'target' => 'menu',
						),
					),
				),
				'apps' => true,
				'routes' => array(
					'filter/dataset' => 'dataset',
				),
			);
			
			if( isset($data['dataset_name']['default_order']) )
				$params['default_order'] = $data['dataset_name']['default_order'];
				
			if( isset($data['dataset_name']['default_conditions']) )
				$params['default_conditions'] = $data['dataset_name']['default_conditions'];
			
			foreach( $fields as $field )
				if( isset($data['dataset_name'][ $field ]) )
					$params[ $field ] = $data['dataset_name'][ $field ];

			$this->menu_selected = $this->request->params['id'];
			$this->chapter_selected = $this->request->params['id'];
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
					/*
					'icon' => array(
						'src' => 'datasets',
						'id' => $dataset,
					),
					*/
				);

			}
		}

		return $menu;

    }
	
	public function getChapters() {
		
		$mode = false;
				
		$items = array(
			array(
				'label' => 'Start',
				'href' => '/' . $this->settings['id'],
			),
		);
		
		if(
			isset( $this->request->query['q'] ) && 
			$this->request->query['q']
		) {
									
			$items[] = array(
				'id' => '_results',
				'label' => 'Wyniki wyszukiwania',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
			);
			
			if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';
			
		}
		
		if(
			( $map = @$this->viewVars['dataBrowser']['aggs_visuals_map']['dataset']['dictionary'] ) && 
			( $datasets = @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] )
		) {
									
			foreach( $map as $key => $value ) {
								
				if( !isset($value['menu_id']) )
					$value['menu_id'] = '';
				
				$item = array(
					'id' => $value['menu_id'],
					'label' => $value['label'],
					'href' => '/' . $this->settings['id'] . '/' . $value['menu_id'],
				);
								
				if( $mode == 'results' ) {
										
					$item['href'] .= '?q=' . urlencode( $this->request->query['q'] );

					foreach( $datasets as $d ) {
												
						if( $d['key']==$key ) {
							
							if( $d['doc_count'] ) {
								$item['count'] = $d['doc_count'];
								$items[] = $item;
							}
							
							break;
							
						} 
					}
					
				} else {
					
					$items[] = $item;
					
				}
				
			}
			
		}
				
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);
				
		return $output;
		
	}
	
    public function json($data) {
        $this->autoRender = false;
        $this->response->type('json');
        $json = json_encode($data);
        $this->response->body($json);
        return true;
    }

}
