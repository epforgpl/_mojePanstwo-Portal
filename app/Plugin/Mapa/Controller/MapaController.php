<?php

App::uses('ApplicationsController', 'Controller');

class MapaController extends ApplicationsController
{

    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
    );

    public $submenus = array(
        'mapa' => array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Start',
                )
            )
        )
    );

    public function view()
    {
        $options = array(
            'searchTag' => array(
                'href' => '/mapa',
                'label' => 'Mapa',
            ),
            'autocompletion' => array(
                'dataset' => 'mapa',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Mapa',
                    'element' => 'cover',
                )
            ),
        );

        $this->set('_submenu', array_merge($this->submenus['mapa'], array(
            'selected' => '',
        )));

        $this->title = 'Mapa';

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }
}
