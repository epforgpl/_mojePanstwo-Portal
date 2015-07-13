<?php

App::uses('DataobjectsController', 'Dane.Controller');

class GminyOkregiWyborczeController extends DataobjectsController
{
    public $menu = array();

    public $objectOptions = array(
        'hlFields' => array(),
        'bigTitle' => true,
    );

    public function view()
    {

        parent::view();
        $this->redirect('/dane/gminy/' . $this->object->getData('gmina_id') . '/okregi_wyborcze/' . $this->object->getId());

    }
} 