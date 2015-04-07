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
		'headerImg' => 'powiadomienia',
	);

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/powiadomienia/img/social/powiadomienia.jpg');
    }
	
    public function view() {
        
        $this->setMenuSelected();
                
    }
    
    public function obserwuje() {
	    
	    $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'subscribtions' => true,
            ),
        ));
        
        $this->set('dataBrowserObjectRender', array(
		    'forceLabel' => true,
	    ));
        $this->set('DataBrowserTitle', 'Dane które obserwujesz:');
    }
    
    public function moje() {
	    
	    
	    
    } 

} 