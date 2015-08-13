<?php

class DocsController extends AppController
{

    public $components = array('RequestHandler');

    public function view()
    {

        App::import("Model", "Document");
        $Document = new Document();

        $doc = $Document->load($this->request->params['id']);
        $this->set('doc', $doc);
        $this->set('_serialize', 'doc');


        $this->set('title_for_layout', $doc['Document']['filename']);

        if ($this->hasUserRole('2')) {
            $isAdmin = true;
        } else {
            $isAdmin = false;
        }

        $this->set('isAdmin', $isAdmin);
        if (isset($this->request->params['ext']) && in_array($this->request->params['ext'], array('html', 'htm'))) {
            $this->layout = 'doc';
            $this->render('view-html');
        }

    }

    public function edit()
    {

        App::import("Model", "Document");
        $Document = new Document();

        $doc = $Document->load($this->request->params['id'], 0);

        $this->set('doc', $doc);
        $this->set('_serialize', 'doc');

        $this->set('title_for_layout', $doc['Document']['filename']);

        if (isset($this->request->params['ext']) && in_array($this->request->params['ext'], array('html', 'htm'))) {
            $this->layout = 'doc';
            $this->render('view-html');
        }

    }

    public function download()
    {

        $this->loadModel('Document');
        $doc = $this->Document->load($this->request->params['id']);
        $this->redirect($doc['Document']['url']);

    }

    public function viewPackage()
    {

        $doc_id = $this->request->params['doc_id'];
        $package_id = $this->request->params['package_id'];

        $doc = new MP\Document($doc_id);
        $html = $doc->loadHTML($package_id);

        $ext = strtolower($this->request->params['ext']);

        if ($ext == 'html') {

            echo $html;
            die();

        } elseif ($ext == 'json') {

            $this->set('doc', $doc->getData());
            $this->set('html', $html);
            $this->set('_serialize', array('doc', 'html'));

        }

    }
}
