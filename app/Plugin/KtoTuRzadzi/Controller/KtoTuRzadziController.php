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

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/kto_tu_rzadzi/img/social/ktoturzadzi.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('kto_tu_rzadzi');

        $options = array(
            'searchTitle' => 'Szukaj instytucji publicznych...',
            'autocompletion' => array(
                'dataset' => implode(',', array_keys($datasets)),
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
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
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
        );

        if (!isset($this->request->query['q'])) {

            $data = $this->KtoTuRzadzi->getData();
            $this->set('data', $data);

        }

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

}