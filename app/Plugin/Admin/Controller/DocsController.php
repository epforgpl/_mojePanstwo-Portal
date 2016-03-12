<?php

App::uses('AdminAppController', 'Admin.Controller');

class DocsController extends AdminAppController {

    public $components = array('RequestHandler', 'S3');
    public $uses = array('Admin.Doctable', 'Admin.DoctableDict');

    public function tables($document_id) {
        $this->layout = false;

        $data = $this->Doctable->getTables($document_id);
        $tables = array();
        foreach($data as $row) {
            $table = new stdClass();
            $table->id = (int) $row['doctables']['id'];
            $table->name = $row['doctables']['name'];
            $table->pageIndex = (int) $row['doctables']['page_index'];
            $table->x = (int) $row['doctables']['x'];
            $table->y = (int) $row['doctables']['y'];
            $table->width = (int) $row['doctables']['width'];
            $table->height = (int) $row['doctables']['height'];

            $table->rows = array_map(function($e) {
                return (int) $e;
            }, explode(';', $row[0]['r']));

            $table->cols = array_map(function($e) {
                return (int) $e;
            }, explode(';', $row[0]['c']));

            $tables[] = $table;
        }

        $this->set('tables', $tables);
        $this->set('tablesData', $this->Doctable->getTablesData($document_id));
        $this->set('document_id', $document_id);
        $this->set('docJSON', $this->getDocJSON($document_id));
    }

    public function saveTables($document_id) {
        $this->setSerialized('response',
            $this->Doctable->saveTables(
                $document_id,
                $this->request->data['tables']
            )
        );
    }

    public function saveTablesData($document_id) {
        $this->setSerialized('response',
            $this->Doctable->saveTablesData(
                $document_id,
                $this->request->data
            )
        );
    }

    public function tableData($doctable_data_id) {
        $this->layout = false;
        $tableData = $this->Doctable->getTableData($doctable_data_id);
        $this->set('tableData', $tableData);
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

    public function exportMySQL() {
        $this->setSerialized('response',
            $this->Doctable->exportMySQL(
                $this->request->data
            )
        );
    }

    public function dict() {
        $this->layout = false;
        $this->set('dict', $this->Doctable->getDict(0));
    }

    public function getDict() {
        $this->setSerialized('response', $this->Doctable->getDict(0));
    }

    public function removeDict() {
        $this->setSerialized('response',
            $this->DoctableDict->delete(
                $this->request->data['id']
            )
        );
    }

    public function addDict() {
        $this->setSerialized('response',
            $this->DoctableDict->save(
                $this->request->data
            )
        );
    }

    public function hurtownia() {
        $rows = $this->DoctableDict->query('SELECT `hurtownia_danych_map`.*, COUNT(`doctable_data`.`document_id`) as `count` FROM hurtownia_danych_map LEFT JOIN `doctable_data` ON `doctable_data`.`document_id` = hurtownia_danych_map.document_id  WHERE `enabled` = "1" GROUP BY hurtownia_danych_map.document_id');

        $map = array(
            'categories' => array()
        );

        foreach($rows as $row) {
            $row['hurtownia_danych_map']['count'] = @$row[0]['count'];
            $row = $row['hurtownia_danych_map'];
            if(!isset($map['categories'][$row['cat']])) {
                $map['categories'][$row['cat']] = array(
                    'rows' => array(),
                    'sub' => array()
                );
            }

            $map['categories'][$row['cat']]['rows'][] = $row;
        }

        $this->set('map', $map);
    }

}