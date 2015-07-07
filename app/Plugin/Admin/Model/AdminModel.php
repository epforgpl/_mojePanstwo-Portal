<?php

App::uses('ConnectionManager', 'Model');

class AdminModel {

    private static $apiSource;

    public function __call($name, $arguments = array()) {
        $response =  $this->getAPISource()->request(
            'admin/model/call',
            array(
                'method' => 'POST',
                'data' => array(
                    'class' => get_class($this),
                    'method' => $name,
                    'arguments' => $arguments
                )
            )
        );

        return $response['results'];
    }

    /**
     * @return mpAPISource
     */
    private function getAPISource() {
        if(!self::$apiSource)
            self::$apiSource = ConnectionManager::getDataSource('mpAPI');

        return self::$apiSource;
    }

}