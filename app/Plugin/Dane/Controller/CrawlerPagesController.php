<?php

App::uses('DataobjectsController', 'Dane.Controller');

class CrawlerPagesController extends DataobjectsController
{

    public $components = array(
        'RequestHandler',
    );
    public $uses = array('Dane.CrawlerPage');

    public $objectOptions = array(
        'hlFields' => array('crawler_sites.nazwa', 'liczba_rozmiar', 'content_type', 'url'),
        'buttons' => array('shoutIt'),
    );

    public $menu = array(
        array(
            'id' => 'view',
            'label' => 'Image',
        ),
        array(
            'id' => 'online',
            'label' => 'Online',
        ),
        array(
            'id' => 'offline',
            'label' => 'Offline',
        ),
    );

    public function view()
    {

        if ($this->Auth->user() && (($this->Auth->user('group_id') == '2') || ($this->Auth->user('id') == '2578'))) {
            $this->objectOptions['buttons'][] = 'careIt';
        }

        parent::_prepareView();
    }

    public function online()
    {
        parent::_prepareView();
    }

    public function offline()
    {
        parent::_prepareView();
        $offline = $this->object->loadLayer('offline');
        $this->set('offline', $offline);
    }

    public function iframe()
    {
        parent::_prepareView();
        $offline = $this->object->loadLayer('offline');
        echo $offline['html'];
        die();
    }

    public function careIt()
    {
        parent::_prepareView();
        $post_url = $this->CrawlerPage->careIt(array(
            'url' => $this->object->getData('url'),
            'title' => $this->object->getTitle(),
        ));

        $this->Session->setFlash('<p>Utworzyłem nowy post na platformie Care\'o\'meter.</p><p><a target="_blank" href="' . $post_url . '">Edytuj i opublikuj go!</a></p>', 'default', array(
            'class' => 'careIt',
        ));
        $this->redirect($this->referer());
    }

}