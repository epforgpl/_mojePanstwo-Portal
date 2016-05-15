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
            'searchTitle' => 'Szukaj instytucji i urzędników...',
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
            'apps' => true,
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
		);

        $output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}

}