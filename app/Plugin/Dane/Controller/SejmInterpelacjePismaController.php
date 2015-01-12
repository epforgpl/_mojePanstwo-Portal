<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class SejmInterpelacjePismaController extends DocsObjectsController
{


    public function view()
    {

        parent::_prepareView();
        $this->redirect($this->object->getUrl());
        die();

    }

} 