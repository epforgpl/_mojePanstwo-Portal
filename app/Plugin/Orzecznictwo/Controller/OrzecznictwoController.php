<?php

App::uses('ApplicationsController', 'Controller');
class OrzecznictwoController extends ApplicationsController
{

	public $settings = array(
        'id' => 'orzecznictwo',
		'title' => 'Orzecznictwo',
		'subtitle' => 'Orzeczenia sądów w Polsce w Polsce',
		'headerImg' => 'orzecznictwo',
	);
	
    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function view()
    {
	    
	    $datasets = $this->getDatasets('orzecznictwo');
	    $_datasets = array_keys($datasets);
	    
        $options  = array(
            'searchTitle' => 'Szukaj w orzecznictwie...',
            'autocompletion' => array(
	            'dataset' => implode(',', $_datasets),
            ),
            'conditions' => array(
	            'dataset' => $_datasets,
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Orzecznictwo',
		            'element' => 'cover',
	            ),
	            'aggs' => array(
					'sa_orzeczenia' => array(
						'filter' => array(
							'term' => array(
								'dataset' => 'sa_orzeczenia',
							),
						),
						'aggs' => array(
					        'hasla' => array(
						        'nested' => array(
							        'path' => 'sa_orzeczenia-hasla',
						        ),
						        'aggs' => array(
							        'id' => array(
								        'terms' => array(
									        'field' => 'sa_orzeczenia-hasla.id',
									        'size' => 20,
								        ),
								        'aggs' => array(
									        'label' => array(
										        'terms' => array(
											        'field' => 'sa_orzeczenia-hasla.nazwa',
										        ),
									        ),
									        /*
									        'dlugosc_rozpatrywania' => array(
										        'reverse_nested' => '_empty',
										        'aggs' => array(
											        'dlugosc' => array(
												        'avg' => array(
													        'field' => 'data.sa_orzeczenia.dlugosc_rozpatrywania',
												        ),
											        ),
										        ),
									        ),
									        */
								        ),
								    ),
						        ),
					        ),
					        'wyniki' => array(
						        'nested' => array(
							        'path' => 'sa_orzeczenia-wyniki',
						        ),
						        'aggs' => array(
							        'id' => array(
								        'terms' => array(
									        'field' => 'sa_orzeczenia-wyniki.id',
								        ),
								        'aggs' => array(
									        'label' => array(
										        'terms' => array(
											        'field' => 'sa_orzeczenia-wyniki.nazwa',
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
			            'label' => 'Zbiory danych',
			            'skin' => 'datasets',
			            'class' => 'special',
		                'field' => 'dataset',
		                'dictionary' => $datasets,
		            ),
		        ),
            ),
        );
        
	    $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

} 