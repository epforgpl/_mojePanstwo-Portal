<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrakowPosiedzeniaPunktyController extends DataobjectsController
{
    public function view()
    {
        parent::_prepareView();

        $this->redirect('/dane/gminy/903/punkty/' . $this->object->getId());
        die();

    }
} 