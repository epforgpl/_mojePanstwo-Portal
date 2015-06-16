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

        parent::load();

        if ($this->object->getData('nadrzedny_projekt_id')) {
            $this->redirect(array(
                'plugin' => 'Dane',
                'controller' => 'prawo_projekty',
                'action' => '',
                'id' => $this->object->getData('nadrzedny_projekt_id')
            ));
        }

        $this->feed(array(
            'searchTitle' => '"' . $this->object->getTitle() . '"',
            'timeline' => true,
            'direction' => 'asc',
        ));

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