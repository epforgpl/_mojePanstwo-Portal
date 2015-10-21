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

	public function obwody()
	{
		
		$data = $this->Mapa->obwody($this->request->query['id']);
		
		$this->set('data', $data);
		$this->set('_serialize', 'data');
		
	}
	
    public function view()
    {
	            
        $this->title = 'Mapa';
		
		if( @$this->request->query['q'] ) {
			
			$options = array(
	            'searchTag' => array(
		            'href' => '/mapa',
		            'label' => 'Mapa',
	            ),
	            'conditions' => array(
	                'dataset' => array('miejsca'),
	                'miejsca.ignore' => false,
	            ),
	            'limit' => 10,
	            'apps' => true,
	        );
	
	        $this->Components->load('Dane.DataBrowser', $options);
			
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
