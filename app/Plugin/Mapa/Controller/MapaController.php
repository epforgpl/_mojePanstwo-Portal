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

        $options = array(
            'searchTag' => array(
                'href' => '/mapa',
                'label' => 'Mapa',
            ),
            'conditions' => array(
                'dataset' => array('miejsca'),
                'miejsca.ignore' => false,
            ),
            'apps' => true,
            'limit' => 10,
            'apps' => true,
        );

        $layers = '';
		if( isset( $this->request->params['layers'] ) )
			$layers = $this->request->params['layers'];

        $this->set('layers', $layers);
        $this->Components->load('Dane.DataBrowser', $options);
    }

    public function getChapters() {

		$mode = false;
		$items = array(
			array(
				'id' => 'adm',
				'label' => 'Podział administracyjny',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			array(
				'id' => 'wojewodztwa',
				'href' => '/mapa/wojewodztwa',
				'label' => 'Województwa',
				'icon' => 'icon-datasets-dot',
			),
			array(
				'id' => 'powiaty',
				'href' => '/mapa/powiaty',
				'label' => 'Powiaty',
				'icon' => 'icon-datasets-dot',
			),
			array(
				'id' => 'gminy',
				'href' => '/mapa/gminy',
				'label' => 'Gminy',
				'icon' => 'icon-datasets-dot',
			),
			array(
				'id' => 'krs',
				'href' => '/mapa/krs',
				'label' => 'Organizacje',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			array(
				'id' => 'ngo',
				'href' => '/mapa/ngo',
				'label' => 'NGO',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			/*
			array(
				'id' => 'instytucje',
				'href' => '/mapa/instytucje',
				'label' => 'Instytucje publiczne',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			array(
				'id' => 'wybory',
				'href' => '/mapa/wybory',
				'label' => 'Komisje wyborcze',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			*/
		);

        $output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}

    public function layer()
    {

        if (
            isset($this->request->query['tl']) &&
            isset($this->request->query['br']) &&
            @$this->request->query['layer'] 
        ) {

            $tl = $this->request->query['tl'];
			$br = $this->request->query['br'];

            $strlen = strlen($tl);
            $zoom = isset( $this->request->query['zoom'] ) ? $this->request->query['zoom'] : (2 * $strlen);

            $must = array(
                array(
                    'geo_bounding_box' => array(
                        'adres.geo' => array(
                            'top_left' => $tl,
                            'bottom_right' => $br,
                        ),
                    ),
                ),
            );

            if ($this->request->query['layer'] == 'biznes') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'krs_podmioty',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.forma_prawna_typ_id' => '1',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.wykreslony' => '0',
                    ),
                );

            } elseif ($this->request->query['layer'] == 'krs') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'krs_podmioty',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.wykreslony' => '0',
                    ),
                );

            } elseif ($this->request->query['layer'] == 'ngo') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'krs_podmioty',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.forma_prawna_typ_id' => '2',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.wykreslony' => '0',
                    ),
                );

            } elseif ($this->request->query['layer'] == 'komisje_wyborcze') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'wybory_parl_obwody',
                    ),
                );

            }

			// 6 => wojewodztwa
			// 7 => wojewodztwa
            // 8 => 3
            // 9 => 4
            // 10 => 4
            // 11 => 5
            // 12 => 5
            // 13 => 5
            // 14 => 6
            // 15 => 6
            // 16 => 7
            // 17 => 7
            // 18 => punkty
            // 19 => punkty
            // 20 => punkty
            
            if( $zoom < 9 )
            	$precision = 3;
            elseif( $zoom < 11 )
            	$precision = 4;
            elseif( $zoom < 14 )
            	$precision = 5;
            elseif( $zoom < 16 )
            	$precision = 6;
            elseif( $zoom < 18 )
            	$precision = 7;
            elseif( $zoom < 19 )
            	$precision = 8;
            else
            	$precision = 9; 
            	
            $options = array(
                'cover' => array(
                    'force' => true,
                    'aggs' => array(
                        'map' => array(
                            'scope' => 'global',
                            'filter' => array(
                                'bool' => array(
                                    'must' => $must,
                                    '_cache' => true,
                                ),
                            ),
                            'aggs' => array(),
                        ),
                    ),
                ),
            );
            
            
            if( $zoom < 16 ) {
	            
	            $options['cover']['aggs']['map']['aggs']['grid'] = array(
                    'geohash_grid' => array(
                        'field' => 'adres.geo',
                        'precision' => $precision,
                    ),
                    'aggs' => array(
                        'top' => array(
                            'top_hits' => array(
                                'size' => 1,
                                '_source' => array('adres.*'),
                                'fields' => array(),
                            ),
                        ),
                    ),
                );
	            
	            if( $precision < 12 ) {
		            
		            $options['cover']['aggs']['map']['aggs']['grid']['aggs']['inner_grid'] = array(
		                'geohash_grid' => array(
		                    'field' => 'adres.geo',
		                    'precision' => $precision + 1,
		                    'size' => 1,
		                ),
		            );
		            
	            }
	            
            } else {
	            
	            $options['cover']['aggs']['map']['aggs']['points'] = array(
		            'terms' => array(
			            'field' => 'adres.punkt_id',
		            ),
	            );
	            
            }
            
            

            $this->Components->load('Dane.DataBrowser', $options);
            $this->set('_serialize', 'dataBrowser');


        } else {

            throw new BadRequestException('Required parameters missing');

        }

    }
    
    public function points()
    {

        if (
            isset($this->request->query['tl']) &&
            isset($this->request->query['br'])
        ) {

            $tl = $this->request->query['tl'];
			$br = $this->request->query['br'];

            $strlen = strlen($tl);
            $zoom = isset( $this->request->query['zoom'] ) ? $this->request->query['zoom'] : (2 * $strlen);
                        	
            $options = array(
                'cover' => array(
                    'force' => true,
                    'aggs' => array(
                        'map' => array(
                            'scope' => 'global',
                            'filter' => array(
                                'term' => array(
	                                'dataset' => 'miejsca',
                                ),
                            ),
                            'aggs' => array(
	                            'numery' => array(
		                            'nested' => array(
			                            'path' => 'miejsca-numery',
		                            ),
		                            'aggs' => array(
			                            'area' => array(
				                            'filter' => array(
					                            'geo_bounding_box' => array(
							                        'miejsca-numery.location' => array(
							                            'top_left' => $tl,
							                            'bottom_right' => $br,
							                        ),
							                    ),
				                            ),
				                            'aggs' => array(
					                            'miejsca' => array(
						                            'terms' => array(
							                            'field' => 'miejsca-numery.miejsce_id',
						                            ),
						                            'aggs' => array(
							                            'punkty' => array(
								                            'terms' => array(
									                            'field' => 'miejsca-numery.id',
									                            'size' => 1000,
								                            ),
								                            'aggs' => array(
									                            'numer' => array(
										                            'terms' => array(
											                            'field' => 'miejsca-numery.numer',
											                            'size' => 1,
										                            ),
									                            ),
									                            'lat' => array(
										                            'terms' => array(
											                            'field' => 'miejsca-numery.location.lat',
											                            'size' => 1,
										                            ),
									                            ),
									                            'lon' => array(
										                            'terms' => array(
											                            'field' => 'miejsca-numery.location.lon',
											                            'size' => 1,
										                            ),
									                            ),
								                            )
							                            ),
							                            'reverse' => array(
								                            'reverse_nested' => '_empty',
								                            'aggs' => array(
									                            'miejsce' => array(
										                            'top_hits' => array(
											                            'size' => 1,
											                            '_source' => array(
												                            'include' => 'data'
											                            )
										                            ),
									                            ),
								                            ),
							                            ),
						                            ),
					                            ),
				                            ),
			                            ),
		                            ),
	                            ),
	                            
	                            	                            
	                            
	                            /*
                                'grid' => array(
                                    'geohash_grid' => array(
                                        'field' => 'adres.geo',
                                        'precision' => $precision,
                                    ),
                                    'aggs' => array(
                                        'top' => array(
                                            'top_hits' => array(
                                                'size' => 1,
                                                'fielddata_fields' => array('adres.geo.lat', 'adres.geo.lon'),
                                                '_source' => false,
                                                'fields' => array(),
                                            ),
                                        ),
                                    ),
                                ),
                                */
                                
                            ),
                        ),
                    ),
                ),
            );
            
            $this->Components->load('Dane.DataBrowser', $options);
            $this->set('_serialize', 'dataBrowser');


        } else {

            throw new BadRequestException('Required parameters missing');

        }

    }

    public function beforeRender()
    {

        parent::beforeRender();

        $this->setLayout(array('header' => false, 'footer' => false));

        if ($this->request->params['action'] == 'layer') {

            $data = $this->viewVars['dataBrowser']['aggs']['map'];
            
            if( !empty($data['grid']['buckets']) ) {
	            foreach ($data['grid']['buckets'] as &$b) {
	
	                if ($b['doc_count'] === 1) {
																
	                    $b['location'] = array(
	                        'punkt_id' => $b['top']['hits']['hits'][0]['_source']['adres']['punkt_id'],
	                        'lokal' => $b['top']['hits']['hits'][0]['_source']['adres']['lokal'],
	                        'lat' => $b['top']['hits']['hits'][0]['_source']['adres']['geo']['lat'],
	                        'lon' => $b['top']['hits']['hits'][0]['_source']['adres']['geo']['lon'],
	                    );
	
	                    unset($b['top']);
	
	                } else {
	
	                    unset($b['top']);
	
	                }
					
					if( isset($b['inner_grid']) ) {
		                $b['inner_key'] = $b['inner_grid']['buckets'][0]['key'];
		                unset($b['inner_grid']);
	                }
	
	            }
            }

            $this->viewVars['dataBrowser'] = $data;
			
		} elseif($this->request->params['action'] == 'points') {	
			
			$miejsca = array();
			foreach( $this->viewVars['dataBrowser']['aggs']['map']['numery']['area']['miejsca']['buckets'] as $_m ) {
								
				$points = array();
				
				foreach( $_m['punkty']['buckets'] as $b ) {
					$points[] = array(
						'id' => $b['key'],
						'numer' => $b['numer']['buckets'][0]['key'],
						'lat' => $b['lat']['buckets'][0]['key'],
						'lon' => $b['lon']['buckets'][0]['key'],
					);
				}
				
				$m = array(
					'miejsce' => array(
						'id' => $_m['key'],
					),
					'punkty' => $points,
				);
				
				if( @$_m['reverse']['miejsce']['hits']['hits'][0]['_source']['data']['miejsca'] )
					$m['miejsce'] = array_merge($_m['reverse']['miejsce']['hits']['hits'][0]['_source']['data']['miejsca'], $m['miejsce']);
								
				$miejsca[] = $m;
				
			}
			
			$this->viewVars['dataBrowser'] = $miejsca;
		
        } else {

            if (
                (@$this->viewVars['dataBrowser']['mode'] == 'cover') &&
                ($hits = @$this->viewVars['dataBrowser']['aggs']['miejsca']['top']['hits']['hits'])
            ) {

                $wojewodztwa = array();

                foreach ($hits as $h)
                    $wojewodztwa[] = array_merge($h['_source']['data'], $h['_source']['static']);

                $this->set('mapParams', array(
                    'mode' => 'start',
                    'title' => 'Mapa',
                    'children' => array(
                        'wojewodztwa' => $wojewodztwa,
                    ),
                    // 'viewport' => $viewport,
                ));

            }

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
