<?php

App::uses('DataobjectsController', 'Dane.Controller');

class CoeSittingsController extends DataobjectsController
{
    public $menu = array();

    public $objectOptions = array(
        'buttons' => array('shoutIt'),
    );

    public $initLayers = array('text');

    public function view()
    {

        if ($this->Auth->user() && (($this->Auth->user('group_id') == '2') || ($this->Auth->user('id') == '2578'))) {
            $this->objectOptions['buttons'][] = 'careIt';
        }

        parent::view();

    }

    public function careIt()
    {
        parent::_prepareView();
        $post_url = $this->CoeSitting->careIt(array(
            'url' => $this->object->getData('url'),
            'title' => $this->object->getTitle(),
        ));

        $this->Session->setFlash('<p>Utworzyłem nowy post na platformie Care\'o\'meter.</p><p><a target="_blank" href="' . $post_url . '">Edytuj i opublikuj go!</a></p>', 'default', array(
            'class' => 'careIt',
        ));
        $this->redirect($this->referer());
    }

}