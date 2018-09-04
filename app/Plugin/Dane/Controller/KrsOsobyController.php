<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrsOsobyController extends DataobjectsController
{
    public $menu = array();
    public $helpers = array(
        'Time',
    );

    public $components = array(
        'RequestHandler'
    );

    public $objectOptions = array(
        'hlFields' => array(),
    );

    public $initLayers = array('powiazania', 'organizacje');

    public $microdata = array(
        'itemtype' => 'http://schema.org/Person',
        'titleprop' => 'name',
    );
    
    public $noindex = array(752774, 752775);

    public function view()
    {
	    $url = 'https://rejestr.io/krs/osoby/' . $this->request->params['id'];
	    return $this->redirect($url);
	    
        parent::view();
        $powiazania = $this->object->getLayer('powiazania');
		
		/*
        if (
            isset($powiazania['posel_id']) &&
            $powiazania['posel_id']
        ) {

            return $this->redirect('/dane/poslowie/' . $powiazania['posel_id'] . '/finanse');

        }
        */

    }

    /*
        public function graph()
        {
            if ($this->request->params['ext'] == 'json') {

                $this->addInitLayers('graph');
                $this->load();

                $data = $this->object->getLayer('graph');

                $this->set('data', $data);
                $this->set('_serialize', 'data');

            } else {
                return false;
            }
        }*/

    public function graph()
    {
        if (@$this->request->params['ext'] == 'json') {

            $this->addInitLayers('graph');
            $this->_prepareView();
            $data = $this->object->getLayer('graph');

            $this->set('data', $data);
            $this->set('_serialize', 'data');

        } else {

            $this->_prepareView();

        }
    }

    public function beforeRender()
    {

        // PREPARE MENU
        $href_base = $this->object->getUrl();

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Dane',
                ),
            )
        );

        $menu['items'][] = array(
            'id' => 'graph',
            'href' => $href_base . '/graph',
            'label' => 'Powiązania'
        );

        /*
        if( $this->object->getData('liczba_zmian') ) {

            $menu['items'][] = array(
                'id'    => 'historia',
                'href'  => $href_base . '/historia',
                'label' => 'Historia',
                'count' => $this->object->getData('liczba_zmian'),
            );

        }
        */

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];
        $this->set('_menu', $menu);

        $this->menu = $menu;
        parent::beforeRender();

    }
    
    public function getMenu()
    {
	    return array();
    }

}