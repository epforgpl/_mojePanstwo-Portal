<?php

require ROOT . DS . 'app/Lib/S3.php';
App::uses('Component', 'Controller');

class S3Component extends Component {

    public static $bucket = 'portal';

    private $cloud;

    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
        $this->createCloud();
    }

    private function createCloud() {
        $this->cloud = new S3();
        $this->cloud->setAuth(S3_ACCESS_KEY, S3_SECRET_KEY);
        $this->cloud->setEndpoint(S3_ENDPOINT);
    }

    public function __call($method, $args) {
        return call_user_func_array(array($this->cloud, $method), $args);
    }

}