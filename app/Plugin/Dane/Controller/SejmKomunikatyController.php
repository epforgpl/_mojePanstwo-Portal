<?php

App::uses('DataobjectsController', 'Dane.Controller');
App::uses('Sanitize', 'Utility');

class SejmKomunikatyController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public function view()
    {
        parent::view();
        $id = Sanitize::paranoid($this->params->id);
        $id = (int)$id;
        $content = file_get_contents('http://resources.sejmometr.pl/sejm_komunikaty/content/' . $id . '.html');
        $this->set('content', $content);
    }
}