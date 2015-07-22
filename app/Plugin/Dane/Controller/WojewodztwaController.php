<?php

App::uses('DataobjectsController', 'Dane.Controller');

class WojewodztwaController extends DataobjectsController
{

    public function view()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'gminy',
                'gminy.wojewodztwo_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'gminy',
        ));
        $this->set('title_for_layout', __d('dane', 'LC_DANE_GMINY_W_WOJEWODZTWIE') . ' ' . $this->object->getData('nazwa'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function powiaty()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'powiaty',
                'powiaty.wojewodztwo_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'powiaty',
        ));
        $this->set('title_for_layout', 'Powiaty w województwie ' . $this->object->getData('nazwa'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function miejscowosci()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'miejscowosci',
                'miejscowosci.wojewodztwo_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'miejscowosci',
        ));
        $this->set('title_for_layout', 'Powiaty w województwie ' . $this->object->getData('nazwa'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function beforeRender()
    {

        // PREPARE MENU
        $href_base = '/dane/wojewodztwa/' . $this->request->params['id'];

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Gminy',
                ),
                array(
                    'id' => 'powiaty',
                    'href' => $href_base . '/powiaty',
                    'label' => 'Powiaty',
                ),
                array(
                    'id' => 'miejscowosci',
                    'href' => $href_base . '/miejscowosci',
                    'label' => 'Miejscowości',
                ),
            )
        );

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];
        $this->menu = $menu;
        parent::beforeRender();

    }
} 