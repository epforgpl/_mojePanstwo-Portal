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
} 