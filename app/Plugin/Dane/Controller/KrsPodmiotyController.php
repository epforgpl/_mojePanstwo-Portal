<?php

App::uses('DataobjectsController', 'Dane.Controller');

/**
 * @property  RequestHandlerComponent request
 */
class KrsPodmiotyController extends DataobjectsController
{

    public $observeOptions = true;

    public $helpers = array(
        'Time', 'Czas'
    );
    public $components = array('RequestHandler', 'Media.Twitter');
    public $objectOptions = array(
        'hlFields' => array(),
        'bigTitle' => true,
    );

    public $loadChannels = true;
    public $initLayers = array('counters');

    public $microdata = array(
        'itemtype' => 'http://schema.org/Organization',
        'titleprop' => 'name',
    );

    public $objectActivities = true;
    public $objectData = true;
    public $objectCollections = true;
    public $objectLetters = true;

    private $twitterAccountType = '0';
    private $twitterTimerange = '1W';

    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->Auth->deny(array('pobierz_odpis', 'odpis'));
    }


    public function aktualnosci()
    {

        $this->load();

        if (isset($this->request->params['pass'][0])) {

            $zmiana = $this->API->getObject('krs_podmioty_zmiany', $this->request->params['pass'][0], array(
                'layers' => array('details'),
            ));

            $this->request->params['action'] = 'view';

            $this->set('zmiana', $zmiana);
            $this->render('aktualnosc');


        } else {

            $this->feed();

        }

    }

    public function view()
    {
				
        $this->addInitLayers(array(
            'channels',
            'subscription',
            'reprezentacja',
            'wspolnicy',
            'jedynyAkcjonariusz',
            'prokurenci',
            'nadzor',
            'bank_account',
            'komitetZalozycielski',
            'dzialalnosci',
            'udzialy',
            'firmy',
        ));

        if ($this->Session->read('KRS.odpis') == $this->params->id) {
            $this->addInitLayers('odpis');
        }

        $this->_prepareView();

        $desc_parts = array('Informacje gospodarcze o ' . $this->object->getShortTitle());
        $desc_bodies_parts = array();

        if ($this->Session->read('KRS.odpis') == $this->object->getId()) {

            $odpis = $this->object->getLayer('odpis');

            if ($odpis['status']) {
                $this->set('odpis', $odpis['url']);
            }

        }

        $this->Session->delete('KRS.odpis');


        $organy = array();
        $menu = array();

        $reprezentacja = $this->object->getLayer('reprezentacja');
        if (!empty($reprezentacja)) {
            $organy[] = array(
                'title' => $this->object->getData('nazwa_organu_reprezentacji'),
                'label' => 'Organ reprezentacji',
                'idTag' => 'reprezentacja',
                'content' => $reprezentacja,
            );
            $menu[] = array(
                'id' => 'reprezentacja',
                'label' => $this->object->getData('nazwa_organu_reprezentacji'),
            );

            $desc_bodies_parts[] = mb_strtolower($this->object->getData('nazwa_organu_reprezentacji'));
        }

        $wspolnicy = $this->object->getLayer('wspolnicy');
        if ($wspolnicy)
            $desc_bodies_parts[] = 'udziałowcy';


        /*
        if (!empty($wspolnicy)) {
            $organy[] = array(
                'title' => 'Wspólnicy',
                'idTag' => 'wspolnicy',
                'content' => $wspolnicy,
            );
            $menu[] = array(
                'id' => 'wspolnicy',
                'label' => 'Wspólnicy',
            );
        }
        */

        $nadzor = $this->object->getLayer('nadzor');
        if (!empty($nadzor)) {
            $organy[] = array(
                'title' => $this->object->getData('nazwa_organu_nadzoru'),
                'label' => 'Organ nadzoru',
                'idTag' => 'nadzor',
                'content' => $nadzor,
            );
            $menu[] = array(
                'id' => 'nadzor',
                'label' => $this->object->getData('nazwa_organu_nadzoru'),
            );
            $desc_bodies_parts[] = mb_strtolower($this->object->getData('nazwa_organu_nadzoru'));
        }

        $komitetZalozycielski = $this->object->getLayer('komitetZalozycielski');
        if (!empty($komitetZalozycielski)) {
            $organy[] = array(
                'title' => 'Komitet założycielski',
                'idTag' => 'zalozyciele',
                'content' => $komitetZalozycielski,
            );
            $menu[] = array(
                'id' => 'zalozyciele',
                'label' => 'Komitet założycielski',
            );
            $desc_bodies_parts[] = 'komitet założycielski';
        }

        $akcjonariusze = $this->object->getLayer('jedynyAkcjonariusz');
        if (!empty($akcjonariusze)) {
            $organy[] = array(
                'title' => 'Jedyny akcjonariusz',
                'idTag' => 'akcjonariusz',
                'content' => $akcjonariusze,
            );
            $menu[] = array(
                'id' => 'akcjonariusz',
                'label' => 'Jedyny akcjonariusz',
            );

            $desc_bodies_parts[] = 'akcjonariusze';
        }

        $prokurenci = $this->object->getLayer('prokurenci');
        if (!empty($prokurenci)) {
            $organy[] = array(
                'title' => 'Prokurenci',
                'idTag' => 'prokurenci',
                'content' => $prokurenci,
            );
            $menu[] = array(
                'id' => 'prokurenci',
                'label' => 'Prokurenci',
            );
            $desc_bodies_parts[] = 'prokurenci';
        }


        $this->set('organy', $organy);


        /*
        $zamowienia = $this->Dataobject->find('all', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne',
                'krs_podmioty.'
            ),
            'limit' => 9,
        ));

        $zamowienia = $this->API->search(array(
            'limit' => 9,
            'conditions' => array(
                '_source' => 'krs_podmioty.zamowienia:' . $this->object->getId(),
                'dataset' => 'zamowienia_publiczne',
            ),
        ));
        if ($zamowienia)
            $desc_bodies_parts[] = 'realizowane zamówienia publiczne';
        $this->set('zamowienia', $this->API->getObjects());

        $dotacje = $this->API->search(array(
            'limit' => 9,
            'conditions' => array(
                '_source' => 'krs_podmioty.dotacje_ue:' . $this->object->getId(),
                'dataset' => 'dotacje_ue',
            ),
        ));
        if ($dotacje)
            $desc_bodies_parts[] = 'otrzymane dotacje';
        $this->set('dotacje', $this->API->getObjects());
        */

        $desc_bodies_parts[] = 'odpis z KRS';


        /*
        $dzialalnosc = $this->object->getLayer('dzialalnosci');
        if ($dzialalnosc) {
            $dzialalnosci = array(
                'title' => 'Działalność',
                'idTag' => 'dzialalnosc',
                'content' => $dzialalnosc,
            );
            $desc_bodies_parts[] = 'działalność PKD';
        }
        $menu[] = array(
            'id' => 'dzialalnosc',
            'label' => 'Działalność',
        );

        @$this->set('dzialalnosci', $dzialalnosci);


        $this->set('_menu', $menu);
        */

        $desc_parts[] = ucfirst(implode(', ', $desc_bodies_parts));
        $this->setMetaDesc(implode('. ', $desc_parts) . '.');

        // return $this->feed();

    }

    public function _prepareView()
    {

        $this->addInitAggs(array(
            'zamowienia' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne_dokumenty',
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'zamowienia_publiczne-wykonawcy',
                                    'filter' => array(
                                        'term' => array(
                                            'zamowienia_publiczne-wykonawcy.krs_id' => $this->request->params['id'],
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
            ),
            'dzialania' => array(
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
                                    'data.dzialania.dataset' => 'krs_podmioty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.dzialania.object_id' => $this->request->params['id'],
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.dzialania.status' => 1,
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'fielddata_fields' => array('dataset', 'id'),
	                        'size' => 3,
	                        'sort' => array(
		                        'date' => 'desc',
	                        ),
                        ),
                    ),
                ),
                'scope' => 'global',
            ),
            'sprawozdania_opp' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'sprawozdania_opp',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.sprawozdania_opp.krs_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'fielddata_fields' => array('dataset', 'id'),
	                        'size' => 3,
	                        'sort' => array(
		                        'date' => 'desc',
	                        ),
                        ),
                    ),
                ),
                'scope' => 'global',
            ),
            'pisma' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'pisma',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.pisma.page_dataset' => 'krs_podmioty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.pisma.page_object_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'fielddata_fields' => array('dataset', 'id'),
	                        'size' => 3,
	                        'sort' => array(
		                        'date' => 'desc',
	                        ),
                        ),
                    ),
                ),
                'scope' => 'global',
            ),
            'kolekcje' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'kolekcje',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.kolekcje.page_dataset' => 'krs_podmioty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.kolekcje.page_object_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'fielddata_fields' => array('dataset', 'id'),
	                        'size' => 3,
	                        'sort' => array(
		                        'date' => 'desc',
	                        ),
                        ),
                    ),
                ),
                'scope' => 'global',
            ),
            /*
            'ogloszenia' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'msig_pozycje',
                                ),
                            ),
                            array(
                                'term' => array(
	                                'data.msig_pozycje.krs_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
	                'top' => array(
		                'top_hits' => array(
			                'size' => 1,
			                'sort' => array(
		                        'date' => 'desc',
	                        ),
		                ),
	                ),
                ),
                'scope' => 'global',
            ),
            */
        ));
		
        parent::_prepareView();
                        
        if( preg_match('/^\/dane\/krs_podmioty\/([^\/]+)(\/*)(.*?)$/i', $this->request->here, $match) ) {
	        
	        $url = $this->object->getUrl();
	        if( $match[3] )
	        	$url .= '/' . $match[3];
	        	        
	        return $this->redirect( $url );
	        
        }
                
        // debug( $this->object->getSlug() );
        // debug( $this->request );

        if (defined('PK_DOMAIN')) {

            $pieces = parse_url(Router::url($this->here, true));
            if (($pieces['host'] == PK_DOMAIN) && ($this->object->getData('gmina_id') != '903')) {

                $this->redirect('//' . PORTAL_DOMAIN . $_SERVER['REQUEST_URI']);
                die();

            }

        }

    }

    public function historia()
    {

        parent::_prepareView();

        /*
        $historia = $this->API->searchDataset('msig_zmiany', array(
            'limit' => 1000,
            'conditions' => array(
                'pozycja_id' => $this->object->getId(),
            ),
            'order' => array(
                '_date desc',
                'wpis_id asc',
                'nr_dz asc',
                'nr_rub asc',
                'nr_sub asc',
                'nr_prub_sub asc',
                'numer_label asc',
                '_ord desc',
            ),
        ));
        $this->set('historia', $this->API->getObjects());
        */

        $this->set('title_for_layout', 'Histora zmian w ' . $this->object->getData('nazwa'));

    }

    public function powiazania()
    {

        $this->addInitLayers(array('powiazania'));
        $this->_prepareView();

    }
    
    public function notowania()
    {
	 		 	
	 	$data = $this->Dataobject->find('first', array(
		 	'conditions' => array(
			 	'dataset' => 'krs_podmioty',
			 	'id' => $this->request->params['id'],
		 	),
		 	'limit' => 0,
		 	'aggs' => array(
			 	'notowania' => array(
				 	'nested' => array(
					 	'path' => 'gpw_notowania_dzienne',
				 	),
				 	'aggs' => array(
					 	'top' => array(
						 	'top_hits' => array(
							 	'size' => 1000,
							 	'sort' => array(
								 	'gpw_notowania_dzienne.date' => 'asc',
							 	),
						 	),
					 	),
				 	),
			 	),
		 	),
	 	));
	 	
	 	
	 	$data = array();
	 	if( @$this->Dataobject->getDataSource()->Aggs['notowania']['top']['hits']['hits'] ) {
		 	foreach( $this->Dataobject->getDataSource()->Aggs['notowania']['top']['hits']['hits'] as $d ) {
			 	
			 	$data[] = array(
				 	strtotime($d['_source']['date'])*1000, (float) $d['_source']['c']
			 	);
			 	
		 	}
	 	}	 		 	
	 	   
	    $this->set('data', $data);
	    $this->set('_serialize', 'data');
	    
    }

    public function graph()
    {
        if (@$this->request->params['ext'] == 'json') {
						
            $this->forceLayers = array('graph');
            parent::_prepareView();
            
            // var_export( $this->object->layers ); die();
            
            $data = $this->object->getLayer('graph');

            $this->set('data', $data);
            $this->set('_serialize', 'data');

        } else {

            $this->_prepareView();

        }
    }

    public function odpis()
    {

        $id = (int) $this->request->params['id'];
        $this->Session->write('KRS.odpis', $id);
        $this->redirect('/dane/krs_podmioty/' . $id);

    }

    public function zamowienia()
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne_dokumenty',
                'feeds_channels' => array(
                    'dataset' => 'krs_podmioty',
                    'object_id' => $this->object->getId(),
                    'channel' => 200,
                ),
            ),
            'renderFile' => 'krs_podmioty-zamowienia_publiczne_dokumenty',
        ));

        $this->set('title_for_layout', 'Zamówienia publiczne dla ' . $this->object->getData('nazwa'));

    }
    
    public function ogloszenia()
    {

        $this->_prepareView();
        
        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $ogloszenie = $this->Dataobject->find('first', array(
	            'conditions' => array(
		            'dataset' => 'msig_pozycje',
		            'id' => $this->request->params['subid'],
	            ),
	            'layers' => array('data'),
            ));

            $this->set('ogloszenie', $ogloszenie);
            $this->set('title_for_layout', $ogloszenie->getTitle());
            $this->render('ogloszenie');

        } else {
        
	        $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
	                'dataset' => 'msig_pozycje',
	                'msig_pozycje.krs_id' => $this->object->getId(),
	            ),
	        ));
	
	        $this->set('title_for_layout', 'Ogłoszenia ' . $this->object->getData('nazwa'));
        
        }

    }

    public function dotacje()
    {

        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'krs_podmioty.dotacje_ue:' . $this->object->getId(),
            'dataset' => 'dotacje_ue',
            'title' => 'Udzielone dotacje',
            'noResultsTitle' => 'Brak dotacji',
        ));
        $this->set('title_for_layout', 'Dotacje udzielone ' . $this->object->getTitle());

    }

	public function sprawozdania_opp()
    {

        $this->_prepareView();


        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $sprawozdanie = $this->Dataobject->find('first', array(
	            'conditions' => array(
		            'dataset' => 'sprawozdania_opp',
		            'id' => $this->request->params['subid'],
	            ),
	            'layers' => array(
		            'czesci'
	            ),
            ));
			
			$menu = array(
				'items' => array(),
				'base' => '/',
			);
			
			$czesci = $sprawozdanie->getLayer('czesci');
			$czesc = false;
			$selected_id = false;
			$document_id = false;
			
			foreach( $czesci as $c ) {
				
				$menu['items'][] = array(
					'id' => $c['id'],
					'label' => $c['nazwa'],
					'href' => '?c=' . $c['id'],
				);
				
				if(
					isset( $this->request->query['c'] ) &&
					( $this->request->query['c'] == $c['id'] )
				)
					$czesc = $c;
				
			}
			
			if( !$czesc )
				$czesc = $czesci[0];
			
			$menu['selected'] = $czesc['id'];
			
            $this->set('_submenu', $menu);
            $this->set('czesc', $czesc);
            $this->set('sprawozdanie', $sprawozdanie);
            $this->set('title_for_layout', $sprawozdanie->getTitle());
            $this->render('sprawozdanie');

        } else {

            $this->_prepareView();
	        $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
	                'dataset' => 'sprawozdania_opp',
	                'sprawozdania_opp.krs_id' => $this->object->getId(),
	            ),
	            'objectOptions' => array(
		            'view' => 'from_parent',
	            ),
	        ));

	        $this->set('title_for_layout', 'Umowy cywilnoprawne podpisane przez ' . $this->object->getData('nazwa'));

        }

    }
	
    public function umowy()
    {

        $this->_prepareView();


        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $umowa = $this->Dataobject->find('first', array(
	            'conditions' => array(
		            'dataset' => 'umowy',
		            'id' => $this->request->params['subid'],
	            ),
            ));

            $this->set('umowa', $umowa);
            $this->set('title_for_layout', $umowa->getTitle());
            $this->render('umowa');

        } else {

            $this->_prepareView();
	        $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
	                'dataset' => 'umowy',
	            ),
	        ));

	        $this->set('title_for_layout', 'Umowy cywilnoprawne podpisane przez ' . $this->object->getData('nazwa'));

        }

    }

    public function faktury()
    {

        $this->_prepareView();


        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $faktura = $this->Dataobject->find('first', array(
	            'conditions' => array(
		            'dataset' => 'faktury',
		            'id' => $this->request->params['subid'],
	            ),
            ));

            $this->set('faktura', $faktura);
            $this->set('title_for_layout', $faktura->getTitle());
            $this->render('faktura');

        } else {

            $this->_prepareView();
	        $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
	                'dataset' => 'faktury',
	            ),
	            // 'renderFile' => 'krs_podmioty-zamowienia_publiczne_dokumenty',
	        ));

	        $this->set('title_for_layout', 'Faktury wystawione dla ' . $this->object->getData('nazwa'));

        }

    }
    
    public function msig()
    {

        $this->_prepareView();


        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $faktura = $this->Dataobject->find('first', array(
	            'conditions' => array(
		            'dataset' => 'faktury',
		            'id' => $this->request->params['subid'],
	            ),
            ));

            $this->set('faktura', $faktura);
            $this->set('title_for_layout', $faktura->getTitle());
            $this->render('faktura');

        } else {

            $this->_prepareView();
	        $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
	                'dataset' => 'msig_pozycje',
	                'msig_pozycje.krs_id' => $this->object->getId()
	            ),
	        ));

	        $this->set('title_for_layout', 'Aktualności w Monitorze Sądowym i Gospodarczym o ' . $this->object->getData('nazwa'));

        }

    }

    public function emisje_akcji()
    {

        $this->addInitLayers('emisje_akcji');
        $this->_prepareView();
        $this->set('title_for_layout', 'Emisje akcji spółki ' . $this->object->getTitle());

    }

    public function oddzialy()
    {

        $this->addInitLayers('oddzialy');
        $this->_prepareView();
        $this->set('title_for_layout', 'Oddziały ' . $this->object->getTitle());

    }

    public function kultura()
    {

        $this->addInitLayers('kultura');
        $this->_prepareView();
        $this->set('title_for_layout', 'Indeksy kultury dla ' . $this->object->getTitle());

    }

    public function zmiany_umow()
    {

        $this->addInitLayers('zmiany_umow');
        $this->_prepareView();
        $this->set('title_for_layout', 'Zmiany umów ' . $this->object->getTitle());

    }

    public function getMenu()
    {
        if(!$this->object)
            return false;

        $counters = $this->object->getLayers('counters');

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Podstawowe dane',
                    'icon' => array(
                        'src' => 'glyphicon',
                        'id' => 'home',
                    ),
                ),
            ),
            'base' => $this->object->getUrl(),
        );
				
        if(
        	@$this->object_aggs['dzialania']['doc_count'] ||
        	$this->_canEdit()
        ) {
            $menu['items'][] = array(
                'id' => 'dzialania',
                'label' => 'Działania',
                'count' => @$this->object_aggs['dzialania']['doc_count'],
            );
        }
                
        if(
        	@$this->object_aggs['sprawozdania_opp']['doc_count']
        ) {
            $menu['items'][] = array(
                'id' => 'sprawozdania_opp',
                'label' => 'Sprawozdania',
                'count' => @$this->object_aggs['sprawozdania_opp']['doc_count'],
            );
        }
        
        if(
        	@$this->object_aggs['pisma']['doc_count']
        ) {
            $menu['items'][] = array(
	            'id' => 'pisma',
	            'label' => 'Pisma',
	        );
        }
        
        if(
        	@$this->object_aggs['kolekcje']['doc_count']
        ) {
            $menu['items'][] = array(
	            'id' => 'kolekcje',
	            'label' => 'Kolekcje',
	        );
        }
        
        /*
        if(
        	@$this->object_aggs['ogloszenia']['doc_count'] ||
        	$this->_canEdit()
        ) {
            $menu['items'][] = array(
                'id' => 'ogloszenia',
                'label' => 'Ogłoszenia',
                'count' => @$this->object_aggs['zmiany']['doc_count'],
            );
        }
        */
		
		if($this->object->getData('twitter_account_id')) {
            $menu['items'][] = array(
                'id' => 'media',
                'label' => 'Twitter',
            );
        }
		
		
		
		
        if (@$this->object_aggs['zamowienia']['doc_count']) {
            $menu['items'][] = array(
                'id' => 'zamowienia',
                'label' => 'Zamówienia publiczne',
                'count' => @$this->object_aggs['zamowienia']['doc_count'],
            );
        }

        $menu['items'][] = array(
            'id' => 'graph',
            'label' => 'Powiązania'
        );
		
        if($this->Auth->user()) {
            $menu['items'][] = array(
                'id' => 'odpisy',
                'label' => 'Odpisy'
            );
        }

        if($this->_canEdit()) {
            $menu['items'][] = array(
                'id' => 'dane',
                'label' => 'Edycja danych'
            );

        }

        if ($this->request->params['id'] == 481129) { // KOMITET KONKURSOWY KRAKÓW 2022

            $menu['items'][] = array(
                'id' => 'umowy',
                'label' => 'Podpisane umowy',
                'count' => 94,
            );

            $menu['items'][] = array(
                'id' => 'faktury',
                'label' => 'Faktury',
                'count' => 129,
            );
        }

        if (isset($counters['liczba_oddzialow'])) {
            $menu['items'][] = array(
                'id' => 'oddzialy',
                'label' => 'Oddziały',
                'count' => $counters['liczba_oddzialow'],
            );
        }

        /*
        if ( $counters['liczba_zmian_umow'] ) {
            $menu['items'][] = array(
                'id'   => 'zmiany_umow',
                'href' => $href_base . '/zmiany_umow',
                'label' => 'Zmiany umów',
                'count' => $counters['liczba_zmian_umow'],
            );
        }
        */


        if ($this->request->params['action'] == 'kultura') {
            $menu['items'][] = array(
                'id' => 'kultura',
                'label' => 'Indeksy kultury',
            );
        }

        

        

        return $menu;
    }

    public function odpisy() {

        if( @$this->request->params['subid'] ) {

	        $res = $this->Dataobject->getDatasource()->request('krs/odpisy/' . $this->request->params['subid']);
            $this->redirect( $res['url'] );

        } else {

	        $this->addInitLayers('odpisy');
	        $this->_prepareView();

	        if(!$this->Auth->user())
	            throw new ForbiddenException;

	        $this->set('title_for_layout', 'Odpisy z KRS podmiotu ' . $this->object->getTitle());

        }

    }

    public function media() {

        $timerange = false;
        $init = false;

        if( !isset($this->request->query['t']) ) {
            $this->request->query['t'] = $this->twitterTimerange;
            $init = true;
        }

        $this->addInitLayers(array('powiazania'));
        $this->load();

        if(false == $id = $this->object->getData('twitter_account_id'))
            throw new NotFoundException;

        if(
            ( $page = $this->object->getLayer('page') ) &&
            ( $page['logo'] )
        ) {

        } else {

            $this->object->layers['page'] = array(
                'cover' => false,
                'logo' => str_replace('_normal', '', $this->object->getData('profile_image_url_https')),
            );

        }

        if( $this->twitterTimerange = $this->request->query['t'] ) {
            $timerange = $this->Twitter->getTimerange($this->twitterTimerange);
            if(!$timerange)
                $this->redirect($this->object->getUrl() . '/media');
        }

        $this->set('last_month_report', $this->Twitter->getLastMonthReport());
        $this->set('dropdownRanges', $this->Twitter->getDropdownRanges());

        $this->set('twitterAccountTypes', $this->Twitter->twitterAccountTypes);
        $this->set('twitterAccountType', $this->twitterAccountType);

        $this->set('twitterTimeranges', $this->Twitter->twitterTimeranges);
        $this->set('twitterTimerange', $this->twitterTimerange);

        $this->set('timerange', $timerange);

        $selectedAccountsFilter = array(
            'term' => array(
                'data.twitter.twitter_account_id' => $id,
            ),
        );

        $date_histogram = array(
            'field' => 'date',
            'interval' => 'day',
            'format' => 'yyyy-MM-dd',
        );

        $selectedAccountsAggs = array(
            'top' => array(
                'top_hits' => array(
                    'sort' => array(
                        'data.twitter.liczba_zaangazowan' => array(
                            'order' => 'desc',
                        ),
                    ),
                    'size' => 7,
                    'fielddata_fields' => array('dataset', 'id', 'date'),
                ),
            ),
            'tags' => array(
                'nested' => array(
                    'path' => 'twitter-tags',

                ),
                'aggs' => array(
                    'tags' => array(
                        'terms' => array(
                            'field' => 'twitter-tags.id',
                            'size' => 20,
                            'order' => array(
                                'rn' => 'desc',
                            ),
                        ),
                        'aggs' => array(
                            'label' => array(
                                'terms' => array(
                                    'field' => 'twitter-tags.name',
                                    'size' => 1,
                                ),
                            ),
                            'rn' => array(
                                'reverse_nested' => '_empty',
                                'aggs' => array(
                                    'engagement_count' => array(
                                        'sum' => array(
                                            'field' => 'data.twitter.liczba_zaangazowan',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'mentions' => array(
                'nested' => array(
                    'path' => 'twitter-mentions',

                ),
                'aggs' => array(
                    'accounts' => array(
                        'terms' => array(
                            'field' => 'twitter-mentions.screen_name',
                            'size' => 10,
                        ),
                        'aggs' => array(
                            'screen_name' => array(
                                'terms' => array(
                                    'field' => 'twitter-mentions.screen_name',
                                    'size' => 1,
                                ),
                            ),
                            'name' => array(
                                'terms' => array(
                                    'field' => 'twitter-mentions.name',
                                    'size' => 1,
                                ),
                            ),
                            'photo' => array(
                                'terms' => array(
                                    'field' => 'twitter-mentions.account_photo_url',
                                    'size' => 1,
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'sources' => array(
                'terms' => array(
                    'field' => 'data.twitter.source_id',
                    'size' => 5,
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.twitter.source',
                            'size' => 1,
                        ),
                    ),
                ),
            ),
        );

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'twitter',
                'twitter.twitter_account_id' => $id,
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'twitter_accounts/cover',
                ),
                'aggs' => array(
                    'tweets' => array(
                        'scope' => 'global',
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'dataset' => 'twitter',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.twitter.retweet' => '0',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'global_timerange' => array(
                                'filter' => array(
                                    'range' => array(
                                        'date' => $timerange['histogram_filter'],
                                    ),
                                ),
                                'aggs' => array(
                                    'selected_accounts' => array(
                                        'filter' => $selectedAccountsFilter,
                                        'aggs' => array(
                                            'histogram' => array(
                                                'date_histogram' => $date_histogram,
                                            ),
                                        ),
                                    ),
                                    'target_timerange' => array(
                                        'filter' => array(
                                            'range' => array(
                                                'date' => $timerange['target_filter'],
                                            ),
                                        ),
                                        'aggs' => array(
                                            'accounts' => array(
                                                'filter' => $selectedAccountsFilter,
                                                'aggs' => $selectedAccountsAggs,
                                            ),
                                            'mentions' => array(
                                                'nested' => array(
                                                    'path' => 'twitter-mentions',
                                                ),
                                                'aggs' => array(
                                                    'account' => array(
                                                        'filter' => array(
                                                            'term' => array(
                                                                'twitter-mentions.account_id' => $id,
                                                            ),
                                                        ),
                                                        'aggs' => array(
                                                            'accounts' => array(
                                                                'reverse_nested' => '_empty',
                                                                'aggs' => array(
                                                                    'ids' => array(
                                                                        'terms' => array(
                                                                            'field' => 'data.twitter.twitter_user_screenname',
                                                                            'exclude' => array(
                                                                                'pattern' => '',
                                                                            ),
                                                                            'size' => 10,
                                                                        ),
                                                                        'aggs' => array(
                                                                            'name' => array(
                                                                                'terms' => array(
                                                                                    'field' => 'data.twitter.twitter_user_name',
                                                                                    'size' => 1,
                                                                                ),
                                                                            ),
                                                                            'photo' => array(
                                                                                'terms' => array(
                                                                                    'field' => 'data.twitter.twitter_user_avatar_url',
                                                                                    'size' => 1,
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
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ));
        $this->render('Dane.DataBrowser/browser');

    }

}
