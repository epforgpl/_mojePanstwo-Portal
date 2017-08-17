<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PoslowieWyjazdyWydarzenia8Controller extends DataobjectsController
{
    public $menu = array(
        array(
            'id' => 'view',
            'label' => 'Uczestnicy wyjazdu',
        ),
    );
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(),
    );

    public function view()
    {

        $this->addInitLayers(array('uczestnicy'));
        parent::_prepareView();

    }
} 