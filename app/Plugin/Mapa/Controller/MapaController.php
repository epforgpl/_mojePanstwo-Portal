<?php

App::uses('ApplicationsController', 'Controller');

class MapaController extends ApplicationsController
{

    public $components = array('RequestHandler');

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
        if ((@$this->request->params['ext'] == 'json') && (isset($this->request->query['q']))) {
            $data = $this->Mapa->geocode($this->request->query['q']);
            $this->set('data', $data);
            $this->set('_serialize', 'data');
        } else {
            $this->title = 'Mapa';
        }
    }
}
