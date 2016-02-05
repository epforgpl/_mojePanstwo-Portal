<?php

App::uses('ApplicationsController', 'Controller');

class SrodowiskoController extends ApplicationsController
{

    public $settings = array(
        'id' => 'srodowisko',
        'title' => 'Środowisko',
    );    

    public function view()
    {

        $datasets = $this->getDatasets('srodowisko');

        $options = array(
            'searchTitle' => 'Szukaj stacji pomiarowych...',
            'autocompletion' => array(
                'dataset' => implode(',', array_keys($datasets)),
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Srodowisko',
                    'element' => 'cover',
                ),
                'aggs' => array(
	                'pomiary' => array(
		                'nested' => array(
			                'path' => 'stacje_pomiarowe-pomiary',
		                ),
		                'aggs' => array(
			                'best' => array(
				                'terms' => array(
					                'field' => 'stacje_pomiarowe-pomiary.station_id',
					                'order' => array(
						                'value' => 'desc',
					                ),
					                'size' => 5,
				                ),
				                'aggs' => array(
					                'value' => array(
						                'sum' => array(
							                'field' => 'stacje_pomiarowe-pomiary.value',
						                ),
					                ),
					                'reverse' => array(
						                'reverse_nested' => '_empty',
						                'aggs' => array(
							                'label' => array(
								                'terms' => array(
									                'field' => 'data.srodowisko_stacje_pomiarowe.nazwa',
									                'size' => 1,
								                ),
							                ),
						                ),
					                ),
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
                    ),
                ),
            ),
            'apps' => true,
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }
    
    public function stacje_pomiarowe()
    {
	    $this->title = 'Stacje pomiarowe | Środowisko';
        $this->loadDatasetBrowser('srodowisko_stacje_pomiarowe', array());
    }

}