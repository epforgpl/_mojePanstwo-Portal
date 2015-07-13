<?php

App::uses('DataobjectsController', 'Dane.Controller');

class UrzednicyController extends DataobjectsController
{
    public $menu = array();
    public $initLayers = array();

    public function view()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'urzednicy_rejestr_korzysci',
                'urzednicy_rejestr_korzysci.osoba_id' => $this->object->getId(),
            ),
        ));
        $this->set('DataBrowserTitle', 'Rejestr korzyści majątkowych urzędnika');
        $this->render('Dane.DataBrowser/browser');

    }
} 