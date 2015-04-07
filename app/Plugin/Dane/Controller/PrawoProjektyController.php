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
        ));

    }

} 