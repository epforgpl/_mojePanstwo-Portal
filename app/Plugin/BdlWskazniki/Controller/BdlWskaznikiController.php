<?php

App::uses('ApplicationsController', 'Controller');
class KrsController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Organizacje',
			),
			array(
				'id' => 'osoby',
				'label' => 'Osoby',
			),
		),
		'title' => 'Krajowy Rejestr Sądowy',
		'subtitle' => 'Dane gospodarcze o firmach i osobach',
		'headerImg' => 'krs',
	);
	
    public function view()
    {
        
        $this->setMenuSelected();
        $this->loadDatasetBrowser('krs_podmioty');
                
    }

    public function osoby()
    {
	    $this->loadDatasetBrowser('krs_osoby');
    }
    

} 