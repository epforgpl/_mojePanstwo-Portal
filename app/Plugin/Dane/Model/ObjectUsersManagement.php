<?php

class ObjectUsersManagement extends AppModel {

    public $useDbConfig = 'mpAPI';

    private $request;

    public function setRequest($request) {
        $this->request = $request;
    }

    public function index() {
        return $this->getResponse('index', array(
            'method' => 'GET'
        ));
    }

    public function add($data) {
        return $this->getResponse('index', array(
            'method' => 'POST',
            'data' => $data
        ));
    }

    public function edit($data) {
        return $this->getResponse($this->request['user_id'], array(
            'method' => 'PUT',
            'data' => $data
        ));
    }

    public function delete() {
        return $this->getResponse($this->request['user_id'], array(
            'method' => 'DELETE'
        ));
    }

    private function getResponse($endpoint, $options) {
        return $this->getDataSource()->request('dane/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '/users/' . $endpoint . '.json', $options);
    }

}