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
        array(
            'id'    => 'surveys',
            'label' => 'Ankiety',
            'href'  => '/admin/surveys',
        ),
        array(
            'id'    => 'analyzer_zp',
            'label' => 'Zamówienia publiczne',
            'href'  => '/admin/analyzer/zp',
        ),
        array(
            'id'    => 'analyzer_bdl',
            'label' => 'BDL',
            'href'  => '/admin/analyzer/bdl',
        ),
        array(
            'id'    => 'analyzer_cluster',
            'label' => 'Cluster',
            'href'  => '/admin/analyzer/cluster',
        ),
        array(
            'id'    => 'analyzer_krs',
            'label' => 'KRS',
            'href'  => '/admin/analyzer/krs',
        ),
        array(
            'id'    => 'analyzer_indexing',
            'label' => 'Indeksownaie',
            'href'  => '/admin/analyzer/indexing',
        ),
        array(
            'id'    => 'krs_candidates',
            'label' => 'Kandydaci 2015 a KRS',
            'href'  => '/admin/krs_candidates',
        ),
        array(
            'id'    => 'public_content',
            'label' => 'Treści publiczne',
            'href'  => '/admin/public_content',
        ),
        array(
            'id'    => 'users',
            'label' => 'Użytkownicy',
            'href'  => '/admin/users',
        ),
        array(
            'id'    => 'websites',
            'label' => 'Websites',
            'href'  => '/admin/websites',
        ),
        array(
            'id'    => 'news',
            'label' => 'Aktualności',
            'href'  => '/admin/news',
        ),
        array(
            'id'    => 'bank_accounts',
            'label' => 'Konta bankowe',
            'href'  => '/admin/bank_accounts',
        ),
        array(
            'id'    => 'transactions',
            'label' => 'Transakcje',
            'href'  => '/admin/transactions',
        ),
        array(
            'id'    => 'newsletter',
            'label' => 'NGO Newsletter',
            'href'  => '/admin/newsletter',
        ),
        array(
            'id'    => 'hurtownia',
            'label' => 'Hurtownia danych',
            'href'  => '/admin/docs/hurtownia',
        ),
        array(
            'id'    => 'kultura',
            'label' => 'Kultura',
            'href'  => '/admin/kultura/pliki',
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();

        if(!$this->hasUserRole('2'))
            throw new ForbiddenException;

        $this->set('menu', $this->menu);
    }

}
