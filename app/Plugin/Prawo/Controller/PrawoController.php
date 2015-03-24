<?php

App::uses('ApplicationsController', 'Controller');
class PrawoController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Akty prawne',
			),
			array(
				'id' => 'tematy',
				'label' => 'Tematy',
			),
			array(
				'id' => 'urzedowe',
				'label' => 'Prawo urzędowe',
			),
			array(
				'id' => 'lokalne',
				'label' => 'Prawo lokalne',
			),
            array(
                'id' => 'projekty',
                'label' => 'Projekty aktów prawnych',
            ),
		),
		'title' => 'Prawo',
		'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce',
		'headerImg' => 'prawo',
	);
	
    public function view()
    {
        $this->setMenuSelected();
        $this->loadDatasetBrowser('prawo');
    }

    public function tematy()
    {
	    $this->loadDatasetBrowser('prawo_hasla');
    }
    
    public function urzedowe()
    {
	    $this->loadDatasetBrowser('prawo_urzedowe');
    }
    
    public function lokalne()
    {
	    $this->loadDatasetBrowser('prawo_wojewodztwa');
    }

    public function projekty()
    {
        $this->loadDatasetBrowser('prawo_projekty');
    }

} 