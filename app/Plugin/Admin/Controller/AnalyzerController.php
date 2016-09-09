<?php

class AnalyzerController extends AdminAppController
{

    public $uses = array(
        'Admin.Analyzer'
    );

    public $components = array(
        'RequestHandler'
    );

    private $options = array(
        'krs' => array(
            'action' => 'analyzer_krs',
            'analyzer' => 'Krs',
            'view' => 'view_krs'
        ),
        'msig' => array(
            'action' => 'analyzer_msig',
            'analyzer' => 'Msig',
            'view' => 'view_msig'
        ),
        'zp' => array(
            'action' => 'analyzer_zp',
            'analyzer' => 'Zamowienia+Publiczne',
            'view' => 'view_zp'
        ),
        'indexing' => array(
            'action' => 'analyzer_indexing',
            'analyzer' => 'Indeksowanie',
            'view' => 'view_indeks'
        ),
        'cluster' => array(
            'action' => 'analyzer_cluster',
            'analyzer' => 'Cluster',
            'view' => 'view_cluster'
        ),
        'bdl' => array(
            'action' => 'analyzer_bdl',
            'analyzer' => 'BDL',
            'view' => 'view_bdl'
        ),
    );

    private function create($id) {
        if(!in_array($id, array_keys($this->options)))
            throw new NotFoundException;

        $options = $this->options[$id];
        $this->set('action', $options['action']);
        $analyzer = $this->Analyzer->grabData($options['analyzer']);
        $this->set('analyzer', $analyzer);
        $this->set('_serialize', array('analyzer'));
        $this->render($options['view']);
    }

    public function krs() {
        $this->create('krs');
    }
    
    public function msig() {
        $this->create('msig');
    }

    public function zp() {
        $this->create('zp');
    }

    public function indexing() {
        $this->create('indexing');
    }

    public function cluster() {
        $this->create('cluster');
    }

    public function bdl() {
        $this->create('bdl');
    }

}
