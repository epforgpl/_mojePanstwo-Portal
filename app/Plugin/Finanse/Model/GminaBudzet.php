<?php

class GminaBudzet extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function getDzial($id, $gmina_id, $typ) {
        return $this->getDataSource()->request('/finanse/gminy/'. $gmina_id .'/budzet/'. $typ .'/dzialy/'. $id .'.json', array(
            'method' => 'POST'
        ));
    }

    public function getDzialy($gmina_id, $typ) {
        return $this->getDataSource()->request('/finanse/gminy/'. $gmina_id .'/budzet/'. $typ .'/dzialy.json', array(
            'method' => 'POST'
        ));
    }

}
