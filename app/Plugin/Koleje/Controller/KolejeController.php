<?php

App::uses('ApplicationsController', 'Controller');
class KolejController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Orzeczenia sądów administracyjnych',
			),
			array(
				'id' => 'sedziowie',
				'label' => 'Sędziowie sądów administracyjnych',
			),
            array(
                'id' => 'sn_orzeczenia',
                'label' => 'Orzeczenia Sądu Najwyższego',
            ),
            array(
                'id' => 'sp_orzeczenia',
                'label' => 'Orzeczenia Sądów Powszechnych',
            )
		),
		'title' => 'Koleje',
		'subtitle' => 'Kolej',
		'headerImg' => 'kolej',
	);
	
    public function view()
    {
        $this->setMenuSelected();
        $this->loadDatasetBrowser('sa_orzeczenia');
    }

    public function sedziowie()
    {
        $this->loadDatasetBrowser('sa_sedziowie');
    }

    public function sn_orzeczenia()
    {
        $this->loadDatasetBrowser('sn_orzeczenia');
    }

    public function sp_orzeczenia()
    {
        $this->loadDatasetBrowser('sp_orzeczenia');
    }
} 