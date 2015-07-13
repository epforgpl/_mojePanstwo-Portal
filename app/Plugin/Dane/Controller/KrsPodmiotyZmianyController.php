<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrsPodmiotyZmianyController extends DataobjectsController
{

    public function view()
    {

        $this->_prepareView();
        return $this->redirect($this->object->getUrl());


    }


}