<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PanstwaController extends DataobjectsController
{
    public $initLayers = array('stats');

    public function view()
    {
        parent::_prepareView();
		
    }

} 