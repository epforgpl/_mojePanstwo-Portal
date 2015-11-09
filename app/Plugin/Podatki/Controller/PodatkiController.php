<?php

App::uses('ApplicationsController', 'Controller');

class PodatkiController extends ApplicationsController
{
    public $settings = array(
        'id' => 'podatki',
        'title' => 'Podatki',
    );

    public function view()
    {
		
		/*
        $datasets = $this->getDatasets('prawo');

        $options = array(
            'searchTag' => array(
                'href' => '/podatki',
                'label' => 'Podatki',
            ),
            'searchTitle' => 'Szukaj w prawie...',
            'autocompletion' => array(
                'dataset' => implode(',', array_keys($datasets)),
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Podatki',
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
            $data = $this->Podatki->getData();
            $this->set('data', $data);

        }

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
        */
    }

    public function results()
    {

        $datasets = $this->getDatasets('prawo');

        $options = array(
            'searchTag' => array(
                'href' => '/podatki',
                'label' => 'Podatki',
            ),
            'searchTitle' => 'Szukaj w prawie...',
            'autocompletion' => array(
                'dataset' => implode(',', array_keys($datasets)),
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Podatki',
                    'element' => 'results',
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
            $data = $this->Podatki->getData();
            $this->set('data', $data);

        }

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }
}
