<?php

App::uses('DataobjectsController', 'Dane.Controller');

class MiejscowosciController extends DataobjectsController
{

    public function view()
    {
        parent::view();
        $this->redirect('/dane/gminy/' . $this->object->getData('gmina_id') . '/miejscowosci/' . $this->object->getId());
    }

} 