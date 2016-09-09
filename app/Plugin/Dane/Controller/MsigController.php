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
	
    public function dzialy()
    {
									
		if( $this->request->params['ext']=='json' ) {
			
			$pozycje = array();
			
			if ($sub_id = @$this->request->params['subid']) {
			
				$_pozycje = $this->Dataobject->find('all', array(
					'conditions' => array(
						'dataset' => 'msig_pozycje',
						'msig_pozycje.dzial_id' => $sub_id,
					),
					'order' => 'msig_pozycje.pozycja asc',
					'limit' => 100,
				));
				
				foreach( $_pozycje as $p ) {
					$pozycje[] = array(
						'id' => $p->getId(),
						'global_id' => $p->getGlobalId(),
						'data' => $p->getData(),
					);
				}
			
			}
			
			$this->set('pozycje', $pozycje);
			$this->set('_serialize', array('pozycje'));
		
		} else {
			
			$this->load();

	        if ($id = @$this->request->params['subid']) {
	
	            $dzial = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'msig_dzialy',
	                    'id' => $id,
	                ),
	            ));
	
	            if ($dzial->getData('msig_id') != $this->object->getId()) {
	
	                $this->redirect('/dane/msig/' . $dzial->getData('msig_id') . '/dzialy/' . $dzial->getId());
	                die();
	
	            }
	
	            $this->set('dzial', $dzial);
	            $this->set('title_for_layout', $dzial->getTitle());
	            $this->render('dzial');
	
	        } else {
	            $this->redirect('/dane/msig/' . $this->object->getId());
	        }
			
		}
			

    }

} 