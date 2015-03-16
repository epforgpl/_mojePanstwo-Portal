<?php

App::uses('DataobjectsController', 'Dane.Controller');

class UrzednicyRejestrKorzysciController extends DataobjectsController
{
    public $menu = array();
    public $initLayers = array('html');

    public function view()
    {
        parent::_prepareView();

        $dokument_id = $this->object->getData('urzednicy_rejestr_korzysci.dokument_id');
        $html = $this->object->getLayer('html');

        if ($dokument_id) {
            $this->set('content_document', $this->API->document($dokument_id));

        }

        if ($html) {
            $this->set('content_html', $html);
        }

        if (!$html and !$dokument_id) {
            throw new Exception("Either pdf or html should be set for " . $this->request->url);
        }
    }
}