<?php

class Transaction extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function save($data) {
        return $this->getDataSource()->request('transactions/transactions/save.json', array(
            'data' => $data,
            'method' => 'POST'
        ));
    }

    public function get($id) {
        return $this->getDataSource()->request('transactions/transactions/get/'. $id .'.json', array(
            'method' => 'GET'
        ));
    }

}