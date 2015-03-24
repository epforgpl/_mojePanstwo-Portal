<?php

App::uses('ApplicationsController', 'Controller');
class BdlWskaznikiController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Wskaźniki',
			),
			array(
				'id' => 'kategorie',
				'label' => 'Kategorie',
			),
            array(
                'id' => 'grupy',
                'label' => 'Grupy',
            ),
		),
		'title' => 'Bank danych lokalnych',
		'subtitle' => 'Dane gospodarcze o firmach i osobach',
		'headerImg' => 'krs',
	);
	
    public function view()
    {
        $this->setMenuSelected();
        $this->loadDatasetBrowser('bdl_wskazniki');
    }

    public function kategorie()
    {
	    $this->loadDatasetBrowser('bdl_wskazniki_kategorie');
    }

    public function grupy()
    {
        $this->loadDatasetBrowser('bdl_wskazniki_grupy');
    }

} 