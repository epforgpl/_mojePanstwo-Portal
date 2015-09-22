<?php

class Collection extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function get() {
        return $this->getDataSource()->request('collections/collections/get', array(
            'method' => 'GET'
        ));
    }

    public function create($data) {
        return $this->getDataSource()->request('collections/collections/create', array(
            'data' => $data,
            'method' => 'POST'
        ));
    }

}
