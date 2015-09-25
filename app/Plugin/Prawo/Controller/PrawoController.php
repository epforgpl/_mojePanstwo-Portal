<?php

App::uses('ApplicationsController', 'Controller');

class PrawoController extends ApplicationsController
{

    public $settings = array(
        'id' => 'prawo',
        'title' => 'Prawo',
        'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce',
        'headerImg' => 'prawo',
    );
    public $mainMenuLabel = 'Przeglądaj';
	
	public $submenus = array(
        'prawo' => array(
            'items' => array(
                array(
					'id' => 'aktualnosci',
					'label' => 'Aktualności',
					'href' => '/prawo/aktualnosci',
					'icon' => 'icon-datasets-sejm_komunikaty',
				),
				array(
					'id' => 'ustawy',
					'label' => 'Ustawy',
					'href' => '/prawo/ustawy',
					'icon' => 'icon-datasets-prawo ustawy',
				),
				array(
					'id' => 'rozporzadzenia',
					'label' => 'Rozporządzenia',
					'href' => '/prawo/rozporzadzenia',
					'icon' => 'icon-datasets-prawo rozporzadzenia',
				),
				array(
					'id' => 'umowy',
					'label' => 'Umowy międzynarodowe',
					'href' => '/prawo/umowy',
					'icon' => 'icon-datasets-prawo umowy',
				),
				array(
					'id' => 'inne',
					'label' => 'Inne akty prawne',
					'href' => '/prawo/inne',
					'icon' => 'icon-datasets-prawo inne',
				),
				array(
					'id' => 'lokalne',
					'label' => 'Prawo lokalne',
					'href' => '/prawo/lokalne',
					'icon' => 'icon-datasets-prawo lokalne',
				),
				array(
					'id' => 'urzedowe',
					'label' => 'Prawo urzędowe',
					'href' => '/prawo/urzedowe',
					'icon' => 'icon-datasets-prawo urzedowe',
				),
            )
        )
    );
	
    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('prawo');
        $_datasets = array_keys($datasets);

        $options = array(
            'searchTitle' => 'Szukaj w prawie...',
            'autocompletion' => array(
                'dataset' => 'prawo,prawo_hasla',
            ),
            'conditions' => array(
                'dataset' => $_datasets,
            ),
            'aggs' => array_merge(array(), $this->getChaptersAggs()),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Prawo',
                    'element' => 'cover',
                ),
                'aggs' => array(
                    'news' => array(
	                    'scope' => 'global',
	                    'filter' => array(
		                    'bool' => array(
			                    'must' => array(
				                    array(
					                    'term' => array(
						                    'dataset' => 'sejm_komunikaty',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.sejm_komunikaty.typ_id' => '0',
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
					                    'date' => 'desc',
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'konstytucja' => array(
	                    'filter' => array(
		                    'bool' => array(
			                    'must' => array(
				                    array(
					                    'term' => array(
						                    'dataset' => 'prawo',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.konstytucja' => '1',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.status_id' => '1',
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
	                    'scope' => 'global',
	                    'aggs' => array(
		                    'top' => array(
			                    'top_hits' => array(
				                    'size' => 10,
				                    'fielddata_fields' => array('dataset', 'id'),
				                    'sort' => array(
					                    'title.raw' => 'asc',
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'kodeksy' => array(
	                    'filter' => array(
		                    'bool' => array(
			                    'must' => array(
				                    array(
					                    'term' => array(
						                    'dataset' => 'prawo',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.kodeks' => '1',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.status_id' => '1',
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
	                    'scope' => 'global',
	                    'aggs' => array(
		                    'top' => array(
			                    'top_hits' => array(
				                    'size' => 10,
				                    'fielddata_fields' => array('dataset', 'id'),
				                    'sort' => array(
					                    'title.raw' => 'asc',
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                ),
            ),
            'apps' => true,
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }
    
    public function getChapters() {
				
		$mode = false;
				
		$items = array(
			array(
				'label' => 'Start',
				'href' => '/' . $this->settings['id'],
			),
		);
				
		if( isset($this->viewVars['dataBrowser']['aggs']['dataset']) && !empty($this->viewVars['dataBrowser']['aggs']['dataset']) ) {
			
			$keys = array();
			foreach( $this->viewVars['dataBrowser']['aggs']['dataset'] as $k => $v )
				if( @$v['doc_count'] )
					$keys[] = $k;
								
			$items[] = array(
				'id' => '_results',
				'label' => 'Wyniki wyszukiwania',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
			);
			
			if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';
			
			
			foreach( $this->submenus['prawo']['items'] as $item ) {
				if( in_array($item['id'], $keys) ) {
					$item['href'] .= '?q=' . urlencode( $this->request->query['q'] );
					$items[] = $item;
				}
			}
			
			
		} else {
		
			$items = array_merge($items, $this->submenus['prawo']['items']);
		
		}
						
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);
				
		return $output;
		
	}
	
	public function aktualnosci()
    {
 	    $this->title = 'Aktualności prawne';
        $this->loadDatasetBrowser('sejm_komunikaty', array(
            'conditions' => array(
                'dataset' => 'sejm_komunikaty',
                'sejm_komunikaty.typ_id' => '0',
            ),
            'aggs' => array_merge(array(), $this->getChaptersAggs()),
        ));
    }
    
    public function lokalne()
    {
	    $this->title = 'Prawo lokalne';
        $this->loadDatasetBrowser('prawo_wojewodztwa', array(
	        'aggs' => array_merge(array(), $this->getChaptersAggs()),
        ));
    }
    
    public function urzedowe()
    {
	    $this->title = 'Prawo urzędowe';
        $this->loadDatasetBrowser('prawo_urzedowe', array(
	        'aggs' => array_merge(array(), $this->getChaptersAggs()),
        ));
    }
    
    public function ustawy()
    {
        $this->title = 'Ustawy';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.typ_id' => '1',
            ),
            'menu' => array_merge($this->submenus['prawo'], array(
                'selected' => 'ustawy',
                'base' => '/prawo'
            )),
            'aggsPreset' => null,
            'aggs' => array_merge(array(
	            'date' => array(
	                'date_histogram' => array(
	                    'field' => 'date',
	                    'interval' => 'year',
	                    'format' => 'yyyy-MM-dd',
	                ),
	                'visual' => array(
	                    'label' => 'Liczba aktów prawnych w czasie',
	                    'all' => 'Wydane kiedykolwiek',
	                    'skin' => 'date_histogram',
	                    'field' => 'date'
	                ),
	            ),
            ), $this->getChaptersAggs()),
            'sortPreset' => 'prawo',
            'phrasesPreset' => 'ustawy',
        ));
    }
    
    private function getChaptersAggs() {
	    
	    if( isset($this->request->query['q']) && $this->request->query['q'] ) {
	    
		    return array(
		    	'dataset' => array(
				    'filter' => array(
					    'match_all' => '_empty',
				    ),
				    'scope' => 'query',
				    'aggs' => array(
					    'aktualnosci' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'sejm_komunikaty',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.sejm_komunikaty.typ_id' => '0',
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'ustawy' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => '1',
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'rozporzadzenia' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => '3',
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'umowy' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => array('6', '7', '8', '10', '11', '12'),
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'inne' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => array('0', '2', '4', '5', '9', '13', '14', '15'),
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'lokalne' => array(
						    'filter' => array(
							    'term' => array(
								    'dataset' => 'prawo_wojewodztwa',
							    ),
						    ),
					    ),
					    'urzedowe' => array(
						    'filter' => array(
							    'term' => array(
								    'dataset' => 'prawo_urzedowe',
							    ),
						    ),
					    ),
				    ),
				),
		    );
	    
	    } else return array();
	    
    }
    
    public function rozporzadzenia()
    {
        $this->title = 'Rozporządzenia';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.typ_id' => '3',
            ),
            'menu' => array_merge($this->submenus['prawo'], array(
                'selected' => 'rozporzadzenia',
                'base' => '/prawo'
            )),
            'aggsPreset' => null,
            'phrasesPreset' => 'rozporzadzenia',
            'aggs' => array_merge(array(
	            'date' => array(
	                'date_histogram' => array(
	                    'field' => 'date',
	                    'interval' => 'year',
	                    'format' => 'yyyy-MM-dd',
	                ),
	                'visual' => array(
	                    'label' => 'Liczba aktów prawnych w czasie',
	                    'all' => 'Wydane kiedykolwiek',
	                    'skin' => 'date_histogram',
	                    'field' => 'date'
	                ),
	            ),
	            'autor_id' => array(
	                'terms' => array(
	                    'field' => 'prawo.autor_id',
	                    'exclude' => array(
	                        'pattern' => '0'
	                    ),
	                ),
	                'aggs' => array(
	                    'label' => array(
	                        'terms' => array(
	                            'field' => 'data.prawo.autor_nazwa',
	                        ),
	                    ),
	                ),
	                'visual' => array(
	                    'label' => 'Autorzy aktów prawnych',
	                    'all' => 'Wszyscy autorzy',
	                    'skin' => 'columns_horizontal',
	                    'field' => 'prawo.autor_id'
	                ),
	            ),
            ), $this->getChaptersAggs()),
        ));
    }
    
    public function umowy()
    {
        $this->title = 'Umowy międzynarodowe';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.typ_id' => array('6', '7', '8', '10', '11', '12'),
            ),
            'menu' => array_merge($this->submenus['prawo'], array(
                'selected' => 'umowy',
                'base' => '/prawo'
            )),
            'aggsPreset' => null,
            'phrasesPreset' => 'umowy_miedzynarodowe',
            'aggs' => array_merge(array(
	            'date' => array(
	                'date_histogram' => array(
	                    'field' => 'date',
	                    'interval' => 'year',
	                    'format' => 'yyyy-MM-dd',
	                ),
	                'visual' => array(
	                    'label' => 'Liczba aktów prawnych w czasie',
	                    'all' => 'Wydane kiedykolwiek',
	                    'skin' => 'date_histogram',
	                    'field' => 'date'
	                ),
	            ),
            ), $this->getChaptersAggs()),
        ));
    }
	
	public function inne()
    {
        $this->title = 'Inne akty prawne';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.typ_id' => array('0', '2', '4', '5', '9', '13', '14', '15'),
            ),
            'menu' => array_merge($this->submenus['prawo'], array(
                'selected' => 'inne',
                'base' => '/prawo'
            )),
            'aggsPreset' => null,
            'phrasesPreset' => 'akty_prawne',
            'aggs' => array_merge(array(
	            'date' => array(
	                'date_histogram' => array(
	                    'field' => 'date',
	                    'interval' => 'year',
	                    'format' => 'yyyy-MM-dd',
	                ),
	                'visual' => array(
	                    'label' => 'Liczba aktów prawnych w czasie',
	                    'all' => 'Wydane kiedykolwiek',
	                    'skin' => 'date_histogram',
	                    'field' => 'date'
	                ),
	            ),
	            'autor_id' => array(
	                'terms' => array(
	                    'field' => 'prawo.autor_id',
	                    'exclude' => array(
	                        'pattern' => '0'
	                    ),
	                ),
	                'aggs' => array(
	                    'label' => array(
	                        'terms' => array(
	                            'field' => 'data.prawo.autor_nazwa',
	                        ),
	                    ),
	                ),
	                'visual' => array(
	                    'label' => 'Autorzy aktów prawnych',
	                    'all' => 'Wszyscy autorzy',
	                    'skin' => 'columns_horizontal',
	                    'field' => 'prawo.autor_id'
	                ),
	            ),
            ), $this->getChaptersAggs()),
        ));
    }
	
} 