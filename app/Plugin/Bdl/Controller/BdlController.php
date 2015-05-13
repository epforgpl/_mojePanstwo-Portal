<?php

App::uses('ApplicationsController', 'Controller');

class BdlController extends ApplicationsController
{

    public $uses = array(
        'Bdl.Finanse'
    );

	public $settings = array(
		'menu' => array(
			array(
				'id' => '#',
				'label' => 'Bank Danych Lokalnych',
				'dropdown' => array(
					array(
						'id' => 'bdl_kategorie',
						'label' => 'Kategorie wskaźników',
					),
					array(
						'id' => 'bdl_grupy',
						'label' => 'Grupy wskaźników',
					),
					array(
						'id' => 'bdl_wskazniki',
						'label' => 'Wskaźniki',
					),
				),
			),
            array(
                'id' => 'finanse_gmin',
                'label' => 'Finanse gmin'
            )
		),
        'title' => 'Bdl',
		'subtitle' => 'Dane statystyczne o Polsce',
        'headerImg' => 'bdl',
	);
	
    public function view()
    {
        $this->setMenuSelected();
        $this->loadDatasetBrowser('bdl_wskazniki');
    }
	
	public function bdl()
	{

        $this->loadModel('Bdl.BDL');
		$tree = $this->BDL->getTree();
		$this->set('tree', $tree);
		
	}
	
    public function bdl_kategorie()
    {
	    $this->loadDatasetBrowser('bdl_wskazniki_kategorie');
    }

    public function bdl_grupy()
    {
        $this->loadDatasetBrowser('bdl_wskazniki_grupy');
    }

    public function finanse_gmin()
    {
        $data = $this->Finanse->getBudgetData();
        $this->set('data', $data);
    }

} 