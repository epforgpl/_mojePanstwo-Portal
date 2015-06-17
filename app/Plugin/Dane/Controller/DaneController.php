<?php

App::uses('ApplicationsController', 'Controller');

class DaneController extends ApplicationsController
{

    public $settings = array(
        'id' => 'dane',
        'title' => 'Dane',
        'subtitle' => 'Przeszukuj największą bazę danych publicznych w Polsce',
        'headerImg' => 'dane',
    );
    
    public $mainMenuLabel = 'Szukaj';
    public $appSelected = 'search';

    public function view()
    {
		
		if(
			isset( $this->request->query['q'] ) && 
			!empty( $this->request->query['q'] )
		) {
		
	        $apps = $this->getDatasets();
	        $aggs = array();
	        foreach ($apps as $app_id => $datasets) {
	            $aggs['app_' . $app_id] = array(
	                'filter' => array(
	                    'terms' => array(
	                        'dataset' => array_keys($datasets),
	                    ),
	                ),
	            );
	        }
	
	        $options = array(
	            'searchTitle' => 'Szukaj w danych publicznych...',
	            'cover' => array(
	                'view' => array(
	                    'plugin' => 'Dane',
	                    'element' => 'cover',
	                ),
	            ),
	            'aggs' => $aggs,
	            'aggs-mode' => 'apps',
	        );
	
	        $this->Components->load('Dane.DataBrowser', $options);
	        $this->render('Dane.Elements/DataBrowser/browser-from-app');
        
        } else {
	        
	        return $this->redirect('/');
	        
        }

    }

    public function zbiory()
    {

        $this->title = 'Zbiory danych publicznych';
        $this->loadDatasetBrowser('zbiory', array(
            'conditions' => array(
                'dataset' => 'zbiory',
                'zbiory.katalog' => '1',
            ),
            'order' => '_title asc',
            'limit' => 99,
        ));

    }

    public function action()
    {

        if (
        isset($this->request->params['id'])
        ) {

            if (
                ($dataset_info = $this->getDataset($this->request->params['id'])) &&
                @$dataset_info['dataset_name']['menu_id']
            ) {

                $url = '/' . $dataset_info['app_id'] . '/' . $dataset_info['dataset_name']['menu_id'] . '?' . http_build_query($this->request->query);
                return $this->redirect($url);

            }

            $fields = array('searchTitle', 'order');
            $params = array();

            foreach ($fields as $field)
                if (isset($data[$field]))
                    $params[$field] = $data[$field];

            $this->menu_selected = $this->request->params['id'];
            $this->loadDatasetBrowser($this->request->params['id'], $params);

        }

    }

    public function getMenu()
    {
        return array();
    }

} 