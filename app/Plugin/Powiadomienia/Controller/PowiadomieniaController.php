<?php

App::uses('ApplicationsController', 'Controller');
class PowiadomieniaController extends ApplicationsController
{

	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Obserwuję',
			),
			array(
				'id' => 'moje',
				'label' => 'Moje powiadomienia',
			),
			array(
				'id' => 'jak_to_dziala',
				'label' => 'Jak to działa?',
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
	    
	    $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'subscribtions' => true,
            ),
            'renderFile' => 'subscriptions',
        ));
        
        $this->set('dataBrowserObjectRender', array(
		    'forceLabel' => true,
	    ));
        $this->set('DataBrowserTitle', 'Dane które obserwujesz:');
        $this->title = 'Obserwuję - Powiadomienia';
    }
    
    public function moje() {
	    $this->title = 'Moje Powiadomienia';
    }
    
    public function jak_to_dziala() {
        $this->title = 'Jak to działa? - Powiadomienia';
    }

} 