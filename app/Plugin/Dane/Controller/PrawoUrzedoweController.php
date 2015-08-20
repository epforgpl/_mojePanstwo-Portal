<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class PrawoUrzedoweController extends DocsObjectsController
{
    public function view()
    {

        parent::_prepareView();
                   
        $this->redirect('/dane/instytucje/' . $this->object->getData('instytucja_id') . '/prawo/' . $this->object->getId());
        die();

    }
} 