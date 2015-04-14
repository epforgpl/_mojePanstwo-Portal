<?php

App::uses('ApplicationsController', 'Controller');
class SadometrController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Sądy administracyjne',
			),
			/*
			array(
				'id' => 'sedziowie',
				'label' => 'Sędziowie sądów administracyjnych',
			),
			*/
            array(
                'id' => 'sn_orzeczenia',
                'label' => 'Sąd Najwyższy',
            ),
            array(
                'id' => 'sp_orzeczenia',
                'label' => 'Sądy powszechne',
            )
		),
		'title' => 'Sądometr',
		'subtitle' => 'Orzeczenia sądów w Polsce',
		'headerImg' => 'sadometr',
	);
	
    public function view()
    {
        $this->setMenuSelected();
        $this->title = 'Orzeczenia Sądów Administracyjnych - Sądometr';
        $this->loadDatasetBrowser('sa_orzeczenia');
    }

    public function sedziowie()
    {
	    $this->title = 'Sędziowie sądów administracyjnych - Sądometr';
        $this->loadDatasetBrowser('sa_sedziowie');
    }

    public function sn_orzeczenia()
    {
	    $this->title = 'Orzeczenia Sądu Najwyższego - Sądometr';
        $this->loadDatasetBrowser('sn_orzeczenia');
    }

    public function sp_orzeczenia()
    {
	    $this->title = 'Orzeczenia sądów powszechnych - Sądometr';
        $this->loadDatasetBrowser('sp_orzeczenia');
    }
} 