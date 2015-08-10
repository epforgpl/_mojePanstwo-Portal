<?php
/**
 * Created by PhpStorm.
 * User: tomaszdrazewski
 * Date: 10/08/15
 * Time: 10:14
 */
App::uses('ApplicationsController', 'Controller');

class GlosowanieController extends ApplicationsController
{
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