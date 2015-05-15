<?php

App::uses('ApplicationsController', 'Controller');
class ZamowieniaPubliczneController extends ApplicationsController
{
	
    public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'href' => 'zamowienia_publiczne',
				'label' => 'Zamówienia',
			),
			/*
			array(
				'id' => 'wykonawcy',
				'href' => 'zamowienia_publiczne/wykonawcy',
				'label' => 'Wykonawcy',
			),
			*/
            array(
                'id' => 'dotacje_unijne',
                'href' => 'zamowienia_publiczne/dotacje_unijne',
                'label' => 'Dotacje unijne',
            ),
		),
		'title' => 'Zamówienia Publiczne',
		'subtitle' => 'Znajdź zamówienie dla swojej firmy - Sprawdzaj kto dostaje zamówienia publiczne',
		'headerImg' => '/zamowienia_publiczne/img/header_zamowienia-publiczne.png',
	);

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/zamowienia_publiczne/img/social/zamowienia.jpg');
    }
	
    public function view()
    {
	    
        $datasets = $this->getDatasets('zamowienia_publiczne');
        
        $options  = array(
            'searchTitle' => 'Szukaj w zamówieniach publicznych...',
            'conditions' => array(
	            'dataset' => array_keys( $datasets )
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'ZamowieniaPubliczne',
		            'element' => 'cover',
	            ),
	            'aggs' => array(
		            'all' => array(
				        'global' => '_empty',
				        'aggs' => array(
					        'dokumenty' => array(
						        'filter' => array(
							        'bool' => array(
								        'must' => array(
									        array(
										        'term' => array(
											        'dataset' => 'zamowienia_publiczne_dokumenty',
										        ),
									        ),
									        array(
										        'term' => array(
											        'data.zamowienia_publiczne_dokumenty.typ_id' => '3',
										        ),
									        ),
									        array(
										        'range' => array(
											        'date' => array(
												        'gt' => 'now-1M'
											        ),
										        ),
									        ),
								        ),
							        ),					        
						        ),
						        'aggs' => array(
							        'wykonawcy' => array(
										'nested' => array(
											'path' => 'zamowienia_publiczne-wykonawcy',
										),
										'aggs' => array(
											'id' => array(								        
										        'terms' => array(
											        'field' => 'zamowienia_publiczne-wykonawcy.id',
											        'order' => array(
												        'cena' => 'desc',
											        ),
											        'size' => 20,
										        ),
										        'aggs' => array(
											        'nazwa' => array(
												        'terms' => array(
													        'field' => 'zamowienia_publiczne-wykonawcy.nazwa',
												        ),
											        ),
											        'miejscowosc' => array(
												        'terms' => array(
													        'field' => 'zamowienia_publiczne-wykonawcy.miejscowosc',
												        ),
											        ),
											        'cena' => array(
												        'sum' => array(
													        'field' => 'zamowienia_publiczne-wykonawcy.cena',
												        ),
											        ),
											        'dokumenty' => array(
												        'reverse_nested' => '_empty',
												        'aggs' => array(
													        'top' => array(
														        'top_hits' => array(
															        'size' => 3,
															        'fielddata_fields' => array('dataset', 'id'),
															        'sort' => array(
																        'zamowienia_publiczne-wykonawcy.cena' => 'desc',
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
    
    public function wykonawcy()
    {
        $this->loadDatasetBrowser('zamowienia_publiczne_wykonawcy');
    }

    public function dotacje_unijne()
    {
	    $this->title = 'Dotacje unijne - Zamówienia publiczne';
        $this->loadDatasetBrowser('dotacje_ue');
    }

} 