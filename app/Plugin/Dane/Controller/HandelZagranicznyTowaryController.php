<?php

App::uses('DataobjectsController', 'Dane.Controller');

class HandelZagranicznyTowaryController extends DataobjectsController
{
    public $initLayers = array('stats');

    public function view()
    {
        parent::_prepareView();
    }
	
	public function beforeRender()
    {

        // debug( $this->object->getData() ); die();

        // PREPARE MENU
        $href_base = '/dane/handel_zagraniczny_towary/' . $this->request->params['id'] . ',' . $this->object->getSlug();

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Handel zagraniczny',
                    // 'icon' => 'glyphicon glyphicon-feed',
                ),
            )
        );

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];
        $this->set('_menu', $menu);

    }
} 