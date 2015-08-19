<?php

App::uses('ApplicationsController', 'Controller');

class MojaGminaController extends ApplicationsController
{
    public $settings = array(
        'id' => 'moja_gmina',
        'title' => 'Moja gmina',
        // 'subtitle' => 'moja gmina',
        'headerImg' => '/moja_gmina/img/header_moja-gmina.png',
    );


    public $mainMenuLabel = 'Przeglądaj';
    public $components = array('RequestHandler');

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/moja_gmina/img/social/mojagmina.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('moja_gmina');
        
        $options = array(
            'searchTitle' => 'Szukaj gminy...',
            'autocompletion' => array(
                'dataset' => implode(',', array_keys($datasets)),
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'MojaGmina',
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

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');


    }

    public function search()
    {

        $output = array();
        $this->loadModel('Dane.Dataobject');

        $gminy = $this->Dataobject->find('all', array(
            'conditions' => array(
                'dataset' => 'gminy',
                'q' => @$this->request->query['q'],
            ),
            'limit' => 10,
        ));

        foreach ($gminy as $gmina) {
            $output[] = array(
                'id' => $gmina->getId(),
                'nazwa' => $gmina->getData('nazwa'),
                'typ' => $gmina->getData('typ_nazwa'),
            );
        }

        $this->set('output', $output);
        $this->set('_serialize', 'output');

    }
    
} 