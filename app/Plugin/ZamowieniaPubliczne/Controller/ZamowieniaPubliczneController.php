<?php

App::uses('ApplicationsController', 'Controller');

class ZamowieniaPubliczneController extends ApplicationsController
{
	
	public $components = array('RequestHandler');
	public $helpers = array('Dane.Dataobject');
	
    public $settings = array(
        'id' => 'zamowienia_publiczne',
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

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/zamowienia_publiczne/img/social/zamowienia.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('zamowienia_publiczne');

        $options = array(
            'searchTag' => array(
	            'href' => '/zamowienia_publiczne',
	            'label' => 'Zamówienia Publiczne',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
	            'cache' => true,
                'view' => array(
                    'plugin' => 'ZamowieniaPubliczne',
                    'element' => 'cover',
                ),
                'aggs' => array(
                    'zamowienia_publiczne_dokumenty' => array(
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
		                                        'gt' => 'now-1y'
		                                    ),
		                                ),
		                            ),
		                        ),
		                    ),
		                ),
		                'scope' => 'global',
		                'aggs' => array(
		                    'dni' => array(
								'date_histogram' => array(
									'field' => 'date',
									'interval' => 'day',
								),
								'aggs' => array(
									'wykonawcy' => array(
										'nested' => array(
											'path' => 'zamowienia_publiczne-wykonawcy',
										),
										'aggs' => array(
											'waluty' => array(
												'terms' => array(
													'field' => 'zamowienia_publiczne-wykonawcy.waluta',
												),
												'aggs' => array(
													'suma' => array(
														'sum' => array(
															'field' => 'zamowienia_publiczne-wykonawcy.cena',
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
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
            'perDatasets' => true,
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

    public function wykonawcy()
    {
        $this->loadDatasetBrowser('zamowienia_publiczne_wykonawcy');
    }
    
    public function rozstrzygniete()
    {
        
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne_dokumenty',
                'zamowienia_publiczne_dokumenty.typ_id' => '3',
            ),
            'renderFile' => 'zamowienia_publiczne_dokumenty',
            'aggsPreset' => 'zamowienia_publiczne_dokumenty',
        ));
		
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
        
    }

    public function dotacje_unijne()
    {
        $this->title = 'Dotacje unijne - Zamówienia publiczne';
        $this->loadDatasetBrowser('dotacje_ue');
    }
    
    public function aggs()
    {
	    
	    $data = $this->ZamowieniaPubliczne->getDataSource()->request('zamowieniapubliczne/aggs', array(
		    'method' => 'GET',
		    'data' => $this->request->query,
	    ));
	    	    
	    $this->set('data', $data);
	    
	    if( @$this->request->params['ext']=='html' ) {
		    
		    $this->layout = false;
		    $this->view = 'aggs-html';
		    
	    } else {
	    	    	    	    
	        $this->set('_serialize', 'data');
        
        }
	    
    }

} 