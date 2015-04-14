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
            array(
                'id' => 'msig',
                'label' => 'Monitor Sądowy i Gospodarczy',
            ),
		),
		'title' => 'Krajowy Rejestr Sądowy',
		'subtitle' => 'Dane gospodarcze o firmach i osobach',
		'headerImg' => 'krs',
	);

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/krs/img/social/krs.jpg');
    }
	
    public function view()
    {
        
        $this->setMenuSelected();
        $this->loadDatasetBrowser('krs_podmioty');
                
    }

    public function osoby()
    {
	    $this->loadDatasetBrowser('krs_osoby', array(
		    'order' => 'date desc',
	    ));
    }
    
    public function msig()
    {
        $this->loadDatasetBrowser('msig');
    }
} 