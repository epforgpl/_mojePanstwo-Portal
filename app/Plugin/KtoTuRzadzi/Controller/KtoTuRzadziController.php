<?php

App::uses('ApplicationsController', 'Controller');

class KtoTuRzadziController extends ApplicationsController
{

    public $settings = array(
        'id' => 'kto_tu_rzadzi',
        'menu' => array(
            array(
                'id' => '',
                'href' => 'kto_tu_rzadzi',
                'label' => 'Instytucje',
            ),
            array(
                'id' => 'urzednicy',
                'href' => 'kto_tu_rzadzi/urzednicy',
                'label' => 'Urzędnicy',
            )
        ),
        'title' => 'Kto tu rządzi?',
        'subtitle' => 'Urzędy i urzędnicy w Polsce',
        'headerImg' => '/kto_tu_rzadzi/img/header_kto-tu-rzadzi.png',
    );

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/kto_tu_rzadzi/img/social/ktoturzadzi.jpg');
    }

    public function view()
    {
        $this->setMenuSelected();
        $this->title = 'Instytucje - Kto tu rządzi?';

        $options = array();
        if (!isset($this->request->query['q']))
            $options['order'] = 'weight desc';

        $this->loadDatasetBrowser('instytucje', $options);
    }

    public function urzednicy()
    {
        $this->title = 'Urzędnicy - Kto tu rządzi?';
        $this->loadDatasetBrowser('urzednicy');
    }
}