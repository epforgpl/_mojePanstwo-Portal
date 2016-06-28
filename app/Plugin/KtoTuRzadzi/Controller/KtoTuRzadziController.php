<?php

App::uses('ApplicationsController', 'Controller');

class KtoTuRzadziController extends ApplicationsController
{

    public $settings = array(
        'id' => 'kto_tu_rzadzi',
        'title' => 'Kto tu rządzi?',
        'subtitle' => 'Urzędy i urzędnicy w Polsce',
        'headerImg' => '/kto_tu_rzadzi/img/header_kto-tu-rzadzi.png',
    );
    
    public $mainMenuLabel = 'Przeglądaj';
    
    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/kto_tu_rzadzi/img/social/ktoturzadzi.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('kto_tu_rzadzi');

        $options = array(
            'searchTag' => array(
	            'href' => '/kto_tu_rzadzi',
	            'label' => 'Kto tu rządzi?',
            ),
            'searchTitle' => 'Szukaj instytucji i urzędników i jednostki samorządu terytorialnego...',
            'autocompletion' => array(
                'dataset' => implode(',', array_keys($datasets)),
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
	            'cache' => true,
                'view' => array(
                    'plugin' => 'KtoTuRzadzi',
                    'element' => 'cover',
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

        if (!isset($this->request->query['q'])) {

            $data = $this->KtoTuRzadzi->getData();
            $this->set('data', $data);

        }

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }
    
    public function getChapters() {

		$mode = false;
		$items = array(
			array(
				'id' => 'instytucje',
				'href' => '/kto_tu_rzadzi/instytucje',
				'label' => 'Instytucje',
				'icon' => 'icon-datasets-instytucje',
			),
			array(
				'id' => 'urzednicy',
				'href' => '/kto_tu_rzadzi/urzednicy',
				'label' => 'Urzędnicy',
				'icon' => 'icon-datasets-urzednicy',
			),
			array(
				'id' => 'gminy',
				'href' => '/kto_tu_rzadzi/gminy',
				'label' => 'Gminy',
				'icon' => 'dot',
			),
			array(
				'id' => 'powiaty',
				'href' => '/kto_tu_rzadzi/powiaty',
				'label' => 'Powiaty',
				'icon' => 'dot',
			),
			array(
				'id' => 'wojewodztwa',
				'href' => '/kto_tu_rzadzi/wojewodztwa',
				'label' => 'Województwa',
				'icon' => 'dot',
			),
		);

        $output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}
	
	public function urzednicy() {
		
		$this->loadDatasetBrowser('urzednicy', array(
            'browserTitle' => 'Urzędnicy:',
            'default_conditions' => array(
	            'urzednicy.stanowisko_aktywne' => '1',
            ),
        ));
        $this->set('title_for_layout', 'Urzędnicy | Kto Tu Rządzi?');
		
	}

}