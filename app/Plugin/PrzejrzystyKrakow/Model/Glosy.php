<?php

class Glosy extends AppModel
{
    public $useDbConfig = 'mpAPI';

    public function vote($druk_id, $data) {
        return $this->getDataSource()->request('krakow/glosy/save/' . $druk_id, array(
            'method' => 'POST',
            'data' => $data,
        ));
    }

    public function getVotes($druk_id) {
        return $this->getDataSource()->request('krakow/glosy/view/' . $druk_id, array(
            'method' => 'GET'
        ));
    }

}