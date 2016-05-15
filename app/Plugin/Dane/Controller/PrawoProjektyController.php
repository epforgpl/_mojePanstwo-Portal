<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PrawoProjektyController extends DataobjectsController
{
    public $menu = array();

    public $objectOptions = array(
        'hlFields' => array(),
    );

    public $loadChannels = true;

    public function view()
    {
				
        return $this->redirect('/dane/instytucje/3214/prawo_projekty/' . $this->request->params['id']);

    }

    public function zamrazarka()
    {

        if ($this->request->params['subid']) {

            parent::load();

            $zamrazarka = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'sejm_zamrazarka',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->set('zamrazarka', $zamrazarka);

        } else $this->redirect($this->referer());

    }

} 