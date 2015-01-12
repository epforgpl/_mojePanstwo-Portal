<?php

class DocsController extends AppController
{

    public $components = array('RequestHandler');

    public function view()
    {

        $doc = new MP\Document($this->request->params['id']);
        $data = $doc->getData();
        $this->set('doc', $data);
        $this->set('_serialize', 'doc');
        
        $document = $this->API->document($this->request->params['id']);
		$this->set('document', $document);
		$this->set('documentPackage', 1);
        
        $this->set('title_for_layout', $data['filename']);
        
        if( in_array($this->request->params['ext'], array('html', 'htm')) ) {
        	$this->layout = 'doc';
        	$this->render('view-html');
        }

    }

    public function download()
    {

        $doc = new MP\Document($this->request->params['id']);
        $this->redirect($doc->getUrl());

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

    public function tunnel()
    {

        $content = file_get_contents('http://docs.sejmometr.pl' . $_SERVER['REQUEST_URI']);
        $content_type = false;

        foreach ($http_response_header as $r) {
            if (stripos($r, 'Content-Type') === 0) {
                header($r);
            }
        }

        echo $content;
        die();

    }

}