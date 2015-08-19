<?php

App::uses('ApplicationsController', 'Controller');

class BdlController extends ApplicationsController
{

    public $settings = array(
        'id' => 'bdl',
        'title' => 'Bdl',
        'subtitle' => 'Dane statystyczne o Polsce',
        'headerImg' => 'bdl',
    );

    public $mainMenuLabel = 'Przeglądaj';

    public function view()
    {
        $datasets = $this->getDatasets('bdl');
				
        $options = array(
            'searchTitle' => 'Szukaj w Banku Danych Lokalnych...',
            'autocompletion' => array(
                'dataset' => 'bdl_wskazniki',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Bdl',
                    'element' => 'cover',
                ),
                'aggs' => array(
	                'kategorie' => array(
		                'filter' => array(
			                'term' => array(
				                'dataset' => 'bdl_wskazniki_kategorie',
			                ),
		                ),
		                'aggs' => array(
			                'id' => array(
				                'terms' => array(
					                'field' => 'id',
				                ),
			                ),
		                ),
		                'visual' => array(
	                        'skin' => 'chapters',
	                        'field' => 'kategoria',
	                    ),
	                ),
                ),
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
            'apps' => true,
            'routes' => array(
	            'kategorie/id' => 'kategorie',
            ),
        );


        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'Bank Danych Lokalnych';
        $this->render('Dane.Elements/DataBrowser/browser-from-app');


    }
    
    
    public function getMenu() {
	    
	    $menu = array(
		    'items' => array(
			    array(
				    'id' =>'',
				    'label' => 'Wskaźniki',
				    'icon' => array(
					    'src' => 'glyphicon',
					    'id' => 'home',
				    ),
			    ),
		    ),
		    'base' => '/bdl',
	    );
	    
	    if( $this->hasUserRole('3') ) {
		    
		    $menu['items'][] = array(
			    'id' => 'bdl_temp_items',
			    'label' => 'Tworzenie wskaźników',
		    );
		    
	    }
	    
	    if( count($menu['items'])===1 )
	    	return array();
	    else 
	    	return $menu;	    
	    
    }

} 