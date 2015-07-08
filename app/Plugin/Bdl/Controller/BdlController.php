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

        if (!isset($this->request->query['q']) || empty($this->request->query['q'])) {
						
            $tree = Cache::read('BDL.tree', 'long');
            if (!$tree) {
                $this->loadModel('Bdl.BDL');
                $tree = $this->BDL->getTree();
                Cache::write('BDL.tree', $tree, 'long');
            }
            
            $this->set('tree', $tree);

        }

        $BdlTempItems = CakeSession::read('TempItems');;
        $this->set(array(
            'BdlTempItems' => $BdlTempItems,
            '_serialize' => array('BdlTempItems')
        ));

        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'Bank Danych Lokalnych';
        $this->render('Dane.Elements/DataBrowser/browser-from-app');




    }
    
    
    public function getMenu() {
	    return false;

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