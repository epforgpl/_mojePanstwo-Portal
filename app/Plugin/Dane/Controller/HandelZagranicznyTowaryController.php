<?php

App::uses('DataobjectsController', 'Dane.Controller');

class HandelZagranicznyTowaryController extends DataobjectsController
{
    public $initLayers = array('stats');

    public function view()
    {
        parent::_prepareView();
    }

} 