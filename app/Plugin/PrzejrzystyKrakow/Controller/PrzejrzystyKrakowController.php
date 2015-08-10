<?php
App::uses('ApplicationsController', 'Controller');

class PrzejrzystyKrakowController extends ApplicationsController
{

    public $_layout = array(
        'header' => false,
        'body' => array(
            'theme' => 'wallpaper',
        ),
        'footer' => false,
    );

    public function index()
    {
        $this->title = 'Przejrzysty Kraków';
    }

    public function getMenu()
    {
        return false;
    }


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