<?php

App::uses('ApplicationsController', 'Controller');

class MediaController extends ApplicationsController
{
    public $settings = array(
        'menu' => array(
            array(
                'id' => 'twitter',
                'label' => 'Twitter',
                'dropdown' => array(
                    array(
                        'id' => 'twitter',
                        'label' => 'Wpisy'
                    ),
                    array(
                        'id' => 'twitter_konta',
                        'label' => 'Konta'
                    )
                )
            ),
        ),
        'title' => 'Media',
        'subtitle' => 'media',
        'headerImg' => 'krs',
    );

    public function twitter()
    {
        $this->loadDatasetBrowser('twitter');
    }

    public function twitter_konta()
    {
        $this->loadDatasetBrowser('twitter_accounts');
    }
}