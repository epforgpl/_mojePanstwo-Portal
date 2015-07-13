<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrakowOswiadczeniaController extends DataobjectsController
{
    public function view()
    {

        parent::view();
        $this->redirect('/dane/gminy/903/oswiadczenia/' . $this->object->getId());

    }
} 