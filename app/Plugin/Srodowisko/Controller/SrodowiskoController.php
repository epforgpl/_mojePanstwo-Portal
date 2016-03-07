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
	            	'stacje' => array(
		            	'filter' => array(
			            	'term' => array(
				            	'dataset' => 'srodowisko_stacje_pomiarowe',
			            	),
		            	),
		            	'scope' => 'global',
		            	'aggs' => array(
			            	'top' => array(
				            	'top_hits' => array(
					            	'size' => 10,
					            	'_source' => array('data'),
				            	),
			            	),
		            	),
	            	),
	            	/*
	            	'pomiary' => array(
		            	'nested' => array(
			            	'path' => 'stacje_pomiarowe-pomiary',
		            	),
		            	'aggs' => array(
			            	'filtered' => array(
				            	'filter' => array(
					            	'term' => array(
						            	'stacje_pomiarowe-pomiary.param' => 'CO',
					            	),
				            	),
				            	'aggs' => array(
					            	'worst' => array(
						            	'terms' => array(
							            	'field' => 'stacje_pomiarowe-pomiary.station_id',
							            	'order' => array(
								            	'value' => 'desc',
							            	),
							            	'size' => 3,
						            	),
						            	'aggs' => array(
							            	'value' => array(
								            	'sum' => array(
									            	'field' => 'stacje_pomiarowe-pomiary.value'
								            	),
							            	),
							            	'stacje' => array(
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
					            	'best' => array(
						            	'terms' => array(
							            	'field' => 'stacje_pomiarowe-pomiary.station_id',
							            	'order' => array(
								            	'value' => 'asc',
							            	),
							            	'size' => 3,
						            	),
						            	'aggs' => array(
							            	'value' => array(
								            	'sum' => array(
									            	'field' => 'stacje_pomiarowe-pomiary.value'
								            	),
							            	),
							            	'stacje' => array(
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
	            	*/              
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