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
    public $mainMenuLabel = 'Przeglądaj';

	public $menu = array(
		'sa_orzeczenia' => array(
			'id' => 'sa',
			'label' => 'Sądy administracyjne',
			'icon' => 'icon-datasets-sa_orzeczenia',
			'href' => '/orzecznictwo/sa',
		),
		'sp_orzeczenia' => array(
			'id' => 'sp',
			'label' => 'Sądy powszechne',
			'icon' => 'icon-datasets-sp_orzeczenia',
			'href' => '/orzecznictwo/sp',
		),
		'sn_orzeczenia' => array(
			'id' => 'sn',
			'label' => 'Sąd Najwyższy',
			'icon' => 'icon-datasets-sn_orzeczenia',
			'href' => '/orzecznictwo/sn',
		),
	);
	
    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('orzecznictwo');
        $_datasets = array_keys($datasets);
				
        $options = array(
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
                    'sa_orzeczenia' => array(
                        'filter' => array(
                            'term' => array(
                                'dataset' => 'sa_orzeczenia',
                            ),
                        ),
                        'aggs' => array(
                            'skarzone_organy' => array(
                                'terms' => array(
                                    'field' => 'data.sa_orzeczenia.skarzony_organ_id',
                                ),
                                'aggs' => array(
                                    'label' => array(
                                        'terms' => array(
                                            'field' => 'data.sa_orzeczenia.skarzony_organ_str',
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
                        'target' => 'menu',
                    ),
                ),
            ),
            'perDatasets' => true,

        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

} 