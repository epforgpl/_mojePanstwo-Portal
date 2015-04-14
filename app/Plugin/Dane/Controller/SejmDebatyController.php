<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmDebatyController extends DataobjectsController
{

    public $uses = array('Dane.Dataobject');
    public $breadcrumbsMode = 'app';
    public $objectOptions = array(
        'hlFields' => array(),
    );


    public function view()
    {

        $this->addInitLayers(array('nav'));
        parent::view();
				

        if (
            ($nav = $this->object->getLayer('nav')) &&
            isset($nav['posiedzenie']) &&
            isset($nav['posiedzenie']['punkty']) &&
            !empty($nav['posiedzenie']['punkty'])
        ) {

            $this->redirect('/dane/sejm_posiedzenia_punkty/' . $nav['posiedzenie']['punkty'][0]['id'] . '/debaty/' . $this->object->getId());

        } else {

			
			$this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
		            'dataset' => 'sejm_wystapienia',
		            'sejm_wystapienia.debata_id' => $this->object->getId(),
	            ),
	            'order' => 'sejm_wystapienia._ord asc',
	            'limit' => 1000,
	            'renderFile' => 'sejm_debaty-wystapienie',
	            // 'aggsPreset' => 'sejm_wystapienia',
	        ));
			

        }
    }

    public function wystapienia()
    {

        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
			
			$wystapienie = $this->Dataobject->find('first', array(
				'conditions' => array(
					'dataset' => 'sejm_wystapienia',
					'id' => $this->request->params['subid'],
				),
				'layers' => array('html'),
			));
			
            $this->set('wystapienie', $wystapienie);
            $this->render('wystapienie');


        } else {

            $this->redirect($this->object->getUrl());
            die();

        }

    }

    public function glosowania()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'glosowania';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
			
			$glosowanie = $this->Dataobject->find('first', array(
				'conditions' => array(
					'dataset' => 'sejm_glosowania',
					'id' => $this->request->params['subid'],
				),
				'layers' => array('wynikiKlubowe'),
			));
			
            $this->set('glosowanie', $glosowanie);
			
			$this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
		            'dataset' => 'poslowie_glosy',
		            'poslowie_glosy.debata_id' => $this->object->getId(),
	            ),
                'order' => '_title asc',
	            'limit' => 1000,
                'renderFile' => 'glosowania-glosy',
	        ));
			

            $this->render('glosowanie');

        } else {
			
			$this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
		            'dataset' => 'sejm_glosowania',
		            'sejm_glosowania.debata_id' => $this->object->getId(),
	            ),
                'order' => 'numer asc',
	            'limit' => 1000,
                'renderFile' => 'sejm_debaty-glosowanie',
	        ));

        }

    }

} 