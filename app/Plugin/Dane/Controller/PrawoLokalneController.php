<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class PrawoLokalneController extends DocsObjectsController
{
    public function view()
    {

        parent::_prepareView();
        $this->redirect('/dane/gminy/' . $this->object->getData('gmina_id') . '/rada_uchwaly/' . $this->object->getId());
        die();

    }
} 


