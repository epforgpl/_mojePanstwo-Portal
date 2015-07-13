<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmKomisjeController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public function view()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'poslowie',
                'poslowie.komisja_id' => $this->object->getId(),
            )
        ));
        $this->set('DataBrowserTitle', 'Posłowie w tej komisji');
        $this->render('DataBrowser/browser');

    }
} 