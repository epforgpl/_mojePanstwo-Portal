<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmDebatyController extends DataobjectsController
{

    public $uses = array('Dane.Dataobject');
    public $breadcrumbsMode = 'app';
    public $objectOptions = array(
        'hlFields' => array(),
    );

	public function _redirect()
	{
		
		$this->load();
		return $this->redirect('/dane/instytucje/3214,sejm/debaty/' . $this->object->getId());
		
	}
	
    public function view()
    {
		
		return $this->_redirect();		
        
    }

    public function wystapienia()
    {
		
		return $this->redirect();	
		
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
		
		return $this->redirect();
		
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