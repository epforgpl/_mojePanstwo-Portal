<?php

App::uses('DocsObjectsController', 'Dane.Controller');

class RadyDrukiController extends DocsObjectsController
{

    public $objectOptions = array(
        'bigTitle' => true,
    );

    public function view()
    {

        parent::_prepareView();
        $this->redirect('/dane/gminy/' . $this->object->getData('gminy.id') . '/druki/' . $this->object->getId());
        die();

    }

} 