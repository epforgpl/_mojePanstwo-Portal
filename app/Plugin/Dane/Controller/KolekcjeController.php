<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KolekcjeController extends DataobjectsController
{

    public $collectionsOptions = false;

    public function view() {
        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'collection_id' => $this->object->getId(),
            ),
        ));
    }

}