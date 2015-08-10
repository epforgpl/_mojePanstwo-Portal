<?php
/**
 * Created by PhpStorm.
 * User: tomaszdrazewski
 * Date: 10/08/15
 * Time: 10:34
 */

class Glosy extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function voteSave($params){


        $data = $this->getDataSource()->request('krakow/glosy/save', array(
            'method' => 'POST',
            'data' => $params,
        ));

        return @$data;
    }

    public function viewVotes($params){
        $data = $this->getDataSource()->request('krakow/glosy/view', array(
            'method' => 'GET',
            'data' => $params,
        ));

        return @$data;
    }

}