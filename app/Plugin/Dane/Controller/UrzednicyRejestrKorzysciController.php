<?php

App::uses('DataobjectsController', 'Dane.Controller');

class UrzednicyRejestrKorzysciController extends DataobjectsController
{
    public $menu = array();
    public $initLayers = array('html');

    public function view()
    {
        parent::load();

        $dokument_id = $this->object->getData('urzednicy_rejestr_korzysci.dokument_id');
        $html = $this->object->getLayer('html');

        if ($dokument_id) {
            $this->set('dokument_id', $dokument_id);

        } else if ($html) {
            $this->set('content_html', $html);

        } else {
            throw new Exception("Either pdf or html should be set for " . $this->request->url);
        }
    }
}