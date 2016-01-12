<?php

App::uses('AdminAppController', 'Admin.Controller');

class WebsitesController extends AdminAppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'websites');
    }

    public function index() {
        $this->Components->load('Dane.DataBrowser', array(
            'dataset' => 'webpages',
            'conditions' => array(
                'dataset' => 'webpages',
            )
        ));

        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

}