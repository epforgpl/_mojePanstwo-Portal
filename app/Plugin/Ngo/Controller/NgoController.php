<?php

App::uses('ApplicationsController', 'Controller');
class NgoController extends ApplicationsController
{

	public $settings = array(
        'id' => 'ngo',
		'title' => 'NGO',
		'subtitle' => 'Organizacje pozarządowe w Polsce',
		'headerImg' => 'ngo',
	);
	
	public $appDatasets = array(
		'sp' => array(
			'dataset' => 'sp_orzeczenia',
			'label' => 'Sądy powszechne',
			'searchTitle' => 'Szukaj w orzeczeniach sądów powszechnych...',
		),
		'sa' => array(
			'dataset' => 'sa_orzeczenia',
			'label' => 'Sądy administracyjne',
			'searchTitle' => 'Szukaj w orzeczeniach sądów administracyjnych...',
		),
		'sn' => array(
			'dataset' => 'sn_orzeczenia',
			'label' => 'Sąd Najwyższy',
			'searchTitle' => 'Szukaj w orzeczeniach Sądu Najwyższego...',
		),
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
            'searchTitle' => 'Szukaj organizacji pozarządowej...',
            'autocompletion' => array(
	            'dataset' => implode(',', $_datasets),
            ),
            'conditions' => array(
	            'dataset' => $_datasets,
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Ngo',
		            'element' => 'cover',
	            ),
	            'aggs' => array(
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