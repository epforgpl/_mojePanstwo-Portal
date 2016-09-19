<?php

App::uses('DataobjectsController', 'Dane.Controller');

class MSiGController extends DataobjectsController
{

    public $helpers = array('Document');

    public $objectOptions = array(
        // 'hlFields' => array('isap_status_str', 'sygnatura', 'data_wydania', 'data_publikacji', 'data_wejscia_w_zycie'),
        'hlFields' => array(),
    );


    public function view($package = 1)
    {
				
        $this->_prepareView();
        
        $this->DataBrowser = $this->Components->load('Dane.DataBrowser', array(
            'searchTitle' => 'Szukaj w ogłoszeniach...',
            'conditions' => array(
                'dataset' => 'msig_pozycje',
                'msig_pozycje.wydanie_id' => $this->object->getId(),
            ),
            'order' => 'msig_pozycje.pozycja asc',
            'titlePreset' => 'from_msig',
            'phrasesPreset' => 'msig_pozycje',
            'aggsPreset' => 'msig_pozycje_wydanie',
        ));
        
        $this->render('Dane.DataBrowser/browser');
    
    }	
	
    public function dokument()
    {

        $this->_prepareView();

        $this->render('view');

    }
	
	public function beforeRender()
	{
		
		$this->set('_layout', array(
			'header' => array(
				'element' => 'dataobject'
			),
			'body' => array(
				'theme' => 'default'
			),
			'footer' => array(
				'element' => 'default'
			)
		));
		$this->addAppBreadcrumb('krs');
		$this->addBreadcrumb(array(
			'href' => '/dane/msig_pozycje',
			'label' => 'Monitor Sądowy i Gospodarczy'
		));
		
	}

} 