<?php

App::uses('DataobjectsController', 'Dane.Controller');

class RadyPosiedzeniaController extends DataobjectsController
{

    public $menu = array();
    public $objectOptions = array(
        'hlFields' => array('gminy.rada_nazwa', 'numer'),
    );

    public function view()
    {

        parent::_prepareView();

        $this->redirect('/dane/gminy/' . $this->object->getData('gmina_id') . '/posiedzenia/' . $this->object->getId());
        die();

        $this->dataobjectsBrowserView(array(
            'source' => 'rady_gmin_debaty.posiedzenie_id:' . $this->object->getId(),
            'dataset' => 'rady_gmin_debaty',
            'title' => 'Debaty na tym posiedzeniu',
            'noResultsTitle' => 'Brak debat na tym posiedzeniu',
            /*
            'excludeFilters' => array(
                'grupa_id',
                'kategoria_id',
            ),
            */
            // 'hlFields' => array('numer_punktu', 'opis'),
            'hlFields' => array(),
            'routes' => array(
                'date' => false,
            ),
        ));

    }
} 