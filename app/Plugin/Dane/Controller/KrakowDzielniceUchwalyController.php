<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrakowDzielniceUchwalyController extends DataobjectsController
{
    public function view()
    {

        parent::view();
        $this->redirect($this->object->getUrl());

    }
} 