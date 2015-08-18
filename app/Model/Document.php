<?php

class Document extends AppModel
{

    public $useDbConfig = 'mpAPI';
    public $useTable = false;

    public function load($id, $options = array())
    {

        try {
            return $this->getDataSource()->loadDocument($id, $options);
        } catch (Exception $e) {
            return false;
        }

    }

    public function save_document($data, $id)
    {
        return $this->getDataSource()->request('docs/' . $id . '.json', array(
            'method' => 'POST',
            'data' => $data
        ));
    }

    public function doc_id_from_attach($id)
    {
        return $this->getDataSource()->request('docs/attachments/' . $id, array(
            'method' => 'GET',
            'id' => $id
        ));
    }
}
