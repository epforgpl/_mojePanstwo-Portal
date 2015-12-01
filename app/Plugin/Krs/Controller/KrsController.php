<?php

App::uses('ApplicationsController', 'Controller');

class KrsController extends ApplicationsController
{

    public $settings = array(
        'id' => 'krs',
        'title' => 'Krajowy Rejestr Sądowy',
        'shortTitle' => 'KRS',
        'subtitle' => 'Dane gospodarcze o firmach i osobach',
        'headerImg' => 'krs',
    );

    public $mainMenuLabel = 'Przeglądaj';

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/krs/img/social/krs.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('krs');

        $options = array(
            'searchTag' => array(
	            'href' => '/krs',
	            'label' => 'KRS',
            ),
            'autocompletion' => array(
                'dataset' => 'krs_podmioty,krs_osoby',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Krs',
                    'element' => 'cover',
                ),
                'aggs' => array(
                    'krs_podmioty' => array(
                        'filter' => array(
                            'term' => array(
                                'dataset' => 'krs_podmioty',
                            ),
                        ),
                        'aggs' => array(
                            'typ_id' => array(
                                'terms' => array(
                                    'field' => 'data.krs_podmioty.forma_prawna_id',
                                    'exclude' => array(
                                        'pattern' => '0'
                                    ),
                                    'size' => 12,
                                ),
                                'aggs' => array(
                                    'label' => array(
                                        'terms' => array(
                                            'field' => 'data.krs_podmioty.forma_prawna_str',
                                        ),
                                    ),
                                ),
                            ),
                            'kapitalizacja' => array(
                                'range' => array(
                                    'field' => 'data.krs_podmioty.wartosc_kapital_zakladowy',
                                    'ranges' => array(
                                        array('from' => 1, 'to' => 5000),
                                        array('from' => 5000, 'to' => 10000),
                                        array('from' => 10000, 'to' => 50000),
                                        array('from' => 50000, 'to' => 100000),
                                        array('from' => 100000, 'to' => 500000),
                                        array('from' => 500000, 'to' => 1000000),
                                        array('from' => 1000000, 'to' => 5000000),
                                        array('from' => 5000000, 'to' => 10000000),
                                        array('from' => 10000000),
                                    ),
                                ),
                            ),
                            'date' => array(
                                'date_histogram' => array(
                                    'field' => 'date',
                                    'interval' => 'year',
                                    'format' => 'yyyy-MM-dd',
                                ),
                            ),
                        ),
                    ),
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
        $this->title = 'Organizacje zarejestrowane w Krajowym Rejestrze Sądowym';
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

} 