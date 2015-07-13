<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrakowKomisjeController extends DataobjectsController
{
    public function view()
    {

        parent::view();
        $this->redirect('/dane/gminy/903/komisje/' . $this->object->getId());

    }
} 