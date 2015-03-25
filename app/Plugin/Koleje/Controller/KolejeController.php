<?php

App::uses('ApplicationsController', 'Controller');
class KolejeController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Stacje',
			),
			array(
				'id' => 'linie',
				'label' => 'Linie',
			),
		),
		'title' => 'Koleje',
		'subtitle' => 'Koleje',
		'headerImg' => 'kolej',
	);
	
    public function view()
    {
        $this->setMenuSelected();
        $this->title = 'Stacje kolejowe w Polsce';
        $this->loadDatasetBrowser('kolej_stacje');
    }

    public function linie()
    {
	    $this->title = 'Linie kolejowe w Polsce';
        $this->loadDatasetBrowser('kolej_linie');
    }
} 