<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KolejStacjeController extends DataobjectsController
{
    public $menu = array(
        array(
            'id' => 'view',
            'label' => 'LC_DANE_LOKALIZACJA_STACJI',
        ),
        /*
        array(
            'id' => 'linie',
            'label' => 'LC_DANE_LINIE'
        )
        */
    );

    public function linie()
    {

        $this->addInitLayers(array('linie'));

        parent::view();

        $ids = array();
        foreach ($this->object->layers['linie'] as $linia) {
            array_push($ids, $linia['a']['id']);
        }
        $this->innerSearch('kolej_linie', array(
            'object_id' => $ids,
        ));
    }
} 