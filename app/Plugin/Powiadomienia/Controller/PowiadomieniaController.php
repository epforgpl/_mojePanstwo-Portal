<?php

App::uses('ApplicationsController', 'Controller');
class PowiadomieniaController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Jak to działa?',
			),
			array(
				'id' => 'moje',
				'label' => 'Moje powiadomienia',
			),
			array(
				'id' => 'obserwuje',
				'label' => 'Obserwuję',
			),
		),
		'title' => 'Powiadomienia',
		'subtitle' => 'Obserwuj interesujące Cię dane publiczne',
		'headerImg' => 'krs',
	);
	
    public function view()
    {
        
        $this->setMenuSelected();
                
    }    

} 