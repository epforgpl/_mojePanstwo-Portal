<?php

class DocsController extends AppController
{

    public $components = array('RequestHandler');


    public function view()
    {

        App::import("Model", "Document");
        $Document = new Document();

        $doc = $Document->load($this->request->params['id'], false);
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

        $doc = $Document->load($this->request->params['id'], false);

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

    public function save_doc()
    {
        $this->loadModel('Document');

        $data = array(
            'pages' => array(),
            'bookmarks' => array()
        );

        $id = $this->request->data['document_id'];

        if (isset($this->request->data['pages'])) {
            $pages = $this->request->data['pages'];
            foreach ($pages as $page) {
                $page['dokument_id'] = $id;
                $data['pages'][] = $page;
            }
        }
        if (isset($this->request->data['bookmarks'])) {
            $bookmarks = $this->request->data['bookmarks'];
            foreach ($bookmarks as $bookmark) {
                $bookmark['dokument_id'] = $id;
                $bookmark['strona_start'] = hexdec($bookmark['strona_numer_hex']);
                $data['bookmarks'][] = $bookmark;
            }
        }
        $msg = $this->Document->save_document($data, $id);


        $this->set(array('message' => $msg,
            '_serialize' => array('message')
        ));
    }

    public function extract_budget_spendings()
    {


        App::import("Model", "Document");
        $Document = new Document();

        $id=$Document->doc_id_from_attach($this->request->params['id']);
        $doc = $Document->load($id['doc_id'], false);

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

        if (isset($this->request->params['ext']) && in_array($this->request->params['ext'], array('html', 'htm'))) {
            $this->layout = 'doc';
            $this->render('view-html');
        }else{
            $this->render('attachment');
        }
    }
}
