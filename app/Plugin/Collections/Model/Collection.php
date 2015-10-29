<?php

class Collection extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function get($id) {
        return $this->getDataSource()->request('collections/collections/get/' . $id, array(
            'method' => 'GET'
        ));
    }

    public function publish($id) {
        return $this->getDataSource()->request('collections/collections/publish/' . $id, array(
            'method' => 'GET'
        ));
    }

    public function unpublish($id) {
        return $this->getDataSource()->request('collections/collections/unpublish/' . $id, array(
            'method' => 'GET'
        ));
    }

    public function create($data) {
        return $this->getDataSource()->request('collections/collections/create', array(
            'data' => $data,
            'method' => 'POST'
        ));
    }

    public function edit($id, $data) {
        return $this->getDataSource()->request('collections/collections/edit/' . $id, array(
            'data' => $data,
            'method' => 'POST'
        ));
    }

    public function addObject($id, $object_id) {
        return $this->getDataSource()->request('collections/collections/addObject/' . $id . '/' . $object_id, array(
            'method' => 'GET'
        ));
    }

    public function removeObject($id, $object_id) {
        return $this->getDataSource()->request('collections/collections/removeObject/' . $id . '/' . $object_id, array(
            'method' => 'GET'
        ));
    }

    public function removeObjects($id, $data) {
        return $this->getDataSource()->request('collections/collections/removeObjects/' . $id , array(
            'data' => $data,
            'method' => 'POST'
        ));
    }

    public function delete($id) {
        return $this->getDataSource()->request('collections/collections/delete/' . $id, array(
            'method' => 'GET'
        ));
    }

}
