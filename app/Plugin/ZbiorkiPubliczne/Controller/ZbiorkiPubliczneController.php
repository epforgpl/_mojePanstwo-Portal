<?php

App::uses('ApplicationsController', 'Controller');

class ZbiorkiPubliczneController extends ApplicationsController
{

    public $settings = array(
        'id' => 'zbiorki_publiczne',
        'title' => 'Zbiórki publiczne'
    );

    public function getMenu()
    {
        return false;
    }

    public function index()
    {
        $this->set('title_for_layout', 'Zbiórka publiczna');
    }

    public function formularz()
    {
        $this->set('title_for_layout', 'Zbiórka publiczna - Formularz');
    }
}
