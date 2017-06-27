<?php

App::uses('DataobjectsController', 'Dane.Controller');

class MsigPozycjeController extends DataobjectsController
{

	public $initLayers = array('data');
    
    public function view()
    {

        parent::load();
        
        if( $this->object->getData('krs_id') ) {
	        return $this->redirect('/dane/krs_podmioty/' . $this->object->getData('krs_id') . '/ogloszenia/' . $this->object->getId());
	    }

    }
}