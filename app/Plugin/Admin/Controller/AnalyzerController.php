<?php

class AnalyzerController extends AdminAppController
{

    public $uses = array(
        'Admin.Analyzer'
    );

    public $components = array(
        'RequestHandler'
    );

    public function view()
    {

        $id = $this->request->params['named']['id'];

        $analyzer = $this->Analyzer->grabData($id);

        $this->set('analyzer', $analyzer);

        $this->set('_serialize', array('analyzer'));

        switch ($id) {

            case 'Krs': {
                $this->render('view_krs');
                break;
            }
            case 'Zamowienia Publiczne': {
                $this->render('view_zp');
                break;
            }
            case 'Indeksowanie': {
                $this->render('view_indeks');
                break;
            }
            case 'Cluster': {
                $this->render('view_cluster');
                break;
            }
            case 'BDL': {
                $this->render('view_bdl');
                break;
            }
        }

    }
}