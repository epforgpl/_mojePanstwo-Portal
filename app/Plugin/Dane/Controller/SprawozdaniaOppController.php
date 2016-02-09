<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SprawozdaniaOppController extends DataobjectsController
{
    
    public function view() {
        $this->_prepareView();
        return $this->redirect( $this->object->getUrl() );
    }

}