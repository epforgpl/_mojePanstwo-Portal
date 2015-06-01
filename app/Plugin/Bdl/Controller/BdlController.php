<?php

App::uses('ApplicationsController', 'Controller');

class BdlController extends ApplicationsController
{

	public $settings = array(
		'id' => 'bdl',
		'menu' => array(
			array(
				'id' => '#',
				'label' => 'Bank Danych Lokalnych',
				'dropdown' => array(
					array(
						'id' => 'bdl_kategorie',
						'label' => 'Kategorie wskaźników',
					),
					array(
						'id' => 'bdl_grupy',
						'label' => 'Grupy wskaźników',
					),
					array(
						'id' => 'bdl_wskazniki',
						'label' => 'Wskaźniki',
					),
				),
			)
		),
        'title' => 'Bdl',
		'subtitle' => 'Dane statystyczne o Polsce',
        'headerImg' => 'bdl',
	);
	
    public function view()
    {
        $datasets = $this->getDatasets('bdl');
        
        $options  = array(
            'searchTitle' => 'Szukaj w Banku Danych Lokalnych...',
            'conditions' => array(
	            'dataset' => array_keys( $datasets )
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Bdl',
		            'element' => 'cover',
	            ),
	            'aggs' => array(),
            ),
            'aggs' => array(
		        'dataset' => array(
		            'terms' => array(
			            'field' => 'dataset',
		            ),
		            'visual' => array(
			            'label' => 'Zbiory danych',
			            'skin' => 'datasets',
			            'class' => 'special',
		                'field' => 'dataset',
		                'dictionary' => $datasets,
		            ),
		        ),
            ),
        );

		if( !isset($this->request->query['q']) || empty($this->request->query['q']) ) {
	        
	        $tree = Cache::read('BDL.tree', 'long');
	        if (!$tree) {
	            $this->loadModel('Bdl.BDL');
				$tree = $this->BDL->getTree();
	            Cache::write('BDL.tree', $tree, 'long');
	        }	        
			$this->set('tree', $tree);
			
        }
		
	    $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');        
        
    }

} 