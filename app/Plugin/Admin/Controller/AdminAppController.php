<?php

App::uses('AppController', 'Controller');

class AdminAppController extends AppController
{
    public $appSelected = 'admin';

    public $_layout = array(
        'header' => false,
        'body' => array(
            'theme' => 'default',
        ),
        'footer' => array(
            'element' => 'default',
        )
    );

    public $menu = array(
        array(
            'id'    => 'start',
            'label' => 'Start',
            'href'  => '/admin',
        ),
        array(
            'id'    => 'twitter_accounts',
            'label' => 'Propozycje nowych kont Twitter',
            'href'  => '/admin/twitter_accounts',
        ),
        array(
            'id'    => 'moderate_requests',
            'label' => 'Żądania uprawnień',
            'href'  => '/admin/moderate_requests',
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();

        if(!$this->hasUserRole('2'))
            throw new ForbiddenException;

        $this->set('menu', $this->menu);
    }

}
