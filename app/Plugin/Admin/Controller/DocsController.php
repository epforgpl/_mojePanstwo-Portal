<?php

App::uses('AdminAppController', 'Admin.Controller');

class DocsController extends AdminAppController {

    public $components = array('RequestHandler', 'S3');

    public function tables($document_id) {
        $this->layout = false;
        $this->set('document_id', $document_id);
        $this->set('docJSON', $this->getDocJSON($document_id));
    }

    public function saveTables($document_id) {
        $this->loadModel('Admin.DocTable');
        $this->setSerialized('response',
            $this->DocTable->saveTables(
                $document_id,
                $this->request->data['tables']
            )
        );
    }

    private function getDocJSON($document_id) {
        $xml = @$this->S3->getObject(
            'docs.sejmometr.pl', 'xml/' . $document_id . '.xml');

        $doc = new stdClass;
        $doc->pages = array();

        $s = simplexml_load_string($xml->body);
        foreach($s->page as $page) {
            $p = new stdClass();
            $p->width = (string) $page->attributes()->width;
            $p->height = (string) $page->attributes()->height;
            $p->texts = array();
            foreach($page->text as $text) {
                $content = (string) $text;
                foreach($text->children() as $child)
                    $content .= ' ' . (string) $child;
                $p->texts[] = array(
                    'top' => (string) $text->attributes()->top,
                    'left' => (string) $text->attributes()->left,
                    'width' => (string) $text->attributes()->width,
                    'height' => (string) $text->attributes()->height,
                    'content' => trim($content)
                );
            }
            $doc->pages[] = $p;
        }

        return json_encode($doc);
    }

}