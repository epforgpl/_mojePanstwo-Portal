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
	
	public $menu = array(
		'sejm_komunikaty' => array(
			'menu_id' => 'aktualnosci',
			'label' => 'Aktualności',
			'icon' => 'sejm_komunikaty',
		),
		'prawo_hasla' => array(
			'menu_id' => 'tematy',
			'label' => 'Tematy',
			'icon' => 'prawo_hasla',
		),
		/*
		'pisma' => array(
			'menu_id' => 'pisma',
			'label' => 'Pisma',
			'icon' => 'pisma',
		),
		'zbiorki_publiczne' => array(
			'menu_id' => 'zbiorki',
			'label' => 'Zbiórki publiczne',
			'separator' => 'bottom',
		),
		*/
		'_typy' => array(
			'label' => 'Przeglądaj według typów:',
			'class' => '__label border-top',
			'icon' => 'prawo',
			'typ_id' => '_all',
		),
		'ustawy' => array(
			'menu_id' => 'ustawy',
			'label' => 'Ustawy',
			'typ_id' => '1',
			'icon' => 'dot',
			'typ_id' => '1',
			'submenu' => true,
		),
		'rozporzadzenia' => array(
			'menu_id' => 'rozporzadzenia',
			'label' => 'Rozporządzenia',
			'typ_id' => '2',
			'icon' => 'dot',
			'typ_id' => '3',
			'submenu' => true,
		),
		'umowy' => array(
			'menu_id' => 'umowy',
			'label' => 'Umowy międzynarodowe',
			'typ_id' => '18',
			'icon' => 'dot',
			'typ_id' => array('6', '7', '8', '10', '11', '12'),
			'submenu' => true,
		),
		'inne' => array(
			'menu_id' => 'inne',
			'label' => 'Pozostałe',
			'icon' => 'dot',
			'typ_id' => '_other',
			'submenu' => true,
		),
		'_publikatory' => array(
			'label' => 'Przeglądaj według publikatora:',
			'class' => '__label border-top',
			'icon' => 'prawo',
			'tag' => 'publikatory',
		),
		'dziennik_ustaw' => array(
			'menu_id' => 'dziennik_ustaw',
			'label' => 'Dziennik Ustaw',
			'icon' => 'dot',
			'publikator_id' => 'DzU',
			'submenu' => true,
		),
		'monitor_polski' => array(
			'menu_id' => 'monitor_polski',
			'label' => 'Monitor Polski',
			'icon' => 'dot',
			'publikator_id' => 'MP',
			'submenu' => true,
		),
		'prawo_wojewodztwa' => array(
			'menu_id' => 'lokalne',
			'label' => 'Prawo lokalne',
			'icon' => 'dot',
			'submenu' => true,
		),
		'prawo_urzedowe' => array(
			'menu_id' => 'urzedowe',
			'label' => 'Prawo urzędowe',
			'icon' => 'dot',
			'submenu' => true,
		),
	);
	
	public $_aggs = array(
        'dataset' => array(
            'terms' => array(
                'field' => 'dataset',
            ),
            'aggs' => array(
                'typ' => array(
                    'terms' => array(
	                    'field' => 'data.prawo.typ_id',
	                    'size' => 100,
                    ),
                ),
                'publikator' => array(
	                'terms' => array(
		                'field' => 'data.prawo.zrodlo',
		                'size' => 100,
	                ),
                ),
            ),
        ),
    );
	
	private function getSubAggs() {
	    return array(
	        '_query' => array(
	            'filter' => array(
		            'or' => array(
			            array(
				            'terms' => array(
					            'dataset' => array('prawo', 'prawo_hasla', 'prawo_wojewodztwa', 'prawo_urzedowe'),
				            ),
			            ),
			            array(
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
	            ),
	            'scope' => 'query',
	            'aggs' => $this->_aggs,
	        ),
	    );
    }
	
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
            'searchTag' => array(
	            'href' => '/prawo',
	            'label' => 'Prawo',
            ),
            'autocompletion' => array(
                'dataset' => 'prawo,prawo_hasla',
            ),
            'conditions' => array(
                'dataset' => array(
	                'prawo',
	                'prawo_hasla',
	                'prawo_wojewodztwa',
	                'prawo_urzedowe',
	                'sejm_komunikaty{sejm_komunikaty.typ_id:0}'
                ),
            ),
            'aggs' => $this->_aggs,
            'cover' => array(
                'cache' => true,
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
				                    'size' => 10,
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
				                    'size' => 1,
				                    'fielddata_fields' => array('dataset', 'id'),
				                    'sort' => array(
					                    'date' => 'desc',
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
    
    /*
    public function getChapters() {
				
		$mode = false;
				
		$items = array();
						
		if( isset($this->viewVars['dataBrowser']['aggs']['dataset']) && !empty($this->viewVars['dataBrowser']['aggs']['dataset']) ) {
			
			$keys = array();
			foreach( $this->viewVars['dataBrowser']['aggs']['dataset'] as $k => $v )
				if( @$v['doc_count'] )
					$keys[] = $k;
								
			$items[] = array(
				'id' => '_results',
				'label' => 'Wyniki wyszukiwania:',
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
			
			$items[] = array(
				'label' => 'Start',
				'href' => '/' . $this->settings['id'],
			);
			$items = array_merge($items, $this->submenus['prawo']['items']);
		
		}
						
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);
				
		return $output;
		
	}
	*/
	
	public function aktualnosci()
    {
 	    $this->title = 'Aktualności prawne';
        $this->loadDatasetBrowser('sejm_komunikaty', array(
            'conditions' => array(
                'dataset' => 'sejm_komunikaty',
                'sejm_komunikaty.typ_id' => '0',
            ),
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function lokalne()
    {
	    $this->title = 'Prawo lokalne';
        $this->loadDatasetBrowser('prawo_wojewodztwa', array(
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function urzedowe()
    {
	    $this->title = 'Prawo urzędowe';
        $this->loadDatasetBrowser('prawo_urzedowe', array(
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function tematy()
    {
	    $this->title = 'Prawo urzędowe';
        $this->loadDatasetBrowser('prawo_hasla', array(
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function ustawy()
    {
        $this->title = 'Ustawy';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.typ_id' => 1,
            ),
            'aggs' => $this->getSubAggs(),
            'sortPreset' => 'prawo',
            'phrasesPreset' => 'ustawy',
        ));
    }
    
    public function dziennik_ustaw()
    {
        $this->title = 'Dziennik Ustaw';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.zrodlo' => 'DzU',
            ),
            'aggs' => $this->getSubAggs(),
            'sortPreset' => 'prawo',
            'phrasesPreset' => 'akty_prawne',
        ));
    }
    
    public function monitor_polski()
    {
        $this->title = 'Monitor Polski';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.zrodlo' => 'MP',
            ),
            'aggs' => $this->getSubAggs(),
            'sortPreset' => 'prawo',
            'phrasesPreset' => 'akty_prawne',
        ));
    }
    
    public function getChapters() {

		$mode = false;
		$items = array();
		$app = $this->getApplication( $this->settings['id'] );		
		
		if( @$this->viewVars['dataBrowser']['aggs']['_query']['dataset']['buckets'] )
			$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] = $this->viewVars['dataBrowser']['aggs']['_query']['dataset']['buckets'];
					
		if(
			isset( $this->request->query['q'] ) &&
			$this->request->query['q']
		) {
			
			$items[] = array(
				'id' => '_results',
				'label' => 'Szukaj w prawie:',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
				'tool' => array(
					'icon' => 'search',
					'href' => '/' . $this->settings['id'],
				),
				'icon' => 'appIcon',
				'appIcon' => $app['icon'],
				'class' => '_label',
			);

			if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';

		}

		$others_count = 0;
		$_typy = 0;
		$_publikatory = 0;
		
		foreach( $this->menu as $key => $value ) {
						
			if( !isset($value['menu_id']) )
				$value['menu_id'] = '';
						
			$item = array(
				'id' => $value['menu_id'],
				'label' => $value['label'],
				'submenu' => isset($value['submenu']) ? $value['submenu'] : false,
			);
			
			if( $value['menu_id'] )
				$item['href'] = '/' . $this->settings['id'] . '/' . $value['menu_id'];
			
			if( isset($value['icon']) )
				$item['icon'] = 'icon-datasets-' . $value['icon'];
				
			if( isset($value['class']) )
				$item['class'] = $value['class'];

			if( $mode == 'results' ) {
			
				
				$datasets = array();
				
				if( isset($item['href']) )
					$item['href'] .= '?q=' . urlencode( $this->request->query['q'] );
				
				if( @$value['typ_id'] ) {
					
					if( @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] ) {
						foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {
													
							if( $dataset['key']=='prawo' ) {
								
								if( $value['typ_id']=='_all' ) {
									
									if( $dataset['doc_count'] );
										$items[] = $item;
									
								} else {
																		
									foreach( $dataset['typ']['buckets'] as $forma ) {
										if( $forma['doc_count'] ) {
											
											if( is_array($value['typ_id']) && in_array($forma['key'], $value['typ_id']) ) {
												
												if( !$_typy ) {
													
													$item['tag'] = 'typ';
													$items[] = $item;
													
												}
												
												$_typy += $forma['doc_count'];
																														
											} elseif( $value['typ_id'] == $forma['key'] ) {
												
												$item['count'] = $forma['doc_count'];
												$items[] = $item;
													
											} elseif( ($value['typ_id']=='_other') && !in_array($forma['key'], array('1', '3', '6', '7', '8', '10', '11', '12')) ) {
												
												$others_count += $forma['doc_count'];
												
											}
																				
										}
									}
																		
									if( ($value['typ_id']=='_other') && $others_count ) {
										
										$item['count'] = $others_count;
										$items[] = $item;
										
									}
								
								}
								
							}
							
						}
					}
					
				} elseif( @$value['publikator_id'] ) {
					
									
					if( @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] ) {
						foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {
													
							if( ($dataset['key']=='prawo') && ($ps = @$dataset['publikator']['buckets']) ) {
								
								foreach( $ps as $p ) {
									if( $p['key'] == $value['publikator_id'] ) {
										
										$item['count'] = $p['doc_count'];
										$items[] = $item;
										
										$_publikatory += $p['doc_count'];
										
									}
								}			
								
							}
							
						}
					}
					
				} else {
													
					if( $key == '_publikatory' ) {
						
						$items[] = $item;
						
					} elseif( @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] ) {
						foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {
							if( ($dataset['key'] == $key) && $dataset['doc_count'] ) {
									
								$item['count'] = $dataset['doc_count'];
								$items[] = $item;
								
								if( in_array($key, array('prawo_wojewodztwa', 'prawo_urzedowe', 'prawo')) )
									$_publikatory += $dataset['doc_count'];
								
							} 
						}
					}
					
				}

			} else {

				$items[] = $item;

			}
			
		}
		
		
		
        foreach($items as $i => $item) {
			
			if( @$item['tag']=='typ' )
				$items[$i]['count'] = $_typy;
				
			if( @$item['tag']=='publikatory' )
				$items[$i]['count'] = $_publikatory;

        }
                		
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

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
            'phrasesPreset' => 'rozporzadzenia',
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function umowy()
    {
        $this->title = 'Umowy międzynarodowe';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.typ_id' => array('6', '7', '8', '10', '11', '12'),
            ),
            'phrasesPreset' => 'umowy_miedzynarodowe',
            'aggs' => $this->getSubAggs(),
        ));
    }
	
	public function inne()
    {
        $this->title = 'Inne akty prawne';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.typ_id' => array('0', '2', '4', '5', '9', '13', '14', '15'),
            ),
            'phrasesPreset' => 'akty_prawne',
	        'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function powszechne() {
	    return $this->redirect('/prawo');
    }
	
} 