<?php

App::uses('ApplicationsController', 'Controller');

class KolejeController extends ApplicationsController
{

    public $settings = array(
        'menu' => array(
            array(
                'id' => 'linie',
                'label' => 'Linie',
            ),
            array(
                'id' => '',
                'label' => 'Stacje',
            ),
        ),
        'title' => 'Koleje',
        // 'subtitle' => 'Koleje',
        'headerImg' => 'kolej',
    );

    public function view()
    {
        $this->setMenuSelected();
        $this->title = 'Linie kolejowe w Polsce';
        $this->loadDatasetBrowser('kolej_linie');

    }

    public function linie()
    {
        $this->title = 'Stacje kolejowe w Polsce';
        $this->loadDatasetBrowser('kolej_stacje');
    }
} 