<?php

App::uses('ApplicationsController', 'Controller');

class PatentyController extends ApplicationsController
{

    public $settings = array(
        'menu' => array(
            array(
                'id' => '',
                'label' => 'Patenty',
            ),
        ),
        'title' => 'Patenty',
        // 'subtitle' => 'Patenty',
        'headerImg' => 'patenty',
    );

    public function view()
    {
        $this->setMenuSelected();
        $this->loadDatasetBrowser('patenty');
    }
} 