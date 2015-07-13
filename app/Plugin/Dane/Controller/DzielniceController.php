<?php

App::uses('DataobjectsController', 'Dane.Controller');

class DzielniceController extends DataobjectsController
{
    public $menu = array();

    public function view()
    {

        parent::view();
        return $this->redirect('/dane/gminy/' . $this->object->getData('gminy.id') . '/dzielnice/' . $this->object->getId());

    }

} 