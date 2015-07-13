<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class UmowyController extends DocsObjectsController
{
    public function view()
    {

        parent::_prepareView();
        $this->redirect('/dane/krs_podmioty/' . $this->object->getData('krs_id') . '/umowy/' . $this->object->getId());
        die();

    }
} 


