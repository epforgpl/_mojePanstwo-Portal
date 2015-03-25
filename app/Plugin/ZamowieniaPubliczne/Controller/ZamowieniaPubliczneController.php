<?php

App::uses('ApplicationsController', 'Controller');
class ZamowieniaPubliczneController extends ApplicationsController
{
	
    public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'href' => 'zamowienia_publiczne',
				'label' => 'Zamówienia',
			),
			array(
				'id' => 'wykonawcy',
				'href' => 'zamowienia_publiczne/wykonawcy',
				'label' => 'Wykonawcy',
			),
            array(
                'id' => 'dotacje_unijne',
                'href' => 'zamowienia_publiczne/dotacje_unijne',
                'label' => 'Dotacje unijne',
            ),
		),
		'title' => 'Zamówienia Publiczne',
		'subtitle' => 'Znajdź zamówienie dla swojej firmy - Sprawdzaj kto dostaje zamówienia publiczne',
		'headerImg' => '/zamowienia_publiczne/img/header_zamowienia-publiczne.png',
	);
	
    public function view()
    {
        $this->setMenuSelected();
        $this->loadDatasetBrowser('zamowienia_publiczne');
    }
    
    public function wykonawcy()
    {
        $this->loadDatasetBrowser('zamowienia_publiczne_wykonawcy');
    }

    public function dotacje_unijne()
    {
	    $this->title = 'Dotacje unijne - Zamówienia publiczne';
        $this->loadDatasetBrowser('dotacje_ue');
    }

} 