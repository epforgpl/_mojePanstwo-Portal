<?php

App::uses('DataobjectsController', 'Dane.Controller');
App::uses('Sanitize', 'Utility');

class SejmInterpelacjeController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

	public $loadChannels = true;
	
    public $objectOptions = array(
        'hlFields' => array(),
    );

    public function view()
    {
		
		$this->load();
		
        return $this->feed(array(
	        'direction' => 'asc',
	        'timeline' => true,
	        'searchTitle' => $this->object->getLabel(),
        ));

    }

    public function pismo()
    {

        $this->load();        

        if (
            ( $pismo_id = @$this->request->params['subid'] ) && 
            ( $pismo = $this->Dataobject->find('first', array(
	            'conditions' => array(
		            'dataset' => 'sejm_interpelacje_pisma',
		            'id' => $pismo_id,
	            ),
	            'layers' => array('teksty'),
            )) )
        ) {
			
			$params = array(
	            'feed' => $this->object->getDataset() . '/' . $this->object->getId(),
	            'preset' => $this->object->getDataset(),
	            'mode' => 'min',
	        );
            $this->Components->load('Dane.DataFeed', $params);   

            $this->set('pismo', $pismo);

        } else {

            $this->redirect($this->object->getUrl());
            die();

        }

    }

} 