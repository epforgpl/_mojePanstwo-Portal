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
    public $uses = array('PrzejrzystyKrakow.Glosy');

    public function voteSave($params)
    {
        $data = $this->Glosy->voteSave($params);
        return @$data;
    }

    public function viewVotes($params)
    {
        $data = $this->Glosy->viewVotes($params);
        return @$data;
    }
}