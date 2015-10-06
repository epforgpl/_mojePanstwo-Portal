<?php

App::uses('DataobjectsController', 'Dane.Controller');

class MiejscaController extends DataobjectsController
{
    public $menu = array();

    public function view()
    {

        return $this->redirect('/mapa/miejsce/' . $this->request->params['id']);        

    }

} 