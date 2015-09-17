<?php

App::uses('ApplicationsController', 'Controller');

class NgoController extends ApplicationsController
{

    public $settings = array(
        'id' => 'ngo',
        'title' => 'NGO',
        'subtitle' => 'Organizacje pozarządowe w Polsce',
        'headerImg' => 'ngo',
    );
	
	public $components = array('RequestHandler');
	
    public $submenus = array(
        'ngo' => array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Start',
                ),
                array(
                    'id' => 'dzialania',
                    'label' => 'Działania',
                ),
                array(
                    'id' => 'fundacje',
                    'label' => 'Fundacje',
                ),
                array(
                    'id' => 'stowarzyszenia',
                    'label' => 'Stowarzyszenia',
                ),
            )
        )
    );

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function addDeclaration()
    {

        $status = $this->Ngo->addDeclaration($this->request->data);
        if ($status) {
            $this->Session->setFlash('Twoje zgłoszenie zostało zapisane. Skontaktujemy się z Tobą w najbliższym czasie.');
        } else {
            $this->Session->setFlash('Wystąpił problem z wysyłaniem zgłoszenia');
        }

        return $this->redirect('/ngo');

    }
	
	public function map() {
		
		if(
			isset($this->request->query['ne_lat']) && 
			isset($this->request->query['ne_lng']) && 
			isset($this->request->query['sw_lat']) && 
			isset($this->request->query['sw_lng']) &&
			isset($this->request->query['z'])
		) {
			
			$precision = floor( $this->request->query['z'] / 2 );
			
			$options = array(
	            'cover' => array(
		            'force' => true,
	                'aggs' => array(
	                    'map' => array(
		                    'scope' => 'global',
		                    'filter' => array(
			                    'bool' => array(
				                    'must' => array(
					                    array(
						                    'term' => array(
							                    'dataset' => 'krs_podmioty',
						                    ),
					                    ),
					                    array(
						                    'term' => array(
							                    'data.krs_podmioty.forma_prawna_typ_id' => '2',
						                    ),
					                    ),
					                    array(
						                    'term' => array(
							                    'data.krs_podmioty.wykreslony' => '0',
						                    ),
					                    ),
					                    array(
						                    'geo_bounding_box' => array(
							                    'position' => array(
								                    'top_left' => array(
									                    'lat' => $this->request->query['ne_lat'],
									                    'lon' => $this->request->query['sw_lng'],
								                    ),
								                    'bottom_right' => array(
									                    'lat' => $this->request->query['sw_lat'],
									                    'lon' => $this->request->query['ne_lng'],
								                    ),
							                    ),
						                    ),
					                    ),
				                    ),
			                    ),
		                    ),
		                    'aggs' => array(
			                    'grid' => array(
				                    'geohash_grid' => array(
						                'field' => 'position',
						                'precision' => $precision,
						            ),
						            'aggs' => array(
					                    'inner_grid' => array(
						                    'geohash_grid' => array(
								                'field' => 'position',
								                'precision' => $precision + 1,
								                'size' => 1,
								            ),
					                    ),
					                    'lat' => array(
						                    'terms' => array(
							                    'field' => 'position.lat',
							                    'size' => 1,
						                    ),
					                    ),
					                    'lng' => array(
						                    'terms' => array(
							                    'field' => 'position.lon',
							                    'size' => 1,
						                    ),
					                    ),
					                    'id' => array(
						                    'terms' => array(
							                    'field' => 'id',
							                    'size' => 1,
						                    ),
					                    ),
					                    'name' => array(
						                    'terms' => array(
							                    'field' => 'title.raw',
							                    'size' => 1,
						                    ),
					                    ),
					                    'form' => array(
						                    'terms' => array(
							                    'field' => 'data.krs_podmioty.forma_prawna_str',
							                    'size' => 1,
						                    ),
					                    ),
				                    ),
			                    ),
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
		
		if( $this->request->params['action']=='map' ) {
			
			$data = $this->viewVars['dataBrowser']['aggs']['map'];
			foreach( $data['grid']['buckets'] as &$b ) {
				
				if( $b['doc_count']===1 ) {
				
					$b['lat'] = $b['lat']['buckets'][0]['key'];
					$b['lng'] = $b['lng']['buckets'][0]['key'];
					$b['name'] = $b['name']['buckets'][0]['key'];
					$b['id'] = $b['id']['buckets'][0]['key'];
					$b['form'] = $b['form']['buckets'][0]['key'];
				
				} else {
					
					unset( $b['lat'] );
					unset( $b['lng'] );
					unset( $b['name'] );
					unset( $b['id'] );
					unset( $b['desc'] );
					
				}
				
				$b['inner_key'] = $b['inner_grid']['buckets'][0]['key'];
				unset( $b['inner_grid'] );
				
			}
						
			$this->viewVars['dataBrowser'] = $data;
			
		}
		
	}
	
    public function view()
    {

        $options = array(
            'searchTitle' => 'Szukaj w organizacjach pozarządowych...',
            'autocompletion' => array(
                'dataset' => 'ngo',
            ),
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.forma_prawna_typ_id' => array('2'),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Ngo',
                    'element' => 'cover',
                ),
                'aggs' => array(
                    'dzialania' => array(
                        'scope' => 'global',
                        'filter' => array(
                            'term' => array(
	                            'dataset' => 'dzialania',
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 3,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'fundacje' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'data.krs_podmioty.forma_prawna_id' => '1',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 5,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'stowarzyszenia' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'data.krs_podmioty.forma_prawna_id' => '15',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 5,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => array(
                            'krs_podmioty' => 'Organizacje',
                        ),
                    ),
                ),
            ),
        );

        $this->set('_submenu', array_merge($this->submenus['ngo'], array(
            'selected' => '',
        )));
		
        $this->title = 'Organizacje pozarządowe i akcje społeczne';
		
        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

	public function dzialania()
    {
        $this->loadDatasetBrowser('dzialania', array(
	        'conditions' => array(
		        'dataset' => 'dzialania',
		        'dzialania.status' => '1',
	        ),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'dzialania',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Działania organizacji społecznych');

    }
	
	public function fundacje()
    {
        $this->loadDatasetBrowser('krs_podmioty', array(
	        'conditions' => array(
		        'krs_podmioty.forma_prawna_id' => '1',
	        ),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'fundacje',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Fundacje | NGO');

    }

    public function stowarzyszenia()
    {
        $this->set('_submenu', array_merge($this->submenus['ngo'], array(
            'selected' => 'stowarzyszenia',
        )));

        $this->loadDatasetBrowser('krs_podmioty', array(
	        'conditions' => array(
		        'krs_podmioty.forma_prawna_id' => '15',
	        ),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'stowarzyszenia',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Stowarzyszenia | NGO');

    }
    
    public function getChapters() {
	    
	    $mode = false;
				
		$items = array(
			array(
				'label' => 'Start',
				'href' => '/' . $this->settings['id'],
			),
		);
		
		$items[] = array(
			'id' => 'dzialania',
			'label' => 'Działania społeczne',
			'href' => '/ngo/dzialania',
		);
		
		$items[] = array(
			'id' => 'fundacje',
			'label' => 'Fundacje',
			'href' => '/ngo/fundacje',
		);
		
		$items[] = array(
			'id' => 'stowarzyszenia',
			'label' => 'Stowarzyszenia',
			'href' => '/ngo/stowarzyszenia',
		);
						
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);
				
		return $output;    
	    
    }

}
