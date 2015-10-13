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
        } else if (isset($this->request->query['q'])) {
            $url = '/mapa/miejsce/253272?n=25';

            if (isset($this->request->query['widget']))
                $url .= '&widget';

            return $this->redirect($url);
        } else {
            $this->title = 'Mapa';
        }

        if (isset($this->request->query['widget'])) {
            $this->layout = 'blank';
            $this->set('widget', true);
        }

    }

    public function geodecode()
    {
        if (
            (@$this->request->params['ext'] == 'json') &&
            (isset($this->request->query['lat'])) &&
            (isset($this->request->query['lon']))
        ) {

            $data = $this->Mapa->geodecode($this->request->query['lat'], $this->request->query['lon']);
            $this->set('data', $data);
            $this->set('_serialize', 'data');

        } else {
            return $this->redirect('/mapa');
        }
    }

}
