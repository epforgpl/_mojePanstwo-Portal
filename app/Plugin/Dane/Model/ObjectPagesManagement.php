<?php

class ObjectPagesManagement extends AppModel {

    public $useDbConfig = 'mpAPI';

    private $request;

    public function setRequest($request) {
        $this->request = $request;
    }

    public function setLogo() {
        return $this->getResponse('setLogo', array(
            'method' => 'POST'
        ));
    }

    public function deleteLogo() {
        return $this->getResponse('deleteLogo', array(
            'method' => 'DELETE'
        ));
    }

    public function setCover($credits) {
        return $this->getResponse('setCover', array(
            'method' => 'POST',
            'data' => array(
                'credits' => $credits
            )
        ));
    }

    public function deleteCover() {
        return $this->getResponse('deleteCover', array(
            'method' => 'DELETE'
        ));
    }

    public function isEditable() {
        $res =  $this->getResponse('isEditable', array(
            'method' => 'POST'
        ));

        return ($res == '1');
    }

    private function getResponse($endpoint, $options) {
        return $this->getDataSource()->request('dane/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '/pages/' . $endpoint . '.json', $options);
    }

}