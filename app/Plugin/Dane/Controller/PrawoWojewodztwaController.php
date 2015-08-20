<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class PrawoWojewodztwaController extends DocsObjectsController
{
    public function view()
    {

        parent::_prepareView();
                
        $this->redirect('/dane/gminy/' . $this->object->getData('gmina_id') . '/prawo/' . $this->object->getId());
        die();

    }
} 