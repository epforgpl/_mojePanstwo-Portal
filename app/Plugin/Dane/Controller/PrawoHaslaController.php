<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PrawoHaslaController extends DataobjectsController
{

    public $headerObject = array('url' => '/dane/img/headers/prawne.jpg', 'height' => '250px');

    public $objectOptions = array(
        'hlFields' => array(),
    );

    public function view()
    {
		
		$this->addInitLayers('tags');
		
        parent::load();     
        $this->feed();

    }

    public function beforeRender()
    {

		parent::beforeRender();

        // PREPARE MENU
        $href_base = '/dane/prawo_hasla/' . $this->request->params['id'];

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Aktualności',
                    'icon' => 'glyphicon glyphicon-feed',
                ),
            )
        );

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];
        $this->set('_menu', $menu);

    }
} 