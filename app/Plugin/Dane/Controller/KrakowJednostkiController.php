<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrakowJednostkiController extends DataobjectsController
{
    public function view()
    {

        parent::view();
        $this->redirect('/dane/gminy/903/jednostki/' . $this->object->getId());

    }
} 