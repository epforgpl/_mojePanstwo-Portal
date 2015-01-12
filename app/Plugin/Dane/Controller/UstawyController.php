<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class UstawyController extends DocsObjectsController
{

    public function view()
    {

        parent::view();
        $this->redirect('/dane/prawo/' . $this->object->getData('prawo.id'));
        die();

    }

} 