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
	
	public function kategorie()
	{
				
		$datasets = $this->getDatasets('bdl');
				
        $options = array(
            'searchTitle' => 'Szukaj w Banku Danych Lokalnych...',
            'searchAction' => '/bdl',
            'autocompletion' => array(
                'dataset' => 'bdl_wskazniki',
            ),
            'conditions' => array(
                'dataset' => 'bdl_wskazniki',
                'bdl_wskazniki.kategoria_id'  => $this->request->params['id'],
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Bdl',
                    'element' => 'kategoria',
                ),
                'aggs' => array(
	                'kategorie' => array(
		                'filter' => array(
			                'term' => array(
				                'dataset' => 'bdl_wskazniki_kategorie',
			                ),
		                ),
		                'scope' => 'global',
		                'aggs' => array(
			                'kategoria_id' => array(
				                'terms' => array(
					                'field' => 'id',
					                'size' => 100,
				                ),
				                'aggs' => array(
					                'label' => array(
						                'terms'=> array(
							                'field' => 'title.raw',
							                'size' => 1,
							                'order' => array(
							                	'_term' => 'asc',
							                ),
						                ),
					                ),
				                ),
			                ),
		                ),
		                'visual' => array(
	                        'skin' => 'chapters',
	                        'field' => 'kategoria',
	                        'target' => 'menu',
	                    ),
	                ),
	                'grupy' => array(
		                'terms' => array(
			                'field' => 'bdl_wskazniki.grupa_id',
			                'size' => 100,
		                ),
		                'aggs' => array(
			                'label' => array(
				                'terms' => array(
					                'field' => 'bdl_wskazniki.grupa_tytul_raw',
					                'size' => 1,
				                ),
			                ),
			                'top' => array(
				                'top_hits' => array(
					                'size' => 100,
					                'fielddata_fields' => array('dataset', 'id'),
				                ),
			                ),
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
                        'target' => false,
                    ),
                ),
            ),
            'apps' => true,
            'routes' => array(
	            'kategorie/kategoria_id' => 'kategorie',
	            'kategorie/grupa_id' => 'grupy',
            ),
        );


        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'Bank Danych Lokalnych';
        $this->set('kategoria_id', $this->request->params['id']);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
		
	}
	
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
					                'size' => 100,
				                ),
				                'aggs' => array(
					                'label' => array(
						                'terms'=> array(
							                'field' => 'title.raw',
							                'size' => 1,
							                'order' => array(
							                	'_term' => 'asc',
							                ),
						                ),
					                ),
				                ),
			                ),
		                ),
		                'visual' => array(
	                        'skin' => 'chapters',
	                        'field' => 'kategoria',
	                        'target' => 'menu',
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
                        'target' => false,
                    ),
                ),
            ),
            'apps' => true,
            'routes' => array(
	            'kategorie/id' => 'kategorie',
            ),
        );


        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'Bank Danych Lokalnych - Wskaźniki statystyczne dotyczące sytuacji społecznej i gospodarczej Polski.';
        $this->render('Dane.Elements/DataBrowser/browser-from-app');


    }
    
    public function beforeRender() {
	    
	    parent::beforeRender();
	    
	    if( 
	    	@$this->request->params['id'] && 
	    	( $items = @$this->viewVars['dataBrowser']['aggs']['kategorie']['buckets'] )
	    ) {
	    	foreach( $items as $item ) {
	    		if( $item['key'] == $this->request->params['id'] ) {
		    		
		    		$this->set('title_for_layout', $item['label']['buckets'][0]['key'] . ' - Bank Danych Lokalnych');
		    		break;
		    		
	    		}
	    	}
	    }
	    	    
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