<?php


class GminyKrakowRadni extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function getRanking($query) {
        return $this->getDataSource()->request('krakow/radni_ranking/get.json', array(
            'method' => 'GET',
            'data' => $query,
        ));
    }

}