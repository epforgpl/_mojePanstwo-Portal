<?php

App::uses('AdminAppController', 'Admin.Controller');

class NewsletterController extends AdminAppController
{

    public $uses = array('Admin.AdminNgoNewsletter');

    public function index() {
        $this->set('count', $this->AdminNgoNewsletter->find('count'));
        $this->set('newCount', $this->AdminNgoNewsletter->find('count', array(
            'conditions' => array(
                'downloaded' => 0
            )
        )));
    }

    public function getAllRowsAsCSV() {
        $records = $this->AdminNgoNewsletter->find('all');
        $csv = array();
        $csv[] = array('id', 'email', 'created_at');
        foreach($records as $row) {
            $r = array();
            foreach($csv[0] as $f)
                $r[] = $row['AdminNgoNewsletter'][$f];
            $csv[] = $r;
        }

        return $this->getFileResponse($this->response, $csv);
    }

    public function getNewAsCSV() {
        $records = $this->AdminNgoNewsletter->find('all',array(
            'conditions' => array(
                'downloaded' => 0
            )
        ));

        $csv = array();
        $csv[] = array('id', 'email', 'created_at');
        foreach($records as $row) {
            $r = array();
            foreach($csv[0] as $f)
                $r[] = $row['AdminNgoNewsletter'][$f];
            $csv[] = $r;
        }

        $this->AdminNgoNewsletter->updateAll(
            array('AdminNgoNewsletter.downloaded' => 1)
        );

        return $this->getFileResponse($this->response, $csv);
    }

    private function getFileResponse($response, $csv) {
        $name = 'ngo_newsletter_' . date('Y_m_d_H_i_s') . '.csv';
        $file = APP . 'tmp/' . $name;

        $csvRows = array();
        foreach($csv as $c) {
            $csvRows[] = implode(";", $c);
        }

        $content = implode("\n", $csvRows);
        file_put_contents($file, $content);

        $response->file($file,
            array('download' => true, 'name' => $name));

        return $response;
    }

}