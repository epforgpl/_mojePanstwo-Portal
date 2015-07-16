<?php

App::uses('DataobjectsController', 'Dane.Controller');

class InstytucjeController extends DataobjectsController
{
    public $dataFeedFilters = array(
        array('title' => 'Wszystko', 'icon' => 'all', 'link' => ''),
        array('title' => 'Odpowiedzi na interpelacje', 'icon' => 'interpelacje_odpowiedzi', 'link' => '#'),
        array('title' => 'Otrzymane interpelacje', 'icon' => 'interpelacje_otrzymane', 'link' => '#'),
        array('title' => 'Zamówienia publiczne', 'icon' => 'zamowienia_otrzymane', 'link' => '#'),
        array('title' => 'Zamówienia publiczne', 'icon' => 'zamowienia_otrzymane', 'link' => '#'),
        array('title' => 'Opublikowany tweet', 'icon' => 'twitter_opublikowane', 'link' => '#'),
    );

    public $observeOptions = true;
    
    public $loadChannels = true;
    public $initLayers = array();
    public $components = array('RequestHandler');
	
	public function load() {
		
		if( $this->request->params['action'] != 'view' ) {
			
			$aggs = array(
				'prawo' => array(
	                'filter' => array(
	                    'bool' => array(
	                        'must' => array(
	                            array(
	                                'term' => array(
	                                    'dataset' => 'prawo',
	                                ),
	                            ),
	                            array(
	                                'nested' => array(
	                                    'path' => 'feeds_channels',
	                                    'filter' => array(
	                                        'bool' => array(
	                                            'must' => array(
	                                                array(
	                                                    'term' => array(
	                                                        'feeds_channels.dataset' => 'instytucje',
	                                                    ),
	                                                ),
	                                                array(
	                                                    'term' => array(
	                                                        'feeds_channels.object_id' => $this->request->params['id'],
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
	            ),
	            'prawo_urzedowe' => array(
	                'filter' => array(
	                    'bool' => array(
	                        'must' => array(
	                            array(
	                                'term' => array(
	                                    'dataset' => 'prawo_urzedowe',
	                                ),
	                            ),
	                            array(
	                                'term' => array(
	                                    'data.prawo_urzedowe.instytucja_id' => $this->request->params['id'],
	                                ),
	                            ),
	                        ),
	                    ),
	                ),
	            ),
	            'zamowienia' => array(
	                'filter' => array(
	                    'bool' => array(
	                        'must' => array(
	                            array(
	                                'term' => array(
	                                    'dataset' => 'zamowienia_publiczne',
	                                ),
	                            ),
	                            array(
	                                'nested' => array(
	                                    'path' => 'feeds_channels',
	                                    'filter' => array(
	                                        'bool' => array(
	                                            'must' => array(
	                                                array(
	                                                    'term' => array(
	                                                        'feeds_channels.dataset' => 'instytucje',
	                                                    ),
	                                                ),
	                                                array(
	                                                    'term' => array(
	                                                        'feeds_channels.object_id' => $this->request->params['id'],
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
	            ),
	            'urzednicy' => array(
	                'filter' => array(
	                    'bool' => array(
	                        'must' => array(
	                            array(
	                                'term' => array(
	                                    'dataset' => 'urzednicy',
	                                ),
	                            ),
	                            array(
	                                'term' => array(
	                                    'data.urzednicy.instytucja_id' => $this->request->params['id'],
	                                ),
	                            ),
	                        ),
	                    ),
	                ),
	            ),
			);
			
			if( $this->request->params['id']=='3214' ) { // SEJM
				$aggs['sejm_posiedzenia'] = array(
	                'filter' => array(
	                    'bool' => array(
	                        'must' => array(
	                            array(
	                                'term' => array(
	                                    'dataset' => 'sejm_posiedzenia',
	                                ),
	                            ),
	                        ),
	                    ),
	                ),
	            );
			}
			
			$this->addInitAggs(array(
	            'all' => array(
	                'global' => '_empty',
	                'aggs' => $aggs,
	            ),
	        ));
			
		}
		
		parent::load();
		
	}
	
    public function view()
    {

        $this->load();

        $global_aggs = array(
            'prawo' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'prawo',
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'feeds_channels',
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => 'instytucje',
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $this->request->params['id'],
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
            'prawo_urzedowe' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'prawo_urzedowe',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.prawo_urzedowe.instytucja_id' => $this->request->params['id'],
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
            'urzednicy' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'urzednicy',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.urzednicy.instytucja_id' => $this->request->params['id'],
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
            'zamowienia' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne',
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'feeds_channels',
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => 'instytucje',
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $this->request->params['id'],
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
            ),
            'zamowienia_publiczne_dokumenty' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne_dokumenty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.typ_id' => '3',
                                ),
                            ),
                            array(
                                'range' => array(
                                    'date' => array(
                                        'gt' => 'now-1y'
                                    ),
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'feeds_channels',
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => 'instytucje',
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $this->request->params['id'],
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
                'aggs' => array(
                    'dni' => array(
						'date_histogram' => array(
							'field' => 'date',
							'interval' => 'day',
						),
						'aggs' => array(
							'wykonawcy' => array(
								'nested' => array(
									'path' => 'zamowienia_publiczne-wykonawcy',
								),
								'aggs' => array(
									'waluty' => array(
										'terms' => array(
											'field' => 'zamowienia_publiczne-wykonawcy.waluta',
										),
										'aggs' => array(
											'suma' => array(
												'sum' => array(
													'field' => 'zamowienia_publiczne-wykonawcy.cena',
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
        );
        
        if( $this->object->getId()=='3214' ) { // SEJM
	        
	        $global_aggs['sejm_posiedzenia'] = array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'sejm_posiedzenia',
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'size' => 1,
                            'fielddata_fields' => array('dataset', 'id'),
                            'sort' => array(
                                'date' => array(
                                    'order' => 'desc',
                                ),
                            ),
                        ),
                    ),
                ),
            );
            
            $cover = 'cover-sejm';
	        
        } elseif( $this->object->getId()=='3217' ) { // NIK
	        
	        $global_aggs['nik_raporty'] = array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'nik_raporty',
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'size' => 4,
                            'fielddata_fields' => array('dataset', 'id'),
                            'sort' => array(
                                'date' => array(
                                    'order' => 'desc',
                                ),
                            ),
                        ),
                    ),
                ),
            );
            
            $cover = 'cover-nik';
	                
        } else {
	        
	        $cover = 'cover';
	        
        }


        $options = array(
            'searchTitle' => 'Szukaj w ' . $this->object->getTitle() . '...',
            'conditions' => array(
                '_object' => 'gminy.' . $this->object->getId(),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'instytucje/' . $cover,
                ),
                'aggs' => array(
                    'all' => array(
                        'global' => '_empty',
                        'aggs' => $global_aggs,
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
                            'prawo_wojewodztwa' => array('prawo', 'Prawo lokalne'),
                            'zamowienia_publiczne' => array('zamowienia_publiczne', 'Zamówienia publiczne'),
                        ),
                    ),
                ),
            ),
        );

        $this->Components->load('Dane.DataBrowser', $options);

    }

    public function getMenu()
    {

        if( !$this->object )
        	return false;
			
		$aggs = array();
		if( isset($this->viewVars['dataBrowser']['aggs']['all']) )
			$aggs = $this->viewVars['dataBrowser']['aggs']['all'];
			
		if( isset($this->object_aggs['all']) )
			$aggs = $this->object_aggs['all'];
					
        $menu = array(
            'items' => array(),
            'base' => $this->object->getUrl(),
        );

        $menu['items'][] = array(
            'label' => 'Dane',
            'icon' => array(
	            'src' => 'glyphicon',
	            'id' => 'home',
            ),
        );
        
        if( $this->object->getId()=='3217' ) { // NIK
	        $menu['items'][] = array(
	            'label' => 'Raporty',
	            'id' => 'raporty',
	        );	        
        }
		
		if( isset($aggs['sejm_posiedzenia']) && $aggs['sejm_posiedzenia']['doc_count'] ) {
	        if( $this->object->getId()=='3214' ) { // Sejm
		        $menu['items'][] = array(
		            'label' => 'Posiedzenia',
		            'id' => 'posiedzenia',
		            'count' => $aggs['sejm_posiedzenia']['doc_count'],
		        );	        
	        }     
        }   
		
		if( isset($aggs['prawo']) && $aggs['prawo']['doc_count'] ) {
	        $menu['items'][] = array(
	            'label' => 'Akty prawne',
	            'id' => 'prawo',
	            'count' => $aggs['prawo']['doc_count'],
	        );
        }
		
		if( isset($aggs['prawo_urzedowe']) && $aggs['prawo_urzedowe']['doc_count'] ) {
	        $menu['items'][] = array(
	            'label' => 'Dziennik urzędowy',
	            'id' => 'dziennik',
	            'count' => $aggs['prawo_urzedowe']['doc_count'],
	        );
        }

		if( isset($aggs['zamowienia']) && $aggs['zamowienia']['doc_count'] ) {
	        $menu['items'][] = array(
	            'label' => 'Zamówienia publiczne',
	            'id' => 'zamowienia',
	            'count' => $aggs['zamowienia']['doc_count'],
	        );
        }

		if( isset($aggs['urzednicy']) && $aggs['urzednicy']['doc_count'] ) {
	        $menu['items'][] = array(
	            'label' => 'Urzędnicy',
	            'id' => 'urzednicy',
	        );
        }

        return $menu;

    }

    public function instytucje()
    {

        $this->load();
        $this->request->params['action'] = 'instytucje';

    }

    public function prawo()
    {

        $this->load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo',
                '_feed' => array(
                    'dataset' => 'instytucje',
                    'object_id' => $this->object->getId(),
                ),
            ),
        ));

        $this->set('title_for_layout', "Akty prawne wydane przez " . $this->object->getTitle());

    }

    public function dziennik()
    {

        $this->load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_urzedowe',
                'prawo_urzedowe.instytucja_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', "Dziennik urzędowy " . $this->object->getTitle());

    }

    public function tweety()
    {
        $this->load();
        $this->dataobjectsBrowserView(array(
            'source' => 'instytucje.twitter:' . $this->object->getId(),
            'dataset' => 'twitter',
            'noResultsTitle' => 'Brak tweetów',
            'title' => 'Tweety',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
            'excludeFilters' => array(
                'twitter_accounts.id', 'twitter_accounts.typ_id'
            ),
        ));

        $this->set('title_for_layout', "Tweety napisane przez " . $this->object->getTitle());

    }
    
    public function raporty()
    {
		
        $this->load();
        
        if( $this->object->getId()=='3217' ) { // NIK
	        
	        
	        
	        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
	        	
	        	$raport = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'nik_raporty',
	                    'id' => $this->request->params['subid'],
	                ),
	            ));
	
	            $this->set('raport', $raport);
	            $this->set('title_for_layout', $raport->getTitle());
	            $this->_layout['body']['theme'] = 'doc';
	            $this->render('nik_raport');
	            
	        
	        } else {
		        
		        $this->Components->load('Dane.DataBrowser', array(
		            'conditions' => array(
		                'dataset' => 'nik_raporty',
		            ),
		        ));
		        $this->set('title_for_layout', "Raporty Najwyższej Izby Kontroli");
	        
	        }
	        
	        
	        
        }
    }
    
    public function posiedzenia()
    {
		
        $this->load();
        
        if( $this->object->getId()=='3214' ) { // Sejm
	        	        
	        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
	        	
	        	$posiedzenie = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'sejm_posiedzenia',
	                    'id' => $this->request->params['subid'],
	                ),
	            ));
								
				$submenu = array(
	                'items' => array(),
	            );
				
				$submenu['items'][] = array(
					'label' => 'Prace',
				);
				
				/*
				$submenu['items'][] = array(
					'id' => 'przebieg',
					'label' => 'Przebieg posiedzenia',
				);
				*/
				
				$submenu['items'][] = array(
					'id' => 'wystapienia',
					'label' => 'Wystąpienia',
				);
				
				$submenu['items'][] = array(
					'id' => 'glosowania',
					'label' => 'Głosowania',
				);
				
				
				
				$submenu['base'] = '/dane/instytucje/3214/posiedzenia/' . $posiedzenie->getId();

				switch( @$this->request->params['subaction'] ) {
					
					case 'projekty': {
						
						$submenu['selected'] = 'projekty';
						break;
						
					}
					
					case 'punkty': {
						
						$submenu['selected'] = 'punkty';
						break;
						
					}
					
					case 'przebieg': {
						
						$submenu['selected'] = 'przebieg';
						break;
						
					}
					
					default: {
						
						$global_aggs = array(
	                        'punkty' => array(
	                            'filter' => array(
	                                'bool' => array(
	                                    'must' => array(
	                                        array(
	                                            'term' => array(
	                                                'dataset' => 'sejm_posiedzenia_punkty',
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_posiedzenia_punkty.posiedzenie_id' => $posiedzenie->getId(),
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        'fielddata_fields' => array('dataset', 'id'),
	                                        'sort' => array(
	                                            'data.sejm_posiedzenia_punkty.numer' => array(
	                                                'order' => 'asc',
	                                            ),
	                                        ),
	                                    ),
	                                ),
                                ),
	                        ),
	                        'projekty' => array(
		                        'filter' => array(
	                                'bool' => array(
	                                    'must' => array(
	                                        array(
	                                            'term' => array(
	                                                'dataset' => 'prawo_projekty',
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.prawo_projekty.posiedzenie_id' => $posiedzenie->getId(),
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        'fielddata_fields' => array('dataset', 'id'),
	                                    ),
	                                ),
	                            ),
	                        ),
	                        'glosowania' => array(
		                        'filter' => array(
	                                'bool' => array(
	                                    'must' => array(
	                                        array(
	                                            'term' => array(
	                                                'dataset' => 'sejm_glosowania',
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_glosowania.posiedzenie_id' => $posiedzenie->getId(),
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_glosowania_typy.istotne' => '1',
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        'fielddata_fields' => array('dataset', 'id'),
	                                    ),
	                                ),
	                            ),
	                        ),
	                    );
	
	                    $options = array(
	                        'searchTitle' => 'Szukaj w posiedzeniu...',
	                        'conditions' => array(
	                            '_object' => 'radni_gmin.' . $posiedzenie->getId(),
	                        ),
	                        'cover' => array(
	                            'view' => array(
	                                'plugin' => 'Dane',
	                                'element' => 'sejm_posiedzenia/cover',
	                            ),
	                            'aggs' => array(
	                                'all' => array(
	                                    'global' => '_empty',
	                                    'aggs' => $global_aggs,
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
	                                        'prawo_wojewodztwa' => array('prawo', 'Prawo lokalne'),
	                                        'zamowienia_publiczne' => array('zamowienia_publiczne', 'Zamówienia publiczne'),
	                                    ),
	                                ),
	                            ),
	                        ),
	                    );
	
	                    $this->Components->load('Dane.DataBrowser', $options);	
						$submenu['selected'] = 'view';
						
					}
					
				}



				

				$this->set('_submenu', $submenu);
	            $this->set('posiedzenie', $posiedzenie);
	            $this->set('title_for_layout', $posiedzenie->getTitle());
	            $this->render('sejm_posiedzenie');
	            
	        
	        } else {
		        
		        $this->Components->load('Dane.DataBrowser', array(
		            'conditions' => array(
		                'dataset' => 'sejm_posiedzenia',
		            ),
		        ));
		        $this->set('title_for_layout', "Posiedzenia Sejmu RP");
	        
	        }
	        
	        
	        
        }
    }
    
    public function punkty()
    {
		
		$this->request->params['action'] = 'posiedzenia';
        $this->load();
        
        if( $this->object->getId()=='3214' ) { // Sejm
	        	        
	        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
	        	
	        	$punkt = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'sejm_posiedzenia_punkty',
	                    'id' => $this->request->params['subid'],
	                ),
	            ));
								
				$submenu = array(
	                'items' => array(),
	            );
				
				$submenu['items'][] = array(
					'label' => 'Prace',
				);
				
				/*
				$submenu['items'][] = array(
					'id' => 'przebieg',
					'label' => 'Przebieg posiedzenia',
				);
				*/
				
				$submenu['items'][] = array(
					'id' => 'wystapienia',
					'label' => 'Wystąpienia',
				);
				
				$submenu['items'][] = array(
					'id' => 'glosowania',
					'label' => 'Głosowania',
				);
				
				
				
				$submenu['base'] = '/dane/instytucje/3214/punkty/' . $punkt->getId();

				switch( @$this->request->params['subaction'] ) {
					
					case 'projekty': {
						
						$submenu['selected'] = 'projekty';
						break;
						
					}
					
					case 'punkty': {
						
						$submenu['selected'] = 'punkty';
						break;
						
					}
					
					case 'przebieg': {
						
						$submenu['selected'] = 'przebieg';
						break;
						
					}
					
					default: {
						
						$global_aggs = array(
	                        'projekty' => array(
		                        'filter' => array(
	                                'bool' => array(
	                                    'must' => array(
	                                        array(
	                                            'term' => array(
	                                                'dataset' => 'prawo_projekty',
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.prawo_projekty.punkt_id' => $punkt->getId(),
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        'fielddata_fields' => array('dataset', 'id'),
	                                    ),
	                                ),
	                            ),
	                        ),
	                        'glosowania' => array(
		                        'filter' => array(
	                                'bool' => array(
	                                    'must' => array(
	                                        array(
	                                            'term' => array(
	                                                'dataset' => 'sejm_glosowania',
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_glosowania.punkt_id' => $punkt->getId(),
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_glosowania_typy.istotne' => '1',
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        'fielddata_fields' => array('dataset', 'id'),
	                                    ),
	                                ),
	                            ),
	                        ),
	                        'debaty' => array(
		                        'filter' => array(
	                                'bool' => array(
	                                    'must' => array(
	                                        array(
	                                            'term' => array(
	                                                'dataset' => 'sejm_debaty',
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_debaty.punkt_id' => $punkt->getId(),
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        'fielddata_fields' => array('dataset', 'id'),
	                                        'sort' => array(
		                                        'date' => array(
			                                        'order' => 'asc',
		                                        ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                        ),
	                    );
	
	                    $options = array(
	                        'searchTitle' => 'Szukaj w punkcie porządku dziennego...',
	                        'conditions' => array(
	                            '_object' => 'radni_gmin.' . $punkt->getId(),
	                        ),
	                        'cover' => array(
	                            'view' => array(
	                                'plugin' => 'Dane',
	                                'element' => 'sejm_posiedzenia_punkty/cover',
	                            ),
	                            'aggs' => array(
	                                'all' => array(
	                                    'global' => '_empty',
	                                    'aggs' => $global_aggs,
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
	                                        'prawo_wojewodztwa' => array('prawo', 'Prawo lokalne'),
	                                        'zamowienia_publiczne' => array('zamowienia_publiczne', 'Zamówienia publiczne'),
	                                    ),
	                                ),
	                            ),
	                        ),
	                    );
	
	                    $this->Components->load('Dane.DataBrowser', $options);	
						$submenu['selected'] = 'view';
						
					}
					
				}



				

				$this->set('_submenu', $submenu);
	            $this->set('punkt', $punkt);
	            $this->set('title_for_layout', $punkt->getTitle());
	            $this->render('sejm_posiedzenie_punkt');
	            
	        
	        } else {
		        
		        $this->Components->load('Dane.DataBrowser', array(
		            'conditions' => array(
		                'dataset' => 'sejm_posiedzenia_punkty',
		            ),
		        ));
		        $this->set('title_for_layout', "Punkty porządkowe na posiedzeniach Sejmu RP");
	        
	        }
	        
	        
	        
        }
    }
    
    public function debaty()
    {
		
		$this->request->params['action'] = 'posiedzenia';
        $this->load();
        
        if( $this->object->getId()=='3214' ) { // Sejm
	        	        
	        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
	        	
	        	$debata = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'sejm_debaty',
	                    'id' => $this->request->params['subid'],
	                ),
	            ));				
				
				$global_aggs = array(
                    'wystapienia' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'dataset' => 'sejm_wystapienia',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.sejm_wystapienia.debata_id' => $debata->getId(),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 1000,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
	                                    'data.sejm_wystapienia._ord' => array(
		                                    'order' => 'asc',
	                                    ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'glosowania' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'dataset' => 'sejm_glosowania',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.sejm_glosowania.debata_id' => $debata->getId(),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 1000,
                                    'fielddata_fields' => array('dataset', 'id'),
                                ),
                            ),
                        ),
                    ),
                    'punkty' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'dataset' => 'sejm_posiedzenia_punkty',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.sejm_posiedzenia_punkty.subpunkt_id' => $debata->getId(),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 1000,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
	                                        'order' => 'asc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                );
                
                $options = array(
                    'searchTitle' => 'Szukaj w debacie...',
                    'conditions' => array(
                        '_object' => 'radni_gmin.' . $debata->getId(),
                    ),
                    'cover' => array(
                        'view' => array(
                            'plugin' => 'Dane',
                            'element' => 'sejm_debaty/cover',
                        ),
                        'aggs' => array(
                            'all' => array(
                                'global' => '_empty',
                                'aggs' => $global_aggs,
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
                                    'prawo_wojewodztwa' => array('prawo', 'Prawo lokalne'),
                                    'zamowienia_publiczne' => array('zamowienia_publiczne', 'Zamówienia publiczne'),
                                ),
                            ),
                        ),
                    ),
                );

                $this->Components->load('Dane.DataBrowser', $options);	
				
				
				if( 
					( @$this->request->params['subaction']=='wystapienia' ) && 
					( is_numeric( $this->request->params['subsubid'] ) )
				) {
					
					$wystapienie = $this->Dataobject->find('first', array(
		                'conditions' => array(
		                    'dataset' => 'sejm_wystapienia',
		                    'id' => $this->request->params['subsubid'],
		                ),
		                'layers' => array(
			                'html',
		                ),
		            ));	
		            
		            $this->set('wystapienie', $wystapienie);
					
				}
				

	            $this->set('debata', $debata);
	            $this->set('title_for_layout', $debata->getTitle());
	            $this->render('sejm_debata');
	            
	        
	        } else {
		        
		        $this->Components->load('Dane.DataBrowser', array(
		            'conditions' => array(
		                'dataset' => 'sejm_posiedzenia_punkty',
		            ),
		        ));
		        $this->set('title_for_layout', "Punkty porządkowe na posiedzeniach Sejmu RP");
	        
	        }
	        
	        
	        
        }
    }
    
    public function glosowania()
    {
		
		$this->request->params['action'] = 'posiedzenia';
        $this->load();
        
        if( $this->object->getId()=='3214' ) { // Sejm
	        	        
	        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
	        	
	        	$glosowanie = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'sejm_glosowania',
	                    'id' => $this->request->params['subid'],
	                ),
	            ));				
				
				
                $options = array(
                    'searchTitle' => 'Szukaj posła...',
                    'conditions' => array(
                        'dataset' => 'poslowie_glosy',
                        'poslowie_glosy.glosowanie_id' => $glosowanie->getId(),
                    ),
                );

                $this->Components->load('Dane.DataBrowser', $options);									

	            $this->set('glosowanie', $glosowanie);
	            $this->set('title_for_layout', $glosowanie->getTitle());
	            $this->render('sejm_glosowanie');
	            
	        
	        } else {
		        
		        $this->Components->load('Dane.DataBrowser', array(
		            'conditions' => array(
		                'dataset' => 'sejm_glosowania_glosy',
		            ),
		        ));
		        $this->set('title_for_layout', "Wyniki głosowań posłów na Sejm RP");
	        
	        }
	        
	        
	        
        }
    }

    public function zamowienia()
    {

        $this->load();
        
        $global_aggs = array(
            'zamowienia_publiczne_dokumenty' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne_dokumenty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.typ_id' => '3',
                                ),
                            ),
                            array(
                                'range' => array(
                                    'date' => array(
                                        'gt' => 'now-3y'
                                    ),
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'feeds_channels',
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => 'instytucje',
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $this->request->params['id'],
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
                'aggs' => array(
                    'dni' => array(
						'date_histogram' => array(
							'field' => 'date',
							'interval' => 'day',
						),
						'aggs' => array(
							'wykonawcy' => array(
								'nested' => array(
									'path' => 'zamowienia_publiczne-wykonawcy',
								),
								'aggs' => array(
									'waluty' => array(
										'terms' => array(
											'field' => 'zamowienia_publiczne-wykonawcy.waluta',
										),
										'aggs' => array(
											'suma' => array(
												'sum' => array(
													'field' => 'zamowienia_publiczne-wykonawcy.cena',
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
        );


        $options = array(
            'searchTitle' => 'Szukaj w zamówieniach publicznych...',
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne',
                '_feed' => array(
                    'dataset' => 'instytucje',
                    'object_id' => $this->object->getId(),
                ),
            ),
            'aggsPreset' => 'zamowienia_publiczne',
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'instytucje/zamowienia-cover',
                ),
                'aggs' => array(
                    'all' => array(
                        'global' => '_empty',
                        'aggs' => $global_aggs,
                    ),
                ),
            ),
        );

        $this->Components->load('Dane.DataBrowser', $options);

        $this->set('title_for_layout', "Zamówienia publiczne udzielone przez " . $this->object->getTitle());
    }

    public function zamowienia_rozstrzygniete()
    {

        $this->load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne_dokumenty',
                'zamowienia_publiczne_dokumenty.typ_id' => '3',
                '_feed' => array(
	                'dataset' => 'instytucje',
	                'object_id' => $this->object->getId(),
                ),
            ),
            'renderFile' => 'zamowienia_publiczne_dokumenty',
            'aggsPreset' => 'zamowienia_publiczne_dokumenty',
        ));
		
		$this->menu_selected = 'zamowienia';
		$this->set('DataBrowserTitle', 'Rozstrzygnięcia zamówień publicznych');
        $this->set('title_for_layout', "Rozstrzygnięte zamówienia publiczne dla " . $this->object->getTitle());
        
        $this->menu['selected'] = 'zamowienia';
    }
    
    public function urzednicy()
    {

        $this->load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'urzednicy',
                'urzednicy.instytucja_id' => $this->object->getId(),
            ),
        ));
		
        $this->set('title_for_layout', "Urzędnicy pracujący dla " . $this->object->getTitle());
    }

    public function budzet()
    {

        $this->addInitLayers(array('budzet'));

        $this->load();
        $this->set('title_for_layout', "Budżet " . $this->object->getTitle());

        $this->render('budzet');
    }

    public function beforeRender()
    {
		
		if( $this->object ) {
			
	        if ($this->object->getId() == 3214) {
	            $this->headerObject = array('url' => '/dane/img/headers/sejmometr.jpg', 'height' => '250px');
	        } else {
	            $this->headerObject = array('url' => '/dane/img/headers/instytucje.jpg', 'height' => '250px');
	        }
        
        }

        parent::beforeRender();
        
    }
    
    public function mp_zamowienia() {
	    
	    $this->loadModel('ZamowieniaPubliczne.ZamowieniaPubliczne');
	    $aggs = $this->ZamowieniaPubliczne->getAggs(array(
		    'instytucja_id' => $this->request->params['id'],
	    ));
	    
	    $this->set('aggs', $aggs);
	    $this->set('_serialize', 'aggs');
	    
    }

} 