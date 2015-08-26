<?php

class Survey extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function save($data)
    {
        return $this->getDataSource()->request('survey/save.json', array(
            'data' => $data,
            'method' => 'POST'
        ));
    }

}
