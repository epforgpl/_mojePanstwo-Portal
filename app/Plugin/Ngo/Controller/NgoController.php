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
            $this->Session->setFlash('Twoje zgłoszenie zostało zapisane. Skontaktujemy się z Tobą w najbliższym czasie', null, array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash('Wystąpił problem z wysyłaniem zgłoszenia', null, array('class' => 'alert-error'));
        }

        return $this->redirect('/ngo');

    }

    public function map()
    {

        if (
        isset($this->request->query['area'])
        ) {

            list($tl, $br) = explode(',', $this->request->query['area']);

            $strlen = strlen($tl);

            if( $strlen==10 )
            	$strlen = 9;

            if( $strlen==12 )
            	$strlen = 11;

            if( $strlen==14 )
            	$strlen = 13;

            if( $strlen==16 )
            	$strlen = 15;


            $precision = floor($strlen / 2);

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
                                                    'top_left' => $tl,
                                                    'bottom_right' => $br,
                                                ),
                                            ),
                                        ),
                                    ),
                                    '_cache' => true,
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
                                        'top' => array(
	                                        'top_hits' => array(
		                                        'size' => 1,
		                                        'fielddata_fields' => array('position.lat', 'position.lon'),
		                                        '_source' => false,
		                                        'fields' => array(),
	                                        ),
                                        ),
                                        /*
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
                                                'field' => '_id',
                                                'size' => 1,
                                            ),
                                        ),
                                        */
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

        if ($this->request->params['action'] == 'map') {

            $data = $this->viewVars['dataBrowser']['aggs']['map'];
            foreach ($data['grid']['buckets'] as &$b) {

                if ($b['doc_count'] === 1) {

                    $b['data'] = $b['top']['hits']['hits'][0]['fields']['source'][0]['data'];
					$b['location'] = array(
						'lat' => $b['top']['hits']['hits'][0]['fields']['position.lat'][0],
						'lon' => $b['top']['hits']['hits'][0]['fields']['position.lon'][0],
					);

                    unset($b['top']);

                } else {

                    unset($b['top']);

                }

                $b['inner_key'] = $b['inner_grid']['buckets'][0]['key'];
                unset($b['inner_grid']);

            }

            $this->viewVars['dataBrowser'] = $data;

        }

    }

    public function view()
    {

        $options = array(
            'searchTag' => array(
	            'href' => '/ngo',
	            'label' => 'NGO',
            ),
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
                            'bool' => array(
	                            'must' => array(
		                            array(
			                            'term' => array(
			                                'dataset' => 'dzialania',
			                            ),
		                            ),
		                            array(
			                            'term' => array(
				                            'data.dzialania.status' => '1',
			                            ),
		                            ),
	                            ),
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
                    'aggs' => array(
	                    'forma_prawna' => array(
		                    'terms' => array(
			                    'field' => 'data.krs_podmioty.forma_prawna_id',
			                    'size' => 100,
		                    ),
	                    ),
                    ),
                    /*
                    'visual' => array(
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => array(
                            'krs_podmioty' => 'Organizacje',
                        ),
                    ),
                    */
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
    
    public function zbiorki()
    {
        $this->loadDatasetBrowser('zbiorki_publiczne', array(
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'zbiorki',
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

		$items = array();		

		if(
			isset( $this->request->query['q'] ) &&
			$this->request->query['q']
		) {
			
			$items[] = array(
				'id' => '_results',
				'label' => 'Wyniki wyszukiwania:',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
				'tool' => array(
					'icon' => 'search',
					'href' => '/' . $this->settings['id'],
				),
				'searchTitle' => 'Wyniki wyszukiwania w mediach:',
			);

			if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';

		} else {
			
			$items[] = array(
				'label' => 'Start',
				'href' => '/' . $this->settings['id'],
				'class' => '_label',
			);
			
		}
		
		
		$map = array(
			'dzialania' => array(
				'menu_id' => 'dzialania',
				'label' => 'Działania',
			),
			'pisma' => array(
				'menu_id' => 'pisma',
				'label' => 'Pisma',
			),
			'zbiorki_publiczne' => array(
				'menu_id' => 'zbiorki',
				'label' => 'Zbiórki publiczne',
				'separator' => 'bottom',
			),
			'fundacje' => array(
				'menu_id' => 'fundacje',
				'label' => 'Fundacje',
				'forma_prawna_id' => '1',
			),
			'stowarzyszenia' => array(
				'menu_id' => 'stowarzyszenia',
				'label' => 'Stowarzyszenia',
				'forma_prawna_id' => '15',
			),
			'zwiazki_zawodowe' => array(
				'menu_id' => 'zwiazki_zawodowe',
				'label' => 'Związki zawodowe',
				'forma_prawna_id' => '18',
			),
			'spoldzielnie' => array(
				'menu_id' => 'spoldzielnie',
				'label' => 'Spółdzielnie',
				'forma_prawna_id' => '9',
			),
			'pozostale_ngo' => array(
				'menu_id' => 'pozostale',
				'label' => 'Pozostałe organizacje',
				'forma_prawna_id' => '_other',
			),
		);
		
		
		

		
		$others_count = 0;
		
		foreach( $map as $key => $value ) {
			
			if( !isset($value['menu_id']) )
				$value['menu_id'] = '';
						
			$item = array(
				'id' => $value['menu_id'],
				'label' => $value['label'],
				'href' => '/' . $this->settings['id'] . '/' . $value['menu_id'],
				'icon' => 'icon-datasets-' . $key,

			);

			if( $mode == 'results' ) {

				$datasets = array();
				$item['href'] .= '?q=' . urlencode( $this->request->query['q'] );
				
				if( @$value['forma_prawna_id'] ) {
					foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {
												
						if( $dataset['key']=='krs_podmioty' ) {
														
							foreach( $dataset['forma_prawna']['buckets'] as $forma ) {
								if( $forma['doc_count'] ) {
																		
									if( $value['forma_prawna_id']==$forma['key'] ) {
										
										$item['count'] = $forma['doc_count'];
										$items[] = $item;
											
									} elseif( ($value['forma_prawna_id']=='_other') && !in_array($forma['key'], array('1', '15', '18', '9')) ) {
										
										$others_count += $forma['doc_count'];
										
									}
																		
								}
							}
							
							if( ($value['forma_prawna_id']=='_other') && $others_count ) {
								
								$item['count'] = $others_count;
								$items[] = $item;
								
							}
							
						}
					}
				}

			} else {

				$items[] = $item;

			}

		}
		
        foreach($items as $i => $item) {

            if(isset($item['submenu'])) {
                $items[$i]['submenu']['selected'] = $this->chapter_submenu_selected;
            }

        }

		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}
	
	/*
    public function getChapters()
    {

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
            'selected' => ($this->chapter_selected == 'view') ? false : $this->chapter_selected,
        );

        return $output;

    }
    */
    
    public function page()
    {
	    
	    $options = array(
            'searchTag' => array(
	            'href' => '/ngo',
	            'label' => 'NGO',
            ),
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
                    'element' => 'page',
                ),
                'aggs' => array(
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

}
