<?php

App::uses('ApplicationsController', 'Controller');

class KulturaController extends ApplicationsController
{

	public $components = array('RequestHandler');
	
    public $settings = array(
        'id' => 'kultura',
        'title' => 'Kultura w Polsce',
    );    
	
	public $params = array(
		array('id' => '2','name' => 'Postrzeganie kultury','slug' => 'postrzeganie_kultury'),
		array('id' => '8','name' => 'Telewizja, film i radio','slug' => 'telewizja_film_radio'),
		array('id' => '9','name' => 'Korzystanie z komputera i Internetu','slug' => 'korzystanie_z_komputera_i_internetu'),
		array('id' => '6','name' => 'Czytelnictwo','slug' => 'czytelnictwo'),
		array('id' => '5','name' => 'Muzyka, teatr','slug' => 'muzyka_teatr'),
		array('id' => '11','name' => 'Uczęszczanie do instytucji rozrywkowych, życie towarzyskie','slug' => 'instytucje_rozrywkowe_zycie_towarzyskie'),
		array('id' => '7','name' => 'Zwiedzanie','slug' => 'zwiedzanie'),
		array('id' => '4','name' => 'Domy kultury lokalne, instytucje kultury działalność hobbystyczna','slug' => 'domy_kultury'),
		array('id' => '1','name' => 'Opinie dotyczące uczestnictwa w kulturze i czasu wolnego','slug' => 'uczestnictwo_w_kulturze')
	);
	
	public $_regions = array('Centralny', 'Południowy', 'Wschodni', 'Północno-zachodni', 'Południowo-zachodni', 'Północny');
	public $_sizes = array('Miasta – razem', 'Miasta o liczbie mieszkańców 500 tys. i więcej', 'Miasta o liczbie mieszkańców 200-499 tys.', 'Miasta o liczbie mieszkańców 100-199 tys.', 'Miasta o liczbie mieszkańców 20-99 tys.', 'Miasta o liczbie mieszkańców poniżej 20 tys.', 'Wsie');
	public $_households = array('Gospodarstwa pracowników', 'Gospodarstwa robotnicze', 'Gospodarstwa nierobotnicze', 'Gospodarstwa rolników', 'Gospodarstwa pracujących na własny rachunek', 'Gospodarstwa emerytów i rencistów', 'Gospodarstwa emerytów', 'Gospodarstwa rencistów');
	public $_educations = array('Wyższe', 'Średnie', 'Zasadnicze zawodowe', 'Pozostałe');
	public $_ages = array('15 – 24 lat', '25 – 34 lata', '35 – 49 lat', '50 – 64 lata', '65 lat i więcej');
	public $_areas = array('Miasta', 'Wsie');
	
	public $file = false;
	
	private function getFile($slug) {
		
		$file = false;
		
		foreach( $this->params as $p ) {
			if( $p['slug']==$slug ) {
				
				$file = $p;
				break;
				
			}
		}
		
		if( $file===false )
			$file = $this->params[0];
			
		return $file;
		
	}
	
    public function file()
    {
		
		$this->set('_regions', $this->_regions);
		$this->set('_sizes', $this->_sizes);
		$this->set('_households', $this->_households);
		$this->set('_educations', $this->_educations);
		$this->set('_ages', $this->_ages);
		$this->set('_areas', $this->_areas);
		
		$this->file =  $this->getFile( @$this->request->params['slug'] );
		$this->set('file', $this->file);
		
        $datasets = $this->getDatasets('kultura');

        $options = array(
	        'browserTitle' => 'Wyniki wyszukiwania:',
            'searchTitle' => 'Szukaj...',
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Kultura',
                    'element' => 'cover',
                ),
                'aggs' => array(
	            	'ankiety' => array(
		            	'filter' => array(
			            	'bool' => array(
				            	'must' => array(
					            	array(
						            	'term' => array(
							            	'dataset' => 'kultura_ankiety',
						            	),
					            	),
					            	array(
						            	'term' => array(
							            	'data.kultura_ankiety.file_id' => $this->file['id'],
						            	),
					            	),
				            	),
			            	),
		            	),
		            	'scope' => 'global',
		            	'aggs' => array(
			            	'top' => array(
				            	'top_hits' => array(
					            	'size' => 500,
					            	'_source' => array('data', 'static'),
				            	),
			            	),
		            	),
	            	),
                ),
            ),
            /*
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
            */
            'apps' => true,
        );
		
		$this->chapter_selected = 'kultura';
        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }
    
    public function data() {
	    
	    $data = $this->Kultura->getData($this->request->params['id'], $this->request->query);
	    
	    $this->set('data', $data);
	    $this->set('_serialize', 'data');
	    
    }
    
    public function getChapters() {
		
		$items = array();
		foreach($this->params as $p) {
			
			$href = '/kultura';
			if( $p['slug'] )
				$href .= '/' . $p['slug'];
			
			$items[] = array(
				'id' => $p['id'],
				'label' => $p['name'],
				'href' => $href,
				'icon' => 'dot',
			);

		}
		
		return array(
			'items' => $items,
			'selected' => $this->file['id'],
		);
	    
    }

}