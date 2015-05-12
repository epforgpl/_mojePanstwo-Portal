<?

class Api extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function getAllAPIs() {
        return $this->getDataSource()->request('/');
    }
}

?>