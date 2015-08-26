<?php

App::uses('ApplicationsController', 'Controller');

class FinanseController extends ApplicationsController
{

    public $settings = array(
        'id' => 'finanse',
        'title' => 'Finanse',
        'subtitle' => 'Przeglądaj informacje o finansach Polski',
    );

    public $mainMenuLabel = 'Przeglądaj';
	
	public function centralne()
	{
		
		
		
	}
	
	public function budzety()
	{
        $this->loadDatasetBrowser('budzety');
	}
	
    public function view()
    {
        $datasets = $this->getDatasets('bdl');
				
        $options = array(
            'searchTitle' => 'Szukaj w Finansach...',
            'autocompletion' => array(
                'dataset' => 'bdl_wskazniki',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Finanse',
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

} 