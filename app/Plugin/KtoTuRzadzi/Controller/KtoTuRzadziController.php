<?php

App::uses('ApplicationsController', 'Controller');
class KtoTuRzadziController extends ApplicationsController
{
	
    public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'href' => 'kto_tu_rzadzi',
				'label' => 'Urzędy',
			),
			array(
				'id' => 'urzednicy',
				'href' => 'kto_tu_rzadzi/urzednicy',
				'label' => 'Urzędnicy',
			),
		),
		'title' => 'Kto tu rządzi?',
		'subtitle' => 'Urzędy i urzędnicy w Polsce',
		'headerImg' => '/kto_tu_rzadzi/img/header_kto-tu-rzadzi.png',
	);
	
    public function view()
    {
        
        $this->setMenuSelected();
        $this->loadDatasetBrowser('instytucje');
                
    }
    
    public function urzednicy()
    {
        
        $this->loadDatasetBrowser('urzednicy');
                
    }

} 