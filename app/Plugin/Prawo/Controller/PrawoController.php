<?php

App::uses('ApplicationsController', 'Controller');
class PrawoController extends ApplicationsController
{

	public $settings = array(
        'id' => 'prawo',
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Akty prawne',
			),
			array(
				'id' => 'tematy',
				'label' => 'Tematy',
			),
			array(
				'id' => 'urzedowe',
				'label' => 'Prawo urzędowe',
			),
			array(
				'id' => 'lokalne',
				'label' => 'Prawo lokalne',
			),
			/*
            array(
                'id' => 'projekty',
                'label' => 'Projekty aktów prawnych',
            ),
            */
		),
		'title' => 'Prawo',
		'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce',
		'headerImg' => 'prawo',
	);

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function view()
    {
	    
	    $datasets = $this->getDatasets('prawo');
	    $_datasets = array_keys($datasets);
	    
        $options  = array(
            'searchTitle' => 'Szukaj w prawie powszechnym, lokalnym, urzędowym oraz orzeczeniach sądowych...',
            'autocompletion' => array(
	            'dataset' => implode(',', $_datasets),
            ),
            'conditions' => array(
	            'dataset' => $_datasets,
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Prawo',
		            'element' => 'cover',
	            ),
	            'aggs' => array(
					'prawo_obowiazujace' => array(
						'filter' => array(
							'bool' => array(
								'must' => array(
									array(
										'term' => array(
											'dataset' => 'prawo',
										),
									),
									array(
										'term' => array(
											'data.prawo.status_id' => '1',
										),
									),
								),
							),
						),
						'aggs' => array(
							'typ_id' => array(
					            'terms' => array(
						            'field' => 'prawo.typ_id',
						            'exclude' => array(
							            'pattern' => '0'
						            ),
					            ),
					            'aggs' => array(
						            'label' => array(
							            'terms' => array(
								            'field' => 'data.prawo.typ_nazwa',
							            ),
						            ),
					            ),
					        ),
					        'autor_id' => array(
					            'terms' => array(
						            'field' => 'prawo.autor_id',
						            'exclude' => array(
							            'pattern' => '0'
						            ),
					            ),
					            'aggs' => array(
						            'label' => array(
							            'terms' => array(
								            'field' => 'data.prawo.autor_nazwa',
							            ),
						            ),
					            ),
					        ),
						),
					),
					'prawo' => array(
						'filter' => array(
							'bool' => array(
								'must' => array(
									array(
										'term' => array(
											'dataset' => 'prawo',
										),
									),
								),
							),
						),
						'aggs' => array(
					        'date' => array(
					            'date_histogram' => array(
						            'field' => 'date',
						            'interval' => 'year',
						            'format' => 'yyyy-MM-dd',
					            ),
					        ),
					        'wejda' => array(
						        'filter' => array(
							        'bool' => array(
								        'must' => array(
									        array(
										        'range' => array(
											        'data.prawo.data_wejscia_w_zycie' => array(
												        'gte' => 'now',
											        ),
										        ),
									        ),
								        ),
							        ),
						        ),
						        'aggs' => array(
							        'top' => array(
								        'top_hits' => array(
									        'size' => 5,
									        'fielddata_fields' => array('dataset', 'id'),
									        'sort' => array(
										        'data.prawo.data_wejscia_w_zycie' => array(
											        'order' => 'asc',
										        ),
									        ),
								        ),
							        ),
						        ),
					        ),
					        'weszly' => array(
						        'filter' => array(
							        'bool' => array(
								        'must' => array(
									        array(
										        'range' => array(
											        'data.prawo.data_wejscia_w_zycie' => array(
												        'lt' => 'now',
											        ),
										        ),
									        ),
								        ),
							        ),
						        ),
						        'aggs' => array(
							        'top' => array(
								        'top_hits' => array(
									        'size' => 5,
									        'fielddata_fields' => array('dataset', 'id'),
									        'sort' => array(
										        'data.prawo.data_wejscia_w_zycie' => array(
											        'order' => 'desc',
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

    public function tematy()
    {
	    $this->title = 'Tematy w prawie | Prawo';
	    $this->loadDatasetBrowser('prawo_hasla');
    }
    
    public function urzedowe()
    {
	    $this->title = 'Prawo urzędowe | Prawo';
	    $this->loadDatasetBrowser('prawo_urzedowe');
    }
    
    public function lokalne()
    {
	    $this->title = 'Prawo lokalne | Prawo';
	    $this->loadDatasetBrowser('prawo_wojewodztwa');
    }

    public function projekty()
    {
        $this->loadDatasetBrowser('prawo_projekty', array(
	        'renderFile' => 'prawo_projekty',
        ));
    }

} 