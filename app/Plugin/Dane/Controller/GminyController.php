<?php

App::uses('DataobjectsController', 'Dane.Controller');

class GminyController extends DataobjectsController
{

    public $breadcrumbsMode = 'app';

    public $loadChannels = true;

    /*
     array(
            'label' => 'LC_DANE_START',
            'id' => 'view',
        ),
        array(
            'label' => 'LC_DANE_RADNI_GMINY',
            'id' => 'radni',
        ),
        array(
            'label' => 'LC_DANE_WSKAZNIKI',
            'id' => 'wskazniki',
        ),
        array(
            'label' => 'LC_DANE_ZAMOWIENIA_PUBLICZNE',
            'id' => 'zamowienia_publiczne',
        ),
        array(
            'label' => 'LC_DANE_MAPA',
            'id' => 'map',
        ),
    */

    public $menu = array();

    public $helpers = array(
        'Number' => array(
            'className' => 'Dane.NumberPlus',
        ),
    );

    public $objectOptions = array(
        'bigTitle' => true,
    );

    public function view()
    {
		
		$_layers = array('szef', 'channels');
        $this->addInitLayers($_layers);
        
        $this->_prepareView();

        if ($this->request->params['id'] == '903')
            $this->set('title_for_layout', 'Przejrzysty Kraków');
		
		
		$global_aggs = array(
			'prawo' => array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'prawo_wojewodztwa',
						        ),
					        ),
					        array(
						        'term' => array(
							        'data.prawo_wojewodztwa.gmina_id' => $this->request->params['id'],
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
						        'term' => array(
							        'data.zamowienia_publiczne.gmina_id' => $this->request->params['id'],
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        ),
	        'dokumenty' => array(
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
						        'term' => array(
							        'data.zamowienia_publiczne_dokumenty.gmina_id' => $this->request->params['id'],
						        ),
					        ),
					        array(
						        'range' => array(
							        'date' => array(
								        'gt' => 'now-1y'
							        ),
						        ),
					        ),
				        ),
			        ),					        
		        ),
		        'aggs' => array(
			        'wykonawcy' => array(
						'nested' => array(
							'path' => 'zamowienia_publiczne-wykonawcy',
						),
						'aggs' => array(
							'id' => array(								        
						        'terms' => array(
							        'field' => 'zamowienia_publiczne-wykonawcy.id',
							        'order' => array(
								        'cena' => 'desc',
							        ),
							        'size' => 3,
						        ),
						        'aggs' => array(
							        'nazwa' => array(
								        'terms' => array(
									        'field' => 'zamowienia_publiczne-wykonawcy.nazwa',
								        ),
							        ),
							        'miejscowosc' => array(
								        'terms' => array(
									        'field' => 'zamowienia_publiczne-wykonawcy.miejscowosc',
								        ),
							        ),
							        'cena' => array(
								        'sum' => array(
									        'field' => 'zamowienia_publiczne-wykonawcy.cena',
								        ),
							        ),
							        'dokumenty' => array(
								        'reverse_nested' => '_empty',
								        'aggs' => array(
									        'top' => array(
										        'top_hits' => array(
											        'size' => 3,
											        'fielddata_fields' => array('dataset', 'id'),
											        'sort' => array(
												        'zamowienia_publiczne-wykonawcy.cena' => 'desc',
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
	        'krs_podmioty' => array(
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
									'data.krs_podmioty.gmina_id' => $this->request->params['id'],
								),
							),
						),
					),
				),
				'aggs' => array(
					'typ_id' => array(
			            'terms' => array(
				            'field' => 'krs_podmioty.forma_prawna_id',
				            'exclude' => array(
					            'pattern' => '0'
				            ),
				            'size' => 12,
			            ),
			            'aggs' => array(
				            'label' => array(
					            'terms' => array(
						            'field' => 'data.krs_podmioty.forma_prawna_str',
					            ),
				            ),
			            ),
			        ),
			        'kapitalizacja' => array(
				        'range' => array(
			                'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
			                'ranges' => array(
			                    array('from' => 1, 'to' => 5000),
			                    array('from' => 5000, 'to' => 10000),
			                    array('from' => 10000, 'to' => 50000),
			                    array('from' => 50000, 'to' => 100000),
			                    array('from' => 100000, 'to' => 500000),
			                    array('from' => 500000, 'to' => 1000000),
			                    array('from' => 1000000, 'to' => 5000000),
			                    array('from' => 5000000, 'to' => 10000000),
			                    array('from' => 10000000),
		                    ),
		                ),
			        ),
			        'date' => array(
			            'date_histogram' => array(
				            'field' => 'date',
				            'interval' => 'year',
				            'format' => 'yyyy-MM-dd',
			            ),
			        ),
				),
			),
		);
		
		if( $this->object->getId()==903 ) {
			
			$global_aggs['rada_posiedzenia'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'krakow_posiedzenia',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
	        
	        $global_aggs['rada_projekty'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'rady_druki',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
	        
	        $global_aggs['interpelacje'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'rady_gmin_interpelacje',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
	        
	        $global_aggs['zarzadzenia'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'krakow_zarzadzenia',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
	        
	        $global_aggs['zarzadzenia'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'krakow_zarzadzenia',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
	        
			
		}
		
		$options  = array(
            'searchTitle' => 'Szukaj w gminie ' . $this->object->getTitle() . '...',
            'conditions' => array(
	            '_object' => 'gminy.' . $this->object->getId(),
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Dane',
		            'element' => 'gminy/cover',
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

    public function _prepareView()
    {

        if ($this->params->id == 903) {

            $this->addInitLayers(array('dzielnice'));
            $this->_layout['header']['element'] = 'pk';

        }

        if (
            defined('PORTAL_DOMAIN') &&
            defined('PK_DOMAIN') &&
            ($pieces = parse_url(Router::url($this->here, true))) &&
            ($pieces['host'] == PK_DOMAIN)
        ) {

            if ($this->params->id != 903) {

                $this->redirect('http://' . PORTAL_DOMAIN . $_SERVER['REQUEST_URI']);
                die();

            }

        }

        return parent::_prepareView();

    }

    public function powiadomienia()
    {
        $_layers = array('powiadomienia');
        $this->addInitLayers($_layers);
        $this->_prepareView();
        $this->set('title_for_layout', 'Jak to działa? - Przejrzysty Kraków');
    }
	
	public function rada()
    {
		
		$_layers = array('rada_komitety');
        $this->addInitLayers($_layers);
        $this->_prepareView();        
		
		$global_aggs = array();
		
		if( $this->object->getId()==903 ) {
			
			$global_aggs['radni'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'radni_gmin',
						        ),
					        ),
					        array(
						        'term' => array(
							        'data.radni_gmin.gmina_id' => $this->object->getId(),
						        ),
					        ),
					        array(
						        'term' => array(
							        'data.radni_gmin.aktywny' => '1',
						        ),
					        ),
					        array(
						        'term' => array(
							        'data.radni_gmin.kadencja_id' => '7',
						        ),
					        ),
				        ),
			        ),
		        ),
		        'aggs' => array(
			        'top' => array(
				        'top_hits' => array(
					        'size' => 100,
					        'fielddata_fields' => array('dataset', 'id'),
					        'sort' => array(
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
			
			$global_aggs['rada_posiedzenia'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'krakow_posiedzenia',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
	        
	        $global_aggs['rada_projekty'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'rady_druki',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );
	        
	        $global_aggs['interpelacje'] = array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'rady_gmin_interpelacje',
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
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        );	        
			
		}
		
		$options  = array(
            'searchTitle' => 'Szukaj w radzie miasta ' . $this->object->getTitle() . '...',
            'conditions' => array(
	            '_object' => 'gminy.' . $this->object->getId(),
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Dane',
		            'element' => 'gminy/rada-cover',
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
        $this->set('title_for_layout', 'Rada Miasta Krakowa');
        
    }

    public function urzad()
    {

        // $_layers = array('rada_komitety');
        // $this->addInitLayers($_layers);
        $this->_prepareView();


        $urzad = $this->Dataobject->find('first', array(
            'conditions' => array(
                'dataset' => 'urzedy_gmin',
                'id' => $this->object->getId(),
            ),
            'layers' => array('channels', 'subscriptions'),
        ));

        $this->Components->load('Dane.DataFeed', array(
            'feed' => 'urzedy_gmin' . '/' . $this->object->getId(),
            'preset' => $this->object->getDataset(),
            'side' => 'gminy-urzad',
            'searchTitle' => 'Urzędzie Miasta',
            'object_subscriptions' => $urzad->getLayer('subscriptions'),
        ));

        $this->channels = $urzad->getLayer('channels');


        $this->set('title_for_layout', 'Urząd Miasta Krakowa');

    }

    public function okregi_wyborcze()
    {


        $this->_prepareView();
        $this->request->params['action'] = 'wybory';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $okreg = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'gminy_okregi_wyborcze',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('kandydaci')
            ));

            $this->set('okreg', $okreg);
            $this->set('title_for_layout', $okreg->getTitle());
            $this->render('okreg_wyborczy');


        } else {

            $this->_prepareView();
            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'gminy_okregi_wyborcze',
                    'gminy_okregi_wyborcze.gmina_id' => $this->object->getId(),
                ),
                'aggsPreset' => 'gminy_okregi_wyborcze',
            ));

            $this->set('title_for_layout', 'Okręgi wyborcze w gminie ' . $this->object->getData('nazwa'));
            $this->set('DataBrowserTitle', 'Okręgi wyborcze w gminie ' . $this->object->getData('nazwa'));

        }

    }

    public function interpelacje()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {


            $interpelacja = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'rady_gmin_interpelacje',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('neighbours'),
            ));


            $this->set('interpelacja', $interpelacja);

            $this->set('title_for_layout', 'Interpelacja w sprawie ' . lcfirst($interpelacja->getData('tytul')));
            $this->render('interpelacja');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'rady_gmin_interpelacje',
                ),
                'aggsPreset' => 'rady_gmin_interpelacje',
            ));

            $this->set('DataBrowserTitle', 'Interpelacje radnych Miasta ' . $this->object->getData('nazwa'));
            $this->set('title_for_layout', 'Interpelacje radnych Miasta ' . $this->object->getData('nazwa'));

        }

    }

    public function posiedzenia()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $subaction = (isset($this->request->params['subaction']) && $this->request->params['subaction']) ? $this->request->params['subaction'] : 'view';
            $sub_id = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;


            $posiedzenie = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_posiedzenia',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('neighbours', 'terms'),
            ));


            $this->set('posiedzenie', $posiedzenie);
            $this->set('title_for_layout', strip_tags($posiedzenie->getTitle()));


            $subaction = isset($this->request->params['subaction']) ? $this->request->params['subaction'] : 'punkty';

            switch ($subaction) {

                case "informacja": {

                    $render_view = 'posiedzenie-informacja';
                    break;

                }

                case "porzadek": {

                    $render_view = 'posiedzenie-porzadek';
                    break;

                }

                case "podsumowanie": {

                    $render_view = 'posiedzenie-podsumowanie';
                    break;

                }

                case "glosowania": {

                    $render_view = 'posiedzenie-glosowania';
                    break;

                }

                case "stenogram": {

                    $render_view = 'posiedzenie-stenogram';
                    break;

                }

                case "protokol": {

                    $render_view = 'posiedzenie-protokol';
                    break;

                }

                default: {

                    $submenu['selected'] = 'punkty';
                    $render_view = 'posiedzenie-punkty';

                    $this->Components->load('Dane.DataBrowser', array(
                        'conditions' => array(
                            'dataset' => 'krakow_posiedzenia_punkty',
                            'krakow_posiedzenia_punkty.posiedzenie_id' => $posiedzenie->getId(),
                        ),
                        'order' => 'krakow_posiedzenia_punkty._ord asc',
                        'aggsPreset' => 'krs_podmioty',
                        'limit' => 1000,
                    ));

                    $this->set('title_for_layout', 'Posiedzenie Rady Miasta Kraków');
                    // $this->set('DataBrowserTitle', 'Organizacje w gminie ' . $this->object->getData('nazwa'));


                    break;

                }

            }

            $this->render($render_view);


        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_posiedzenia',
                ),
                'aggsPreset' => 'krakow_posiedzenia',
            ));

            $this->set('title_for_layout', 'Posiedzenia Rady Miasta ' . $this->object->getData('nazwa'));
            $this->set('DataBrowserTitle', 'Posiedzenia Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }

    public function punkty()
    {
        $this->request->params['action'] = 'rada';
        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $debata = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_posiedzenia_punkty',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('neighbours', 'wystapienia', 'wyniki_glosowania'),
            ));

            $this->set('debata', $debata);

            $wystapienia = $debata->getLayer('wystapienia');
            $this->set('wystapienia', $wystapienia);

            $this->set('title_for_layout', $debata->getTitle());

            $this->render('debata');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_posiedzenia_punkty',
                ),
                'aggsPreset' => 'krakow_posiedzenia_punkty',
                'order' => '_ord desc',
            ));

            $this->set('title_for_layout', 'Punkty porządku dziennego na posiedzeniach rady gminy ' . $this->object->getData('nazwa'));

        }
    }

    public function rada_uchwaly()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $uchwala = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_rada_uchwaly',
                    'id' => $this->request->params['subid']
                ),
                'layers' => array('neighbours', 'druki')
            ));

            $this->set('uchwala', $uchwala);
            $this->set('title_for_layout', $uchwala->getTitle());
            $this->render('rada_uchwala');

        } else {

            $this->_prepareView();
            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_rada_uchwaly',
                ),
                'aggsPreset' => 'krakow_rada_uchwaly',
            ));

            $this->set('title_for_layout', 'Uchwały podjęte przez radę gminy ' . $this->object->getData('nazwa'));
            $this->set('DataBrowserTitle', 'Uchwały Rady Miasta Krakowa');

        }
    }

    public function zarzadzenia()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'urzad';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $akt = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_zarzadzenia',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->set('akt', $akt);
            $this->set('title_for_layout', $akt->getTitle());
            $this->render('zarzadzenie');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_zarzadzenia',
                ),
                'aggsPreset' => 'krakow_zarzadzenia',
            ));

            $this->set('title_for_layout', 'Zarządzenia Prezydenta Krakowa');
            $this->set('DataBrowserTitle', 'Zarządzenia Prezydenta Krakowa');

        }
    }


    public function druki()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $druk = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'rady_druki',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('channels', 'neighbours', 'subscriptions')
            ));

            $this->set('druk', $druk);
            $this->set('title_for_layout', $druk->getTitle());

            if (
                isset($this->request->params['subaction']) &&
                ($this->request->params['subaction'] == 'dokumenty') &&
                ($druk_dokument = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'rady_druki_dokumenty',
                        'id' => $this->request->params['subsubid'],
                    ),
                )))
            ) {

                $this->set('druk_dokument', $druk_dokument);
                $this->set('title_for_layout', $druk_dokument->getTitle());
                $this->render('druk_dokument');

            } elseif (isset($this->request->params['subaction']) && ($this->request->params['subaction'] == 'tresc')) {

                $this->render('druk_tresc');

            } else {

                $this->Components->load('Dane.DataFeed', array(
                    'feed' => $druk->getDataset() . '/' . $druk->getId(),
                    'preset' => $druk->getDataset(),
                    'side' => 'rady_druki',
                    'timeline' => true,
                    'object_subscriptions' => $druk->getLayer('subscriptions'),
                    'direction' => 'asc',
                ));

                $this->loadChannels = true;
                $this->channels = $druk->getLayer('channels');

                $this->render('druk');

            }

        } else {

            $this->_prepareView();
            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'rady_druki',
                ),
                'aggsPreset' => 'rady_druki',
            ));

            $this->set('title_for_layout', 'Proces legislacyjny Rady Miasta Krakowa');
            $this->set('DataBrowserTitle', 'Proces legislacyjny Rady Miasta Krakowa');

        }

    }

    public function dzielnice()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'dzielnice';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $subaction = (isset($this->request->params['subaction']) && $this->request->params['subaction']) ? $this->request->params['subaction'] : 'view';
            $subsubid = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;

            $dzielnica = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'dzielnice',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('channels', 'subscriptions'),
            ));

            $this->loadChannels = true;
            $this->channels = $dzielnica->getLayer('channels');

            $title_for_layout = $dzielnica->getTitle();

            switch ($subaction) {

                case 'view': {

                    $this->Components->load('Dane.DataFeed', array(
                        'feed' => $dzielnica->getDataset() . '/' . $dzielnica->getId(),
                        'preset' => $dzielnica->getDataset(),
                        'side' => 'dzielnice',
                        'searchTitle' => $dzielnica->getTitle(),
                        'object_subscriptions' => $dzielnica->getLayer('subscriptions'),
                    ));

                    break;

                }

                case 'radni': {

                    if (
                        $subsubid &&
                        ($radny = $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'radni_dzielnic',
                                'id' => $subsubid,
                            ),
                        )))
                    ) {

                        $this->set('radny', $radny);
                        $title_for_layout = $radny->getTitle();
                        $subaction = 'radny';

                        $this->Components->load('Dane.DataBrowser', array(
                            'conditions' => array(
                                'dataset' => 'krakow_radni_dzielnic_glosy',
                                'krakow_radni_dzielnic_glosy.radny_id' => $radny->getId(),
                            ),
                            'aggsPreset' => 'krakow_radni_dzielnic_glosy',
                            'renderFile' => 'radni_dzielnic-uchwaly',
                        ));
                        $this->set('DataBrowserTitle', 'Wyniki głosowań');


                    } else {

                        $this->Components->load('Dane.DataBrowser', array(
                            'conditions' => array(
                                'dataset' => 'radni_dzielnic',
                                'radni_dzielnic.dzielnica_id' => $dzielnica->getId(),
                            ),
                            'limit' => 1000,
                        ));
                        $this->set('DataBrowserTitle', 'Radni dzielnicy ' . $dzielnica->getShortTitle());

                    }

                    break;


                }

                case 'rada_posiedzenia': {

                    if (
                        $subsubid &&
                        ($posiedzenie = $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'krakow_dzielnice_rady_posiedzenia',
                                'id' => $subsubid,
                            ),
                        )))
                    ) {


                        /* ob_end_clean();
                        var_dump($posiedzenie->getLayer('punkty'));
                        die(); */

                        // debug( $this->API->document($posiedzenie->getData('przedmiot_dokument_id')) ); die();


                        $punkty = (array)$posiedzenie->getLayer('punkty');
                        if (count($punkty) === 0) $punkty = false;

                        $this->set('posiedzenie', $posiedzenie);
                        $this->set('punkty', $punkty);
                        $title_for_layout = $posiedzenie->getTitle();
                        $subaction = 'posiedzenie';


                    } else {

                        $this->Components->load('Dane.DataBrowser', array(
                            'conditions' => array(
                                'dataset' => 'krakow_dzielnice_rady_posiedzenia',
                                'krakow_dzielnice_rady_posiedzenia.dzielnica_id' => $dzielnica->getId(),
                            ),
                            'aggsPreset' => 'krakow_dzielnice_rady_posiedzenia',
                        ));
                        $this->set('DataBrowserTitle', 'Posiedzenia rady dzielnicy ' . $dzielnica->getShortTitle());

                    }

                    break;


                }

                case 'rada_uchwaly': {

                    if (
                        $subsubid &&
                        ($uchwala = $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'krakow_dzielnice_uchwaly',
                                'id' => $subsubid,
                            ),
                        )))
                    ) {


                        $this->set('uchwala', $uchwala);
                        $title_for_layout = $uchwala->getTitle();
                        $subaction = 'uchwala';

                        $this->Components->load('Dane.DataBrowser', array(
                            'conditions' => array(
                                'dataset' => 'krakow_radni_dzielnic_glosy',
                                'krakow_radni_dzielnic_glosy.uchwala_id' => $uchwala->getId(),
                            ),
                            'aggsPreset' => 'krakow_dzielnice_rady_posiedzenia',
                        ));


                    } else {

                        $this->Components->load('Dane.DataBrowser', array(
                            'conditions' => array(
                                'dataset' => 'krakow_dzielnice_uchwaly',
                                'krakow_dzielnice_uchwaly.dzielnica_id' => $dzielnica->getId(),
                            ),
                        ));

                        $this->set('DataBrowserTitle', 'Uchwały rady dzielnicy ' . $dzielnica->getTitle());
                        $this->set('titleForLayout', 'Uchwały rady dzielnicy ' . $dzielnica->getTitle());

                    }

                    break;

                }
            }


            if ($this->object->getId() == 903) {

                $href_base = '/dane/gminy/' . $this->object->getId() . '/dzielnice/' . $dzielnica->getId();

                $submenu = array(
                    'items' => array(),
                );

                $submenu['items'][] = array(
                    'id' => 'radni',
                    'href' => $href_base,
                    'label' => 'Radni dzielnicy',
                );

                $submenu['items'][] = array(
                    'id' => 'uchwaly',
                    'href' => $href_base . '/uchwaly',
                    'label' => 'Uchwały',
                );

                /*
                $submenu['items'][] = array(
                    'id' => 'posiedzenia',
                    'href' => $href_base . '/posiedzenia',
                    'label' => 'Posiedzenia rady dzielnicy',
                );
                */

                $submenu['selected'] = $subaction;
                $this->set('_submenu', $submenu);

            }

            $this->set('dzielnica', $dzielnica);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('dzielnica-' . $subaction);

        } else {

            $this->set('title_for_layout', 'Dzielnice miasta ' . $this->object->getData('nazwa'));
            $this->render('dzielnice');

        }

    }

    public function dzielnice_uchwaly()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'dzielnice_uchwaly';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $uchwala = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_dzielnice_uchwaly',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->redirect($uchwala->getUrl());

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_dzielnice_uchwaly',
                    // 'gmina_id' => $this->object->getId(),
                ),
                'aggsPreset' => 'krakow_dzielnice_uchwaly',
            ));

            $this->set('title_for_layout', 'Uchwały rad dzielnic w gminie ' . $this->object->getData('nazwa'));

        }
    }

    public function komisje_posiedzenia()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $posiedzenie = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje_posiedzenia',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('neighbours'),
            ));

            $this->set('komisja_posiedzenie', $posiedzenie);
            $this->set('title_for_layout', $posiedzenie->getTitle());

            $this->render('komisja_posiedzenie');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje_posiedzenia',
                ),
                'aggsPreset' => 'krakow_komisje_posiedzenia',
                'renderFile' => 'gminy/krakow_komisje_posiedzenia',

            ));

            $this->set('DataBrowserTitle', 'Posiedzenia komisji Rady Miasta Krakowa');
            $this->set('title_for_layout', 'Posiedzenia komisji Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }


    public function radni_powiazania()
    {

        $this->addInitLayers('radni_powiazania');

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        $this->set('title_for_layout', 'Powiązania radnych gminy  ' . $this->object->getData('nazwa') . ' z organizacjami w Krajowym Rejestrze Sądowym');
    }

    public function urzednicy_powiazania()
    {

        $this->addInitLayers('urzednicy_powiazania');

        $this->_prepareView();
        $this->request->params['action'] = 'urzednicy_powiazania';

        $this->set('title_for_layout', 'Powiązania urzędników gminy  ' . $this->object->getData('nazwa') . ' z organizacjami w Krajowym Rejestrze Sądowym');
    }

    public function radni()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
		
            $subaction = (isset($this->request->params['subaction']) && $this->request->params['subaction']) ? $this->request->params['subaction'] : 'view';
            $subsubid = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;

			
			$submenu = array(
				'items' => array(
					array(
						'label' => 'Dane',
					),
					array(
						'label' => 'Interpelacje',
						'id' => 'interpelacje',
					),
					array(
						'label' => 'Obietnice wyborcze',
						'id' => 'obietnice',
					),
				),
			);
			
            $layers = array('channels', 'subscriptions', 'neighbours', 'bip_url');

            if ($subaction == 'komisje') {
                $layers[] = 'komisje';
            } elseif ($subaction == 'dyzury') {
                $layers[] = 'dyzury';
            } elseif ($subaction == 'obietnice') {
                $layers[] = 'obietnice';
            }


            $radny = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'radni_gmin',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => $layers,
            ));


            // $radny->getLayer( 'neighbours' );
            // $dyzur = $radny->getLayer('najblizszy_dyzur');
            // debug( $dyzur ); die();

            $title_for_layout = $radny->getTitle();

            switch ($subaction) {
                case 'view': {

                    $global_aggs = array(
						'interpelacje' => array(
					        'filter' => array(
						        'bool' => array(
							        'must' => array(
								        array(
									        'term' => array(
										        'dataset' => 'rady_gmin_interpelacje',
									        ),
								        ),
								        array(
									        'term' => array(
										        'data.rady_gmin_interpelacje.radny_id' => $radny->getId(),
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
				        'komisje' => array(
					        'filter' => array(
						        'bool' => array(
							        'must' => array(
								        array(
									        'term' => array(
										        'dataset' => 'radni_gmin',
									        ),
								        ),
								        array(
									        'term' => array(
										        'id' => $radny->getId(),
									        ),
								        ),
							        ),
						        ),					        
					        ),
					        'aggs' => array(
						        'komisje' => array(
									'nested' => array(
										'path' => 'radni_gmin-komisje',
									),
									'aggs' => array(
										'top' => array(								        
									        'top_hits' => array(
										        'size' => 100,
										        'fielddata_fields' => array('komisja_id', 'komisja_nazwa', 'stanowisko_id', 'stanowisko_nazwa'),
										        'sort' => array(
											         'radni_gmin-komisje.stanowisko_id' => 'desc',
										        ),
									        ),
								        ),
							        ),
						        ),
					        ),
				        ),
					);
										
					$options  = array(
			            'searchTitle' => 'Szukaj w ' . $radny->getTitle() . '...',
			            'conditions' => array(
				            '_object' => 'radni_gmin.' . $radny->getId(),
			            ),
			            'cover' => array(
				            'view' => array(
					            'plugin' => 'Dane',
					            'element' => 'radni_gmin/cover',
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
			         
			        if( $radny->getData('krs_osoba_id') ) {
				        $this->set('osoba', $this->Dataobject->find('first', array(
	                        'conditions' => array(
	                            'dataset' => 'krs_osoby',
	                            'id' => $radny->getData('krs_osoba_id'),
	                        ),
	                        'layers' => array('organizacje'),
	                    )));
                    }
			              
				    $this->Components->load('Dane.DataBrowser', $options);                    
                    $this->channels = $radny->getLayer('channels');
                    
                    $submenu['selected'] = 'view';

                    break;
                }
                case 'wystapienia': {

                    $this->Components->load('Dane.DataBrowser', array(
                        'conditions' => array(
                            'dataset' => 'rady_gmin_wystapienia',
                            'rady_gmin_wystapienia.osoba_id' => $radny->getData('osoba_id'),
                        ),
                        'aggsPreset' => 'rady_gmin_wystapienia',
                        'renderFile' => 'radni_gmin/rady_gmin_wystapienia',
                    ));

                    $this->set('DataBrowserTitle', 'Wystąpienia na posiedzeniach Rady Miasta');
                    $title_for_layout .= ' - Wystąpienia na posiedzeniach Rady Miasta';

                    break;
                }
                case 'glosowania': {

                    $this->Components->load('Dane.DataBrowser', array(
                        'conditions' => array(
                            'dataset' => 'krakow_glosowania_glosy',
                            'krakow_glosowania_glosy.radny_id' => $radny->getId(),
                        ),
                        'aggsPreset' => 'rady_gmin_wystapienia',
                        'renderFile' => 'radni_gmin/rady_gmin_glosowania',
                    ));

                    $title_for_layout .= ' - Wyniki głosowań';

                    break;
                }
                case 'interpelacje': {

                    $this->Components->load('Dane.DataBrowser', array(
                        'conditions' => array(
                            'dataset' => 'rady_gmin_interpelacje',
                            'rady_gmin_interpelacje.radny_id' => $radny->getId(),
                        ),
                        'aggsPreset' => 'rady_gmin_interpelacje',
                    ));
					
					$submenu['selected'] = 'interpelacje';
                    $this->set('DataBrowserTitle', 'Interpelacje');
                    $title_for_layout .= ' - Interpelacje';

                    break;
                }
                case 'oswiadczenia': {

                    if ($subsubid) {

                        $this->set('oswiadczenie', $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'radni_gmin_oswiadczenia_majatkowe',
                                'id' => $subsubid,
                            ),
                        )));

                    } else {

                        $this->Components->load('Dane.DataBrowser', array(
                            'conditions' => array(
                                'dataset' => 'radni_gmin_oswiadczenia_majatkowe',
                                'radni_gmin_oswiadczenia_majatkowe.radny_id' => $radny->getId(),
                            ),
                            'aggsPreset' => 'radni_gmin_oswiadczenia_majatkowe',
                            'order' => 'radni_gmin_oswiadczenia_majatkowe.rok desc',
                        ));

                        $this->set('DataBrowserTitle', 'Oświadczenia majątkowe');
                        $title_for_layout .= ' - Oświadczenia majątkowe';

                    }

                    break;
                }
                case 'obietnice': {
	                
					$submenu['selected'] = 'obietnice';
	                
                }


            }


            $this->set('radny', $radny);
            $this->set('_submenu', $submenu);
            $this->set('subsubid', $subsubid);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('radny-' . $subaction);

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'radni_gmin',
                    'radni_gmin.gmina_id' => $this->object->getId(),
                    'radni_gmin.aktywny' => '1',
                    'radni_gmin.kadencja_id' => '7',
                ),
                'aggsPreset' => 'radni_gmin',
            ));

            $this->set('title_for_layout', 'Radni w gminie ' . $this->object->getData('nazwa'));
            $this->set('DataBrowserTitle', 'Radni w gminie ' . $this->object->getData('nazwa'));


        }
    }

    public function komisje()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $subaction = (isset($this->request->params['subaction']) && $this->request->params['subaction']) ? $this->request->params['subaction'] : 'view';
            $subsubid = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;

            $komisja = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('channels', 'sklad', 'subscriptions'),
            ));


            $title_for_layout = $komisja->getTitle();

            switch ($subaction) {
                case 'view': {

                    $this->Components->load('Dane.DataFeed', array(
                        'feed' => $komisja->getDataset() . '/' . $komisja->getId(),
                        'preset' => $komisja->getDataset(),
                        'side' => 'krakow_komisje',
                        'searchTitle' => $komisja->getTitle(),
                        'object_subscriptions' => $komisja->getLayer('subscriptions'),
                    ));

                    $this->loadChannels = true;
                    $this->channels = $komisja->getLayer('channels');

                    break;
                }
                case 'posiedzenia': {

                    if (
                        $subsubid &&
                        ($posiedzenie = $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'krakow_komisje_posiedzenia',
                                'id' => $subsubid,
                            ),
                            'layers' => array('punkty')
                        )))
                    ) {

                        // debug( $this->API->document($posiedzenie->getData('przedmiot_dokument_id')) ); die();

                        $punkty = (array)$posiedzenie->getLayer('punkty');
                        if (count($punkty) === 0) $punkty = false;
                        $this->set('punkty', $punkty);

                        $this->set('posiedzenie', $posiedzenie);
                        $title_for_layout = $posiedzenie->getTitle();
                        $subaction = 'posiedzenie';


                    } else {

                        $this->Components->load('Dane.DataBrowser', array(
                            'conditions' => array(
                                'dataset' => 'krakow_komisje_posiedzenia',
                                'krakow_komisje_posiedzenia.komisja_id' => $komisja->getId(),
                            ),
                            'aggsPreset' => 'krakow_komisje_posiedzenia',
                        ));

                    }

                    break;


                }

            }


            if ($this->object->getId() == 903) {

                $href_base = '/dane/gminy/' . $this->object->getId() . '/komisje/' . $komisja->getId();

                $submenu = array(
                    'items' => array(),
                );

                $submenu['items'][] = array(
                    'id' => 'view',
                    'href' => $href_base,
                    'label' => 'Skład',
                );

                $submenu['items'][] = array(
                    'id' => 'posiedzenia',
                    'href' => $href_base . '/posiedzenia',
                    'label' => 'Posiedzenia',
                );


                $submenu['selected'] = $subaction;
                $this->set('_submenu', $submenu);

            }

            $this->set('komisja', $komisja);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('komisja-' . $subaction);

        } else {

            $this->_prepareView();

            $this->request->query['conditions']['krakow_komisje.kadencja_id'] = '7';

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje',
                ),
            ));

            $this->set('title_for_layout', 'Komisje Rady Miasta Krakowa');
            $this->set('DataBrowserTitle', 'Komisje Rady Miasta Krakowa');

        }
    }


    public function radni_dzielnic()
    {
        $this->_prepareView();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'radni_dzielnic',
                // 'gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'radni_dzielnic',
        ));

        $this->set('title_for_layout', 'Radni dzielnic w Krakowie');

    }

    public function zamowienia()
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne',
                'zamowienia_publiczne.gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'zamowienia_publiczne',
        ));

        $this->set('title_for_layout', 'Zamówienia publiczne w gminie ' . $this->object->getData('nazwa'));
        $this->set('DataBrowserTitle', 'Zamówienia publiczne w gminie ' . $this->object->getData('nazwa'));

    }

    public function miejscowosci()
    {

        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $miejscowosc = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'miejscowosci',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->set('miejscowosc', $miejscowosc);
            $this->set('title_for_layout', $miejscowosc->getTitle() . ' w gminie ' . $this->object->getTitle());
            $this->render('miejscowosc');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'miejscowosci',
                    'miejscowosci.gmina_id' => $this->object->getId(),
                ),
                'aggsPreset' => 'miejscowosci',
            ));

            $this->set('title_for_layout', 'Miejscowości w gminie ' . $this->object->getData('nazwa'));
            $this->set('DataBrowserTitle', 'Miejscowości w gminie ' . $this->object->getData('nazwa'));
            $this->render('Dane.DataBrowser/browser');

        }

    }

    public function organizacje()
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'krs_podmioty',
        ));

        $this->set('title_for_layout', 'Organizacje w gminie ' . $this->object->getData('nazwa'));
        $this->set('DataBrowserTitle', 'Organizacje w gminie ' . $this->object->getData('nazwa'));

    }

    public function biznes()
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.gmina_id' => $this->object->getId(),
                'krs_podmioty.forma_prawna_typ_id' => '1',
            ),
            'aggsPreset' => 'krs_podmioty',
        ));

        $this->set('title_for_layout', 'Organizacje biznesowe w gminie ' . $this->object->getData('nazwa'));
        $this->set('DataBrowserTitle', 'Organizacje w gminie ' . $this->object->getData('nazwa'));

    }
    
    public function prawo()
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_wojewodztwa',
                'prawo_wojewodztwa.gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'krs_podmioty',
        ));

        $this->set('title_for_layout', 'Prawo lokalne gminy ' . $this->object->getData('nazwa'));
        $this->set('DataBrowserTitle', 'Prawo lokalne gminy ' . $this->object->getData('nazwa'));

    }

    public function ngo()
    {
        if (isset($this->request->query['export'])) {
            $this->addInitLayers(array('ngo_export'));
            $this->_prepareView();
            ob_end_clean();
            header('Content-Type: application/json');
            echo $this->object->getLayer('ngo_export');
            exit;
        } else {
            $this->_prepareView();
            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krs_podmioty',
                    'krs_podmioty.gmina_id' => $this->object->getId(),
                    'krs_podmioty.forma_prawna_typ_id' => '2',
                ),
                'aggsPreset' => 'krs_podmioty',
            ));

            $this->set('title_for_layout', 'Organizacje pozarządowe w gminie ' . $this->object->getData('nazwa'));
            $this->set('DataBrowserTitle', 'Organizacje pozarządowe w gminie ' . $this->object->getData('nazwa'));
        }
    }

    public function spzoz()
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.gmina_id' => $this->object->getId(),
                'krs_podmioty.forma_prawna_typ_id' => '3',
            ),
            'aggsPreset' => 'krs_podmioty',
        ));

        $this->set('title_for_layout', 'Samodzielne Publiczne Zakłady Opieki Zdrowotnej w gminie ' . $this->object->getData('nazwa'));
        $this->set('DataBrowserTitle', 'Samodzielne Publiczne Zakłady Opieki Zdrowotnej w gminie ' . $this->object->getData('nazwa'));

    }


    public function dotacje_ue()
    {
        $this->_prepareView();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'dotacje_ue',
                'dotacje_ue.gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'dotacje_ue',
        ));

        $this->set('DataBrowserTitle', 'Dotacje Unii Europejskiej w gminie ' . $this->object->getData('nazwa'));
        $this->set('title_for_layout', 'Dotacje Unii Europejskiej w gminie ' . $this->object->getData('nazwa'));

    }

    public function urzednicy()
    {

        $this->request->params['action'] = 'urzad';
        $this->_prepareView();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krakow_urzednicy',
            ),
            'aggsPreset' => 'krakow_urzednicy',
        ));

        $this->set('title_for_layout', 'Urzędnicy urzędu miasta ' . $this->object->getData('nazwa'));

    }

    public function jednostki()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'urzad';

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krakow_jednostki',
            ),
            'aggsPreset' => 'krakow_jednostki',
        ));

        $this->set('title_for_layout', 'Jednostki administracyjne urzędu miasta ' . $this->object->getData('nazwa'));

    }

    public function oswiadczenia()
    {

        $this->request->params['action'] = 'urzad';
        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {


            $oswiadczenie = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_oswiadczenia',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->set('oswiadczenie', $oswiadczenie);
            $this->set('title_for_layout', $oswiadczenie->getTitle());
            $this->render('oswiadczenie');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_oswiadczenia',
                ),
                'aggsPreset' => 'krakow_oswiadczenia',
            ));

            $this->set('title_for_layout', 'Oświadczenia majątkowe urzędu miasta ' . $this->object->getData('nazwa'));

        }

    }

    public function rady_gmin_wystapienia()
    {
        $this->_prepareView();

        $title_for_layout = 'Wystąpienia podczas wszystkich posiedzeń rady gminy ' . $this->object->getData('nazwa');
        $this->innerSearch('rady_gmin_wystapienia', array('rady_gmin_debaty.gmina_id' => $this->object->getId()), array(
            'searchTitle' => $title_for_layout,
        ));
        $this->set('title_for_layout', $title_for_layout);
    }


    public function map()
    {
        $this->_prepareView();
        $this->set('spat', $this->object->loadLayer('enspat'));
    }


    public function zamowienia_publiczne()
    {

        $url = '/dane/gminy/' . $this->request->params['id'] . '/zamowienia';

        if (!empty($this->request->query)) {
            $url .= '?' . http_build_query($this->request->query);
        }

        $this->redirect($url);

    }

    public function wpf()
    {
        $this->addInitLayers(array(
            'wpf'
        ));
        $this->_prepareView();
        $this->request->params['action'] = 'wpf';
        $this->set('title_for_layout', 'Wieloletnia prognoza finansowa Miasta Krakowa');

    }

    public function finanse()
    {
        $this->addInitLayers(array(
            'finanse'
        ));
        $this->_prepareView();
        $this->request->params['action'] = 'finanse';
        $this->set('title_for_layout', 'Wydatki w gminie ' . $this->object->getTitle());

    }

    /*
    public function prepareMenu()
    {
        if ($this->object->getId() == '903') {


            $this->menu = array(
                array(
                    'label' => 'LC_DANE_START',
                    'id' => 'view',
                ),
                array(
                    'label' => 'Radni gminy',
                    'id' => 'radni',
                ),
                array(
                    'label' => 'Prawo lokalne',
                    'id' => 'prawo_lokalne',
                ),
                array(
                    'label' => 'Darczyńcy komitetów wyborczych',
                    'id' => 'darczyncy',
                ),
                array(
                    'label' => 'LC_DANE_WSKAZNIKI',
                    'id' => 'wskazniki',
                ),
                array(
                    'label' => 'LC_DANE_ZAMOWIENIA_PUBLICZNE',
                    'id' => 'zamowienia_publiczne',
                ),
                array(
                    'label' => 'LC_DANE_MAPA',
                    'id' => 'map',
                ),
            );


        }
    }
    */
	
	public function getMenu() 
	{
		
		$object = $this->object;
				
		$menu = array(
			'items' => array(),
		);
		
		$menu['items'][] = array(
			'label' => 'Dane',
		);
		
		$menu['items'][] = array(
			'label' => 'Prawo lokalne',
			'id' => 'prawo',
		);
		
		$menu['items'][] = array(
			'label' => 'Zamówienia publiczne',
			'id' => 'zamowienia',
		);
		
		$menu['items'][] = array(
			'label' => 'Organizacje',
			'id' => 'organizacje',
		);
		
		if ($object->getId() == '903') {
            
            $menu['items'][] = array(
                'id' => 'rada',
                'label' => 'Rada Miasta',
                'href' =>  'rada',
            );

            $menu['items'][] = array(
                'id' => 'urzad',
                'label' => 'Urząd Miasta',
                'href' => 'urzad',
            );

            $dzielnice_items = array();
            if ($dzielnice = $object->getLayer('dzielnice')) {

                $dzielnice_items[] = array(
                    'id' => 'dzielnice',
                    'label' => 'Lista dzielnic',
                    'href' =>  'dzielnice'
                );

                $dzielnice_items[] = array(
                    'id' => 'radni_dzielnic',
                    'label' => 'Radni dzielnic',
                    'href' =>  'radni_dzielnic'
                );

                $dzielnice_items[] = array(
                    'id' => 'dzielnice_uchwaly',
                    'label' => 'Uchwały rad dzielnic',
                    'href' =>  'dzielnice_uchwaly'
                );

                /*
                foreach( $dzielnice as $dzielnica )
                    $dzielnice_items[] = array(
                        'id' => $dzielnica['id'],
                        'label' => $dzielnica['nazwa'],
                        'href' => $href_base . '/dzielnice/' . $dzielnica['id'],
                    );

                $dzielnice_items[3]['topborder'] = true;
                */


                $menu['items'][] = array(
                    'id' => 'dzielnice',
                    'label' => 'Dzielnice',
                    'href' =>  'dzielnice',
                    /*
                    'dropdown' => array(
                        'items' => $dzielnice_items,
                    ),
                    */
                );

            }
            
            $menu['items'][] = array(
                'id' => 'finanse',
                'href' =>  'finanse',
                'label' => 'Finanse',
                'icon' => '',
            );

        }
        
        return $menu;
		
	}

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        if ($this->object->getId() == '903') {
            $this->setMeta('og:image', FULL_BASE_URL . '/dane/img/social/przejrzystykrakow.jpg');
        }
    }
}