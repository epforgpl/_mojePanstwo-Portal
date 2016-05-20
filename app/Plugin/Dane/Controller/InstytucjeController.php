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
    public $components = array('RequestHandler', 'S3');
	
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
	                'scope' => 'global',
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
	                'scope' => 'global',
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
	                'scope' => 'global',
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
	                'scope' => 'global',
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
	                'scope' => 'global',
	            );
			}
			
			$this->addInitAggs($aggs);
			
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
                'scope' => 'global',
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
                            '_source' => array('data'),
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
                'scope' => 'global',
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
                            '_source' => array('data'),
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
                'scope' => 'global',
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
                            '_source' => array('data'),
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
                'scope' => 'global',
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
                'scope' => 'global',
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
                'scope' => 'global',
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
                            '_source' => array('data.*'),
                        ),
                    ),
                ),
            );
            
            $global_aggs['prawo_projekty'] = array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'prawo_projekty',
                                ),
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
                'aggs' => array(
                    'typy' => array(
	                    'terms' => array(
		                    'field' => 'data.prawo_projekty.typ_id',
		                    'include' => array('1', '2', '11'),
	                    ),
	                    'aggs' => array(
		                    'top' => array(
		                        'top_hits' => array(
		                            'size' => 3,
		                            'fields' => array('dataset', 'id'),
		                            '_source' => array('data'),
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
            );

            $this->loadModel('Sejmometr.Sejmometr');
            $this->set('okregi', $this->Sejmometr->okregi_sejm());
            $this->set('prawo_projekty_slownik', array(
	            '1' => array(
		            'tytul' => 'Najnowsze projekty ustaw:',
	            ),
	            '2' => array(
		            'tytul' => 'Najnowsze projekty uchwał:',
	            ),
	            '5' => array(
		            'tytul' => 'Powołania i odwołania na stanowiska państwowe:',
	            ),
	            '6' => array(
		            'tytul' => 'Najnowsze umowy międzynarodowe:',
	            ),
	            '11' => array(
		            'tytul' => 'Sprawozdania kontrolne:',
	            ),
	            '100' => array(
		            'tytul' => 'Zmiany w składach komisji:',
	            ),
	            '103' => array(
		            'tytul' => 'Wnioski o referenda:',
	            ),
            ));
            
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
                'scope' => 'global',
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
                'cache' => true,
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'instytucje/' . $cover,
                ),
                'aggs' => $global_aggs,
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
		if( isset($this->viewVars['dataBrowser']['aggs']) )
			$aggs = $this->viewVars['dataBrowser']['aggs'];
		
		
		if( isset($this->object_aggs) )
			$aggs = array_merge($aggs, $this->object_aggs);

					
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
		        );	        
	        }     
        }   
		
		if( $this->object->getId()=='3214' ) { // Sejm
	        $menu['items'][] = array(
	            'label' => 'Posłowie',
	            'id' => 'poslowie',
	        );	        
        } 
        
        if( $this->object->getId()=='3214' ) { // Sejm
	        $menu['items'][] = array(
	            'label' => 'Projekty',
	            'id' => 'prawo_projekty',
	        );	        
        } 
		
		if( $this->object->getId()!='3214' ) { // Sejm
			if( isset($aggs['prawo']) && $aggs['prawo']['doc_count'] ) {
		        $menu['items'][] = array(
		            'label' => 'Akty prawne',
		            'id' => 'prawo',
		            'count' => $aggs['prawo']['doc_count'],
		        );
	        }
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
    
    public function prawo_projekty()
    {

        $this->load();
        
        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
			
			$projekt = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'prawo_projekty',
                    'id' => $this->request->params['subid'],
                ),
                'aggs' => array(
	                'poslowie' => array(
		                'scope' => 'global',
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'term' => array(
							                'dataset' => 'poslowie',
						                ),
					                ),
					                array(
						                'term' => array(
							                'poslowie-projekty_id' => $this->request->params['subid'],
						                ),
					                ),
				                ),
			                ),
		                ),
		                'aggs' => array(
			                'top' => array(
				                'top_hits' => array(
					                'size' => 1000,
					                '_source' => array('slug', 'data.poslowie.id', 'data.poslowie.nazwa', 'data.ludzie.id'),
					                'sort' => array(
						                'title.raw_pl' => 'asc',
					                ),
				                ),
			                ),
		                ),
	                ),
                ),
            ));
            
            $aggs = $this->Dataobject->getAggs();
            $this->set('projekt_poslowie', $aggs['poslowie']['top']['hits']['hits']);
            			
			/*
			if ($this->object->getData('nadrzedny_projekt_id')) {
	            $this->redirect(array(
	                'plugin' => 'Dane',
	                'controller' => 'prawo_projekty',
	                'action' => '',
	                'id' => $this->object->getData('nadrzedny_projekt_id')
	            ));
	        }
	        */
			
	        $this->feed(array(
		        'feed' => $projekt->getDataset() . '/' . $projekt->getId(),
	            'preset' => $projekt->getDataset(),
	            'searchTitle' => '"' . $projekt->getTitle() . '"',
	            'timeline' => true,
	            'direction' => 'asc',
	            'side' => 'prawo_projekty',
	        ));
	        
			            
            $this->set('projekt', $projekt);
            $this->set('title_for_layout', $projekt->getTitle());
            $this->render('prawo_projekty-view');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
	            'browserTitle' => 'Projekty aktów prawnych:',
	            'conditions' => array(
	                'dataset' => 'prawo_projekty',
	            ),
	            'default_conditions' => array(
		            'prawo_projekty.kadencja' => '8',
	            ),
	            'aggsPreset' => 'prawo_projekty',
	        ));
			
	        $this->set('title_for_layout', "Projekty aktów prawnych");

        }
        
    }

    public function dziennik()
    {

        $this->load();
        
        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $prawo = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'prawo_urzedowe',
                    'id' => $this->request->params['subid'],
                ),
            ));
            
            $this->set('prawo', $prawo);
            $this->set('title_for_layout', $prawo->getTitle());
            $this->render('dziennik-view');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
	                'dataset' => 'prawo_urzedowe',
	                'prawo_urzedowe.instytucja_id' => $this->object->getId(),
	            ),
	        ));
	
	        $this->set('title_for_layout', "Dziennik urzędowy " . $this->object->getTitle());

        }
                       

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
	        	
				
				if( @is_numeric($this->request->params['subsubid']) ) {
					
					$dokument = $this->Dataobject->find('first', array(
		                'conditions' => array(
		                    'dataset' => 'nik_raporty_dokumenty',
		                    'id' => $this->request->params['subsubid'],
		                ),
		            ));
		            
		            $this->set('dokument', $dokument);
		            $this->set('title_for_layout', $dokument->getTitle());
		            $this->_layout['body']['theme'] = 'doc';
					
					$this->render('nik_raport_dokument');
					
				} else {
					
					$raport = $this->Dataobject->find('first', array(
		                'conditions' => array(
		                    'dataset' => 'nik_raporty',
		                    'id' => $this->request->params['subid'],
		                ),
		            ));
		            
		            if( 
		            	( $liczba_dokumentow = (int) $raport->getData('liczba_dokumentow') ) && 
		            	( $liczba_dokumentow===1 )
		            ) {
			            
			            return $this->redirect('/dane/instytucje/3217,najwyzsza-izba-kontroli/raporty/' . $raport->getId() . '/dokumenty/' . $raport->getData('nik_dokument_id'));
			            
		            }
					
					$this->set('raport', $raport);
		            $this->set('title_for_layout', $raport->getTitle());
					
					$aggs = array(
	                    'dokumenty' => array(
	                        'filter' => array(
	                            'bool' => array(
		                            'must' => array(
			                            array(
				                            'term' => array(
					                            'data.nik_raporty_dokumenty.podmiot_id' => '0',
				                            ),
			                            ),
			                            array(
				                            'term' => array(
					                            'data.nik_raporty_dokumenty.jednostka_id' => '0',
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
	                                        'data.nik_raporty_dokumenty.data_publikacji' => array(
	                                            'order' => 'asc',
	                                        ),
	                                        
	                                    ),
	                                ),
	                            ),
	                        ),
	                    ),
	                    'jednostki' => array(
	                        'filter' => array(
	                            'bool' => array(
		                            'must' => array(
			                            array(
				                            'term' => array(
					                            'data.nik_raporty_dokumenty.podmiot_id' => '0',
				                            ),
			                            ),
		                            ),
		                            'must_not' => array(
			                            array(
				                            'term' => array(
					                            'data.nik_raporty_dokumenty.jednostka_id' => '0',
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
	                                        'data.nik_raporty_dokumenty.data_publikacji' => array(
	                                            'order' => 'asc',
	                                        ),
	                                        
	                                    ),
	                                ),
	                            ),
	                        ),
	                    ),
	                    'podmioty' => array(
	                        'filter' => array(
	                            'bool' => array(
		                            'must_not' => array(
			                            array(
				                            'term' => array(
					                            'data.nik_raporty_dokumenty.podmiot_id' => '0',
				                            ),
			                            ),
		                            ),
	                            ),
	                        ),
	                        'aggs' => array(
	                            'podmioty' => array(
		                            'terms' => array(
			                            'field' => 'data.nik_raporty_podmioty.id',
		                            ),
		                            'aggs' => array(
			                            'nazwa' => array(
				                            'terms' => array(
					                            'field' => 'data.nik_raporty_podmioty.nazwa',
				                            ),
			                            ),
			                            'top' => array(
			                                'top_hits' => array(
			                                    'size' => 1000,
			                                    'fielddata_fields' => array('dataset', 'id'),
			                                    'sort' => array(
			                                        'data.nik_raporty_dokumenty.data_publikacji' => array(
			                                            'order' => 'asc',
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
	                    'searchTitle' => 'Szukaj w wynikach kontroli...',
	                    'conditions' => array(
	                        'dataset' => 'nik_raporty_dokumenty',
	                        'nik_raporty_dokumenty.raport_id' => $raport->getId(),
	                    ),
	                    'cover' => array(
	                        'view' => array(
	                            'plugin' => 'Dane',
	                            'element' => 'nik_raporty/cover',
	                        ),
	                        'aggs' => $aggs,
	                    ),
	                );
	
	                $this->Components->load('Dane.DataBrowser', $options);	
	                $this->render('nik_raport');
					
				}
						            
	            
	            
	        
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
								
	        	$render_file = 'sejm_posiedzenie';
	        	$title = $posiedzenie->getTitle();

				$submenu = array(
	                'items' => array(),
	            );
				
				$submenu['items'][] = array(
					'id' => '',
					'label' => 'Podsumowanie',
				);
				
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
					
					case 'wystapienia': {
						
						$this->Components->load('Dane.DataBrowser', array(
							'browserTitle' => 'Wystąpienia:',
							'searchTitle' => 'Szukaj w wystąpieniach...',
	                        'conditions' => array(
	                            'dataset' => 'sejm_wystapienia',
	                            'sejm_wystapienia.posiedzenie_id' => $posiedzenie->getId(),
	                        ),
	                        'order' => 'sejm_wystapienia._ord asc',
						));
						$submenu['selected'] = 'wystapienia';
						break;
						
					}
					
					case 'glosowania': {
						
						$this->Components->load('Dane.DataBrowser', array(
							'searchTitle' => 'Szukaj w głosowaniach...',
	                        'conditions' => array(
	                            'dataset' => 'sejm_glosowania',
	                            'sejm_glosowania.posiedzenie_id' => $posiedzenie->getId(),
	                        ),
	                        'order' => 'sejm_glosowania.numer asc',
						));
						
						$submenu['selected'] = 'glosowania';
						break;
						
					}
					
					case 'dni': {
						
						$dzien = $this->Dataobject->find('first', array(
			                'conditions' => array(
			                    'dataset' => 'sejm_posiedzenia_dni',
			                    'id' => $this->request->params['subsubid'],
			                ),
			                'aggs' => array(
				                'stenogramy' => array(
			                        'scope' => 'global',
			                        'filter' => array(
				                        'bool' => array(
					                        'must' => array(
						                        array(
							                        'term' => array(
								                        'dataset' => 'sejm_posiedzenia_dni',
							                        ),
						                        ),
						                        array(
							                        'term' => array(
								                        'data.sejm_posiedzenia_dni.posiedzenie_id' => $posiedzenie->getId(),
							                        ),
						                        ),
					                        ),
				                        ),
			                        ),
			                        'aggs' => array(
				                        'top' => array(
					                        'top_hits' => array(
						                        'size' => 100,
						                        'sort' => array(
							                        'date' => 'asc',
						                        ),
						                        '_source' => true,
						                        'fields' => array('dataset', 'id'),
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
										                'data.sejm_debaty.dzien_id' => $this->request->params['subsubid'],
									                ),
								                ),
							                ),
						                ),
					                ),
					                'scope' => 'global',
					                'aggs' => array(
						                'top' => array(
							                'top_hits' => array(
								                'size' => 1000,
								                'sort' => array(
									                'data.sejm_debaty.kolejnosc' => array(
										                'order' => 'asc',
									                ),
								                ),
								                '_source' => array('data', 'static'),
								                'fields' => array('dataset', 'id'),
							                ),
						                ),
					                ),
				                ),
			                ),
			            ));
			            
			            
			            $aggs = $this->Dataobject->getAggs();
			            
			            $this->set('dzien', $dzien);
			            $this->set('debaty', $aggs['debaty']['top']['hits']['hits']);
			            $this->set('stenogramy', $aggs['stenogramy']['top']['hits']['hits']);
						
						$render_file = 'sejm_posiedzenie_dzien';
						$title = $dzien->getData('tytul');
						
						break;
						
					}
										
					default: {
												
						$global_aggs = array(
	                        
	                        'stenogramy' => array(
		                        'scope' => 'global',
		                        'filter' => array(
			                        'bool' => array(
				                        'must' => array(
					                        array(
						                        'term' => array(
							                        'dataset' => 'sejm_posiedzenia_dni',
						                        ),
					                        ),
					                        array(
						                        'term' => array(
							                        'data.sejm_posiedzenia_dni.posiedzenie_id' => $posiedzenie->getId(),
						                        ),
					                        ),
				                        ),
			                        ),
		                        ),
		                        'aggs' => array(
			                        'top' => array(
				                        'top_hits' => array(
					                        'size' => 100,
					                        'sort' => array(
						                        'date' => 'asc',
					                        ),
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
	                                                'data.sejm_posiedzenia_punkty.posiedzenie_id' => $posiedzenie->getId(),
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'scope' => 'global',
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        'fielddata_fields' => array('dataset', 'id'),
	                                        'sort' => array(
	                                            'data.sejm_posiedzenia_punkty.liczba_slow' => array(
	                                                'order' => 'desc',
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
	                            'scope' => 'global',
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        '_source' => array('data'),
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
	                        'searchTitle' => 'Szukaj w posiedzeniu...',
	                        'conditions' => array(
	                            '_object' => 'radni_gmin.' . $posiedzenie->getId(),
	                        ),
	                        'cover' => array(
	                            'view' => array(
	                                'plugin' => 'Dane',
	                                'element' => 'sejm_posiedzenia/cover',
	                            ),
	                            'aggs' => $global_aggs,
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
	                                ),
	                            ),
	                        ),
	                    );
	
	                    $this->Components->load('Dane.DataBrowser', $options);	
						$submenu['selected'] = '';
						
					}
					
					
				}



				

				$this->set('_submenu', $submenu);
	            $this->set('posiedzenie', $posiedzenie);
	            $this->set('title_for_layout', $title);
	            $this->render( $render_file );
	            
	        
	        } else {
		        
		        $this->Components->load('Dane.DataBrowser', array(
		            'browserTitle' => 'Posiedzenia Sejmu:',
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
				
				/*
				$submenu['items'][] = array(
					'id' => 'wystapienia',
					'label' => 'Wystąpienia',
				);
				
				
				$submenu['items'][] = array(
					'id' => 'glosowania',
					'label' => 'Głosowania',
				);
				*/
				
				
				
				$submenu['base'] = '/dane/instytucje/3214/punkty/' . $punkt->getId();

				// debug( $this->request->params ); die();

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
	                                        /*
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_glosowania_typy.istotne' => '1',
	                                            ),
	                                        ),
	                                        */
	                                    ),
	                                ),
	                            ),
	                            'scope' => 'global',
	                            'aggs' => array(
	                                'top' => array(
	                                    'top_hits' => array(
	                                        'size' => 1000,
	                                        '_source' => array('data'),
	                                        'fields' => array('dataset', 'id'),
	                                        'sort' => array(
		                                        'date' => array(
			                                        'order' => 'asc',
		                                        ),
	                                        ),
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
	                            'scope' => 'global',
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
	                        'druki' => array(
		                        'filter' => array(
	                                'bool' => array(
	                                    'must' => array(
	                                        array(
	                                            'term' => array(
	                                                'dataset' => 'sejm_druki',
	                                            ),
	                                        ),
	                                        array(
	                                            'term' => array(
	                                                'data.sejm_druki.punkt_id' => $punkt->getId(),
	                                            ),
	                                        ),
	                                    ),
	                                ),
	                            ),
	                            'scope' => 'global',
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
	                            'aggs' => $global_aggs,
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
	                'layers' => array('neighboors'),
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
                        'scope' => 'global',
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
                        'scope' => 'global',
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
                                    'fields' => array('dataset', 'id'),
                                    '_source' => array('data'),
                                ),
                            ),
                        ),
                    ),
                    'punkty' => array(
                        'scope' => 'global',
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
                                            'data.sejm_posiedzenia_punkty.debata_id' => $debata->getId(),
                                        ),
                                    ),
                                ),
                                'must_not' => array(
	                                array(
		                                'term' => array(
			                                'data.sejm_posiedzenia_punkty.numer' => 0,
		                                ),
	                                ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 1000,
                                    'fields' => array('dataset', 'id'),
                                    '_source' => array('data'),
                                    'sort' => array(
	                                    'data.sejm_posiedzenia_punkty.numer' => array(
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
                        'aggs' => $global_aggs,
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
		
		
        $this->load();
        
        if( $this->object->getId()=='3214' ) { // Sejm
	        	        
	        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
	        	
	        	$this->request->params['action'] = 'posiedzenia';
	        	$glosowanie = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'sejm_glosowania',
	                    'id' => $this->request->params['subid'],
	                ),
	                'aggs' => array(
		                'glosy' => array(
			                'nested' => array(
				                'path' => 'sejm_glosowania-glosy',
			                ),
			                'aggs' => array(
				                'glosy' => array(
					                'top_hits' => array(
						                'size' => 500,
						                'sort' => array(
							                'sejm_glosowania-glosy.posel_nazwisko_imie' => array(
								                'order' => 'asc',
							                ),
						                ),
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
	                                            'data.sejm_posiedzenia_punkty.glosowanie_id' => $this->request->params['subid'],
	                                        ),
	                                    ),
	                                ),
	                            ),
	                        ),
	                        'scope' => 'global',
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
	                ),
	            ));				
				
				$this->set('glosowanie_aggs', $this->Dataobject->getAggs());

	            $this->set('glosowanie', $glosowanie);
	            $this->set('title_for_layout', $glosowanie->getTitle());
	            $this->render('sejm_glosowanie');
	            
	        
	        } else {
		        
		        $this->Components->load('Dane.DataBrowser', array(
		            'conditions' => array(
		                'dataset' => 'sejm_glosowania',
		            ),
		            'aggsPreset' => 'sejm_glosowania',
		        ));
		        $this->set('title_for_layout', "Głosowania w Sejmie RP");
			    $this->set('DataBrowserTitle', 'Głosowania na posiedzeniach Sejmu');
			    $this->render('DataBrowser/browser-from-object');
	        
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
                'scope' => 'global',
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
                'aggs' => $global_aggs,
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
    
    public function poslowie() {
	    $this->load();
	    if( $this->object->getId()=='3214' ) { // Sejm
		    
		    $this->Components->load('Dane.DataBrowser', array(
	            'browserTitle' => 'Posłowie',
	            'conditions' => array(
	                'dataset' => 'poslowie',
	                'poslowie.kadencja' => 8,
	            ),
	            'aggsPreset' => 'poslowie',
	            'order' => '_title asc',
	        ));
	        $this->set('title_for_layout', "Posłowie na Sejm RP");
		    $this->render('DataBrowser/browser-from-object');
		    
	    }
    }
    
    public function wystapienia() {
	    $this->load();
	    if( $this->object->getId()=='3214' ) { // Sejm
		    
		    $this->Components->load('Dane.DataBrowser', array(
	            'browserTitle' => 'Wystąpienia posłów',
	            'conditions' => array(
	                'dataset' => 'sejm_wystapienia',
	            ),
	            'aggsPreset' => 'sejm_wystapienia',
	            'order' => 'sejm_wystapienia._ord asc',
	        ));
	        $this->set('title_for_layout', "Wystąpienia w Sejmie RP");
		    $this->set('DataBrowserTitle', 'Wystąpienia na posiedzeniach Sejmu');
		    $this->render('DataBrowser/browser-from-object');
		    
	    }
    }
    
	public function druki() {
	    $this->load();
	    if( $this->object->getId()=='3214' ) { // Sejm
		    		    
		    if( isset($this->request->params['subid']) ) {
			    
			    $druk = $this->Dataobject->find('first', array(
				    'conditions' => array(
					    'dataset' => 'sejm_druki',
					    'id' => $this->request->params['subid'],
				    ),
				    'aggs' => array(
					    'projekty' => array(
						    'scope' => 'global',
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
											    'data.prawo_projekty.druki_id' => $this->request->params['subid'],
										    ),
									    ),
								    ),
							    ),
						    ),
						    'aggs' => array(
							    'top' => array(
								    'top_hits' => array(
									    'size' => 1000,
									    '_source' => array('dataset', 'slug', 'data.*'),
									    'sort' => array(
										    'date' => 'asc',
									    ),
									    'fields' => array('dataset', 'id'),
								    ),
							    ),
						    ),
					    ),
				    ),
			    ));
			    
			    $aggs = $this->Dataobject->getAggs();
			    
			    $this->set('druk_projekty', $aggs['projekty']['top']['hits']['hits']);
			    $this->set('druk', $druk);
			    $this->set('title_for_layout', $druk->getTitle());
			    $this->render('druk');
			    
			    
		    } else {
		    
			    $this->Components->load('Dane.DataBrowser', array(
		            'browserTitle' => 'Druki sejmowe',
		            'conditions' => array(
		                'dataset' => 'sejm_druki',
		            ),
		            'default_conditions' => array(
			            'sejm_druki.kadencja' => '8',
		            ),
		            'aggsPreset' => 'sejm_druki',
		        ));
		        $this->set('title_for_layout', "Druki sejmowe");
			    $this->set('DataBrowserTitle', 'Druki sejmowe');
			    $this->render('DataBrowser/browser-from-object');
		    
		    }
		    
	    }
    }
    
    public function interpelacje() {
	    $this->load();
	    if( $this->object->getId()=='3214' ) { // Sejm
            if( isset($this->request->params['subid']) ) {

                $interpelacja = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_interpelacje',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('interpelacja', $interpelacja);
                $this->set('title_for_layout', $interpelacja->getTitle());
                $this->render('interpelacja');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Interpelacje',
                    'conditions' => array(
                        'dataset' => 'sejm_interpelacje',
                    ),
                    'aggsPreset' => 'sejm_interpelacje',
                ));
                $this->set('title_for_layout', "Interpelacje w Sejmie RP");
                $this->set('DataBrowserTitle', 'Interpelacje');
                $this->render('DataBrowser/browser-from-object');
            }
	    }
    }
    
    public function kluby() {
	    $this->load();
	    if( $this->object->getId()=='3214' ) { // Sejm

            if( isset($this->request->params['subid']) ) {

                $klub = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_kluby',
                        'id' => $this->request->params['subid'],
                    ),
                ));
                
                $this->set('_submenu', array(
	                'items' => array(
		                array(
			                'id' => '',
			                'label' => 'Posłowie w tym klubie',
		                ),
	                ),
	                'selected' => '',
                ));
                
                $this->Components->load('Dane.DataBrowser', array(
                    'conditions' => array(
                        'dataset' => 'poslowie',
                        'poslowie.klub_id' => $klub->getId(),
                    ),
                    'aggsPreset' => 'poslowie',
                ));

                $this->set('klub', $klub);
                $this->set('title_for_layout', $klub->getTitle());
                $this->render('klub');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Kluby sejmowe',
                    'conditions' => array(
                        'dataset' => 'sejm_kluby',
                    ),
                    'aggsPreset' => 'sejm_kluby',
                ));
                $this->set('title_for_layout', "Kluby i koła poselskie w Sejmie RP");
                $this->set('DataBrowserTitle', 'Kluby i koła poselskie');
                $this->render('DataBrowser/browser-from-object');
            }
	    }
    }
    
    public function komisje() {
	    $this->load();
	    if( $this->object->getId()=='3214' ) { // Sejm

            if( isset($this->request->params['subid']) ) {

                $komisja = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_komisje',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('komisja', $komisja);
                $this->set('title_for_layout', $komisja->getTitle());
                $this->render('komisja');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Komisje sejmowe',
                    'conditions' => array(
                        'dataset' => 'sejm_komisje',
                    ),
                    'aggsPreset' => 'sejm_komisje',
                ));
                $this->set('title_for_layout', "Komisje w Sejmie RP");
                $this->set('DataBrowserTitle', 'Komisje sejmowe');
                $this->render('DataBrowser/browser-from-object');
            }
	    }
    }



    public function poslowie_rejestr_korzysci() {
        $this->load();
        if( $this->object->getId()=='3214' ) { // Sejm

            if (isset($this->request->params['subid'])) {

                $rejestr = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'poslowie_rejestr_korzysci',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('rejestr', $rejestr);
                $this->set('title_for_layout', $rejestr->getTitle());
                $this->render('rejestr');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Rejestr korzyści posłów',
                    'conditions' => array(
                        'dataset' => 'poslowie_rejestr_korzysci',
                    ),
                    'aggsPreset' => 'poslowie_rejestr_korzysci',
                ));
                $this->set('title_for_layout', "Rejestr korzyści posłów na Sejm RP");
                $this->set('DataBrowserTitle', 'Rejestr korzyści posłów');
                $this->render('DataBrowser/browser-from-object');
            }
        }
    }

    public function dezyderaty()
    {
        $this->load();
        if ($this->object->getId() == '3214') { // Sejm

            if (isset($this->request->params['subid'])) {

                $dezyderat = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_dezyderaty',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('dezyderat', $dezyderat);
                $this->set('title_for_layout', $dezyderat->getTitle());
                $this->render('dezyderat');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Dezyderaty komisji sejmowych',
                    'conditions' => array(
                        'dataset' => 'sejm_dezyderaty',
                    ),
                    'aggsPreset' => 'sejm_dezyderaty',
                ));
                $this->set('title_for_layout', "Dezyderaty komisji w Sejmie RP");
                $this->set('DataBrowserTitle', 'Dezyderaty komisji sejmowych');
                $this->render('DataBrowser/browser-from-object');
            }
        }
    }


    public function komisje_opinie()
    {
        $this->load();
        if ($this->object->getId() == '3214') { // Sejm

            if (isset($this->request->params['subid'])) {

                $opinia = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_komisje_opinie',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('opinia', $opinia);
                $this->set('title_for_layout', $opinia->getTitle());
                $this->render('opinia');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Opinie komisji sejmowych',
                    'conditions' => array(
                        'dataset' => 'sejm_komisje_opinie',
                    ),
                    'aggsPreset' => 'sejm_komisje_opinie',
                ));
                $this->set('title_for_layout', "Opinie komisji Sejmu RP");
                $this->set('DataBrowserTitle', 'Opinie komisji sejmowych');
                $this->render('DataBrowser/browser-from-object');
            }
        }
    }

    public function komisje_uchwaly()
    {
        $this->load();
        if ($this->object->getId() == '3214') { // Sejm
            if (isset($this->request->params['subid'])) {

                $uchwala = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_komisje_uchwaly',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('uchwala', $uchwala);
                $this->set('title_for_layout', $uchwala->getTitle());
                $this->render('uchwala');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Uchwały komisji sejmowych',
                    'conditions' => array(
                        'dataset' => 'sejm_komisje_uchwaly',
                    ),
                    'aggsPreset' => 'sejm_komisje_uchwaly',
                ));
                $this->set('title_for_layout', "Uchwały komisji Sejmu RP");
                $this->set('DataBrowserTitle', 'Uchwały komisji sejmowych');
                $this->render('DataBrowser/browser-from-object');
            }
        }
    }

    public function komunikaty()
    {
        $this->load();
        if ($this->object->getId() == '3214') { // Sejm

            if (isset($this->request->params['subid'])) {

                $komunikat = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_komunikaty',
                        'id' => $this->request->params['subid'],
                    ),
                    'layers' => array('html'),
                ));

                $this->set('komunikat', $komunikat);
                $this->set('title_for_layout', $komunikat->getTitle());
                $this->render('komunikat');




            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Komunikaty Kancelarii Sejmu',
                    'conditions' => array(
                        'dataset' => 'sejm_komunikaty',
                    ),
                    'aggsPreset' => 'sejm_komunikaty',
                ));
                $this->set('title_for_layout', "Komunikaty Kancelarii Sejmu RP");
                $this->set('DataBrowserTitle', 'Komunikaty kancelarii Sejmu');
                $this->render('DataBrowser/browser-from-object');
            }
        }
    }

    public function okregi()
    {
        $this->load();
        if ($this->object->getId() == '3214') { // Sejm

            if (isset($this->request->params['subid'])) {

                $okreg = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'sejm_okregi_wyborcze',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('_submenu', array(
                    'items' => array(
                        array(
                            'id' => '',
                            'label' => 'Posłowie z tego okręgu',
                        ),
                    ),
                    'selected' => '',
                ));

                $this->Components->load('Dane.DataBrowser', array(
                    'conditions' => array(
                        'dataset' => 'poslowie',
                        'poslowie.sejm_okreg_id' => $okreg->getId(),
                    ),
                    'aggsPreset' => 'poslowie',
                ));

                $this->set('okreg', $okreg);
                $this->set('title_for_layout', $okreg->getTitle());
                $this->render('okreg');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Okręgi wyborcze',
                    'conditions' => array(
                        'dataset' => 'sejm_okregi_wyborcze',
                    ),
                    'aggsPreset' => 'sejm_okregi_wyborcze',
                ));
                $this->set('title_for_layout', "Okręgi wyborcze do Sejmu RP");
                $this->set('DataBrowserTitle', 'Okręgi wyborcze w wyborach do Sejmu');
                $this->render('DataBrowser/browser-from-object');

            }

        }
    }

    public function poslowie_oswiadczenia_majatkowe()
    {
        $this->load();
        if ($this->object->getId() == '3214') { // Sejm

            if (isset($this->request->params['subid'])) {

                $oswiadczenie = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'poslowie_oswiadczenia_majatkowe',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('oswiadczenie', $oswiadczenie);
                $this->set('title_for_layout', $oswiadczenie->getTitle());
                $this->render('oswiadczenie');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Oświadczenia majątkowe posłów',
                    'conditions' => array(
                        'dataset' => 'poslowie_oswiadczenia_majatkowe',
                    ),
                    'aggsPreset' => 'poslowie_oswiadczenia_majatkowe',
                ));
                $this->set('title_for_layout', "Oświadczenia majątkowe posłów na Sejm RP");
                $this->set('DataBrowserTitle', 'Oświadczenia majątkowe posłów');
                $this->render('DataBrowser/browser-from-object');
            }

        }
    }

    public function poslowie_wspolpracownicy()
    {
        $this->load();
        if ($this->object->getId() == '3214') { // Sejm

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'poslowie_wspolpracownicy',
                ),
                'aggsPreset' => 'poslowie_wspolpracownicy',
            ));
            $this->set('title_for_layout', "Współpracownicy posłów na Sejm RP");
            $this->set('DataBrowserTitle', 'Współpracownicy posłów');
            $this->render('DataBrowser/browser-from-object');

            if (isset($this->request->params['subid'])) {

                $wspolpracownik = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'poslowie_wspolpracownicy',
                        'id' => $this->request->params['subid'],
                    ),
                ));

                $this->set('wspolpracownik', $wspolpracownik);
                $this->set('title_for_layout', $wspolpracownik->getTitle());
                $this->render('wspolpracownik');


            } else {
                $this->Components->load('Dane.DataBrowser', array(
                    'browserTitle' => 'Współpracownicy posłów',
                    'conditions' => array(
                        'dataset' => 'poslowie_wspolpracownicy',
                    ),
                    'aggsPreset' => 'poslowie_wspolpracownicy',
                ));
                $this->set('title_for_layout', "Współpracownicy posłów na Sejm RP");
                $this->set('DataBrowserTitle', 'Współpracownicy posłów');
                $this->render('DataBrowser/browser-from-object');
            }
        }
    }
} 