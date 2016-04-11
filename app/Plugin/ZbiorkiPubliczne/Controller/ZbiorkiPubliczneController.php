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
        if (isset($this->data) && !empty($this->data)) {
            $this->set('edit', $this->data);
        }
    }

    public function formularz()
    {
        $this->set('title_for_layout', 'Zbiórka publiczna - Formularz');
    }
}
