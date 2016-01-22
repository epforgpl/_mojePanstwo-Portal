<?php

App::uses('Sanitize', 'Utility');
App::uses('ApplicationsController', 'Controller');

class HandelZagranicznyController extends ApplicationsController
{
    public $settings = array(
        'id' => 'handel_zagraniczny',
        'title' => 'Handel zagraniczny',
    );

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/handel_zagraniczny/img/social/handel.jpg');
    }

    public function index()
    {
        $this->set('title_for_layout', 'Handel zagraniczny');
    }
    
    public function getChapters()
    {
	    return array();
    }

}
