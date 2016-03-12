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
                'webpages.status' => '0',
                'websites.site_id!=' => '48',
                'qs' => array(
                    'konkurs',
                    'grant',
                    'dofinansowanie',
                    'dotacja',
                    'zlecenie zadania publicznego'
                ),
                'q' => '2016',
            ),
            'beforeBrowserElement' => 'Admin.websitesBeforeBrowser'
        ));

        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

    public function ignore($id = 0) {
        $this->loadModel('Admin.CrawlerPage');
        $this->CrawlerPage->save(array(
            'id' => (int) $id,
            'status' => '2'
        ));

        $this->redirect('/admin/websites');
    }

    public function ignoreMultiples() {
        $this->loadModel('Admin.CrawlerPage');
        foreach(@$this->request->data['ids'] as $id) {
            $this->CrawlerPage->save(array(
                'id' => (int) $id,
                'status' => '2'
            ));
        }

        $this->set('response', true);
        $this->set('_serialize', array('response'));
    }

}