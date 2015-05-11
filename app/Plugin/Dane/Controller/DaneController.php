<?php

App::uses('ApplicationsController', 'Controller');
class DaneController extends ApplicationsController
{
	
    public $settings = array(
		'title' => 'Dane',
		'subtitle' => 'Przeszukuj największą bazę danych publicznych w Polsce',
		'headerImg' => 'dane',
	);
	
    public function view()
    {
        
        $apps = $this->getDatasets();
        $aggs = array();
        foreach( $apps as $app_id => $datasets ) {
	        $aggs[ 'app_' . $app_id ] = array(
		        'filter' => array(
			        'terms' => array(
				        'dataset' => array_keys( $datasets ),
			        ),
		        ),
	        );
        }
        
        $options  = array(
            'searchTitle' => 'Szukaj w danych publicznych...',
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Dane',
		            'element' => 'cover',
	            ),
            ),
            'aggs' => $aggs,
            'aggs-mode' => 'apps',
        );
        
	    $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
                
    }
    
    public function zbiory()
    {

        $this->title = 'Zbiory danych publicznych';
        $this->loadDatasetBrowser('zbiory', array(
	        'conditions' => array(
		        'dataset' => 'zbiory',
		        'zbiory.katalog' => '1',
	        ),
	        'order' => '_title asc',
	        'limit' => 99,
        ));
                        
    }

} 