<?php

App::uses('ApplicationsController', 'Controller');
class DaneController extends ApplicationsController
{
	
    public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Wyszukiwarka',
			),
			array(
				'id' => 'zbiory',
				'label' => 'Zbiory danych',
			),
		),
		'title' => 'Dane',
		'subtitle' => 'Największa baza danych publicznych w Polsce',
		'headerImg' => 'dane',
	);
	
    public function view()
    {
        
        $this->setMenuSelected();
        
        
        
        // $this->loadDatasetBrowser('instytucje', $options);
                
    }
    
    public function zbiory()
    {

        $this->title = 'Zbiory danych';
        $this->loadDatasetBrowser('zbiory', array(
	        'conditions' => array(
		        'dataset' => 'zbiory',
		        'zbiory.katalog' => '1',
	        ),
	        'order' => '_title asc',
        ));
                        
    }

} 