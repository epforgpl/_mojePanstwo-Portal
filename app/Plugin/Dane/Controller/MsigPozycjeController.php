<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class MsigPozycjeController extends DocsObjectsController
{
    public function view()
    {

        parent::load();
        return $this->redirect('/dane/krs_podmioty/' . $this->object->getData('krs_id') . '/ogloszenia/' . $this->object->getId());

    }
}