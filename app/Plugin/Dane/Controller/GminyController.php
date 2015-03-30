<?php

App::uses('DataobjectsController', 'Dane.Controller');

class GminyController extends DataobjectsController
{

    public $breadcrumbsMode = 'app';

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

        $_layers = array('szef');
        if ($this->request->params['id'] == '903') {
            $_layers[] = 'ostatnie_posiedzenie';
            $_layers[] = 'radni';
        }

        $this->addInitLayers($_layers);
        parent::view();

        $szef = $this->object->getLayer('szef');
        
		

        $this->set('zamowienia_otwarte', $this->Dataobject->find('all', array(
			'conditions' => array(
				'dataset' => 'zamowienia_publiczne',
				'zamowienia_publiczne.gmina_id' => $this->object->getId(),
				'zamowienia_publiczne.status_id' => '0',
			),
			'limit' => 8,
		)));
		
		$this->set('zamowienia_zamkniete', $this->Dataobject->find('all', array(
			'conditions' => array(
				'dataset' => 'zamowienia_publiczne',
				'zamowienia_publiczne.gmina_id' => $this->object->getId(),
				'zamowienia_publiczne.status_id' => '2',
			),
			'limit' => 8,
		)));
		
		$this->set('zamowienia_zamkniete', $this->Dataobject->find('all', array(
			'conditions' => array(
				'dataset' => 'zamowienia_publiczne',
				'zamowienia_publiczne.gmina_id' => $this->object->getId(),
				'zamowienia_publiczne.status_id' => '2',
			),
			'limit' => 8,
		)));
		
		
		
		$this->set('organizacje', $this->Dataobject->find('all', array(
			'conditions' => array(
				'dataset' => 'krs_podmioty',
				'krs_podmioty.gmina_id' => $this->object->getId(),
				'krs_podmioty.forma_prawna_typ_id' => '1',
				'krs_podmioty.wykreslony' => '0',
			),
			'order' => 'krs_podmioty.wartosc_kapital_zakladowy desc',
			'limit' => 5,
		)));
		
		
		
		
		$this->Dataobject->find('all', array(
			'conditions' => array(
				'dataset' => 'krs_podmioty',
				'krs_podmioty.gmina_id' => $this->object->getId(),
				'krs_podmioty.forma_prawna_typ_id' => '2',
				'krs_podmioty.wykreslony' => '0',
			),
			'order' => 'krs_podmioty.wartosc_kapital_zakladowy desc',
			'limit' => 0,
			'aggs' => array(
				'typ_id' => array(
		            'terms' => array(
			            'field' => 'krs_podmioty.forma_prawna_id',
			            'exclude' => array(
				            'pattern' => '0'
			            ),
		            ),
		            'aggs' => array(
			            'label' => array(
				            'terms' => array(
					            'field' => 'data.krs_podmioty.forma_prawna_str',
				            ),
			            ),
		            ),
		        ),
			),
		));
		

        $ngos = $this->Dataobject->getAggs();
        $this->set('ngos', $ngos['typ_id']['buckets']);


        if ($this->object->getId() == 903) {

            // PRZEJRZYSTY KRAKÓW

            /*
            $this->API->searchDataset('rady_druki', array(
                'limit' => 12,
                'conditions' => array(
                    'gmina_id' => $this->object->getId(),
                ),
            ));
            $this->set('rady_druki', $this->API->getObjects());
            */

            /*
            $this->API->searchDataset('rady_posiedzenia', array(
                'limit' => 12,
                'conditions' => array(
                    'gmina_id' => $this->object->getId(),
                ),
            ));
            $this->set('rady_posiedzenia', $this->API->getObjects());
            */
			
			
			
            
			
			
			$this->set('prawo_lokalne', $this->Dataobject->find('all', array(
				'conditions' => array(
					'dataset' => 'prawo_lokalne',
					'prawo_lokalne.gmina_id' => $this->object->getId(),
				),
				'limit' => 3,
			)));
			
			$this->set('zarzadzenia', $this->Dataobject->find('all', array(
				'conditions' => array(
					'dataset' => 'krakow_zarzadzenia',
				),
				'limit' => 3,
			)));
			
			$this->set('dzielnice', $this->Dataobject->find('all', array(
				'conditions' => array(
					'dataset' => 'dzielnice',
				),
				'limit' => 100,
			)));
			

            $this->render('view-krakow');

        }


        /*
        $wskazniki = $this->object->loadLayer('wskazniki');
        $rada_komitety = $this->object->loadLayer('rada_komitety');
        $wskazniki = array_slice($wskazniki, 0, 5, true);
        */


    }

    public function rada()
    {

        $_layers = array('rada_komitety');
        $this->addInitLayers($_layers);
        $this->load();
			    
	    $this->Components->load('Dane.DataFeed', array(
            'feed' => $this->object->getDataset() . '/' . $this->object->getId(),
            'channel' => 'rada',
            'preset' => $this->object->getDataset(),
        ));

        $this->set('title_for_layout', 'Rada Miasta Krakowa');
    }

    public function urzad()
    {

        // $_layers = array('rada_komitety');
        // $this->addInitLayers($_layers);
        $this->load();
			    
	    $this->Components->load('Dane.DataFeed', array(
            'feed' => $this->object->getDataset() . '/' . $this->object->getId(),
            'channel' => 'urzad',
            'preset' => $this->object->getDataset(),
        ));

        $this->set('title_for_layout', 'Urząd Miasta Krakowa');

    }

    public function okregi_wyborcze()
    {


        $this->_prepareView();
        $this->request->params['action'] = 'wybory';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $okreg = $this->API->getObject('gminy_okregi_wyborcze', $this->request->params['subid'], array(
                'layers' => array('kandydaci'),
            ));

            $this->set('okreg', $okreg);
            $this->set('title_for_layout', $okreg->getTitle());
            $this->render('okreg_wyborczy');


        } else {
			
			$this->load();
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

    public function _prepareView()
    {

        if ($this->params->id == 903) {

            $this->addInitLayers(array('dzielnice'));

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

    public function interpelacje()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $interpelacja = $this->API->getObject('rady_gmin_interpelacje', $this->request->params['subid'], array(
                'layers' => array('neighbours'),
            ));
            $document = $this->API->document($interpelacja->getData('dokument_id'));
            $this->set('interpelacja', $interpelacja);
            $this->set('document', $document);
            $this->set('documentPackage', 1);
            
            if( $interpelacja->getData('odp1_dokument_id') ) {
	            $document1 = $this->API->document($interpelacja->getData('odp1_dokument_id'));
	            $this->set('document1', $document1);
            }
            
            if( $interpelacja->getData('odp2_dokument_id') ) {
	            $document2 = $this->API->document($interpelacja->getData('odp2_dokument_id'));
	            $this->set('document2', $document2);
            }
            
            $this->set('title_for_layout', 'Interpelacja w sprawie ' . lcfirst($interpelacja->getData('tytul')));
            $this->render('interpelacja');

        } else {

            $this->dataobjectsBrowserView(array(
                'source' => 'gminy.interpelacje:' . $this->object->getId(),
                'dataset' => 'rady_gmin_interpelacje',
                'title' => 'Interpelacje radnych',
                'noResultsTitle' => 'Brak interpelacji',
                'back' => $this->object->getUrl() . '/rada',
                'backTitle' => 'Rada Miasta Krakowa',
            ));

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


            $posiedzenie = $this->API->getObject('krakow_posiedzenia', $this->request->params['subid'], array(
                'layers' => array('neighbours', 'terms'),
            ));


            $this->set('posiedzenie', $posiedzenie);
            $this->set('title_for_layout', strip_tags($posiedzenie->getTitle()));


            /*
            $submenu['items'][] = array(
                'id' => 'przebieg',
                'label' => 'Przebieg posiedzenia',
                'dropdown' => array(
                    'items' => array(
                        array(
                            'id' => 'punkty',
                            'href' => '/dane/gminy/903/posiedzenia/' . $this->request->params['subid'] . '/punkty',
                            'label' => 'Punkty porządku dziennego',
                        ),
                    ),
                ),
            );
            */
			
			
            
			
			$subaction = isset($this->request->params['subaction']) ? $this->request->params['subaction'] : 'punkty';
			
            switch ($subaction) {
                
                case "informacja": {
	                
	                $document = $this->API->document($posiedzenie->getData('zwolanie_dokument_id'));
		            $this->set('document', $document);
	                $render_view = 'posiedzenie-informacja';
	                break;
	                
                }
                
                case "porzadek": {
	                	                
	                $document = $this->API->document($posiedzenie->getData('porzadek_dokument_id'));
					$this->set('document', $document);
	                $render_view = 'posiedzenie-porzadek';
	                break;
	                
                }
                
                case "podsumowanie": {
	                
	                $document = $this->API->document($posiedzenie->getData('podsumowanie_dokument_id'));
		            $this->set('document', $document);
	                $render_view = 'posiedzenie-podsumowanie';
	                break;
	                
                }
                
                case "glosowania": {
	                
	                $document = $this->API->document($posiedzenie->getData('wyniki_dokument_id'));
		            $this->set('document', $document);
	                $render_view = 'posiedzenie-glosowania';
	                break;
	                
                }
                
                case "stenogram": {
	                
	                $document = $this->API->document($posiedzenie->getData('stenogram_dokument_id'));
		            $this->set('document', $document);
	                $render_view = 'posiedzenie-stenogram';
	                break;
	                
                }
                
                case "protokol": {
	                
	                $document = $this->API->document($posiedzenie->getData('protokol_dokument_id'));
		            $this->set('document', $document);
	                $render_view = 'posiedzenie-protokol';
	                break;
	                
                }
                
                default: {
										
                    $submenu['selected'] = 'punkty';
                    $render_view = 'posiedzenie-punkty';

                    $this->dataobjectsBrowserView(array(
                        'source' => 'krakow_posiedzenia.punkty:' . $posiedzenie->getId(),
                        'dataset' => 'krakow_posiedzenia_punkty',
                        'title' => 'Punkty porządku dziennego',
                        'noResultsTitle' => 'Brak punktów porządku dziennego',
                        'order' => '_ord asc',
                        'routes' => array(
                            'date' => false,
                        ),
                        'limit' => 1000,
                        'excludeFilters' => array('krakow_glosowania.wynik_id'),
                    ));

                    break;

                }

            }

            $this->render($render_view);


        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'krakow_posiedzenia',
                'title' => 'Posiedzenia',
                'noResultsTitle' => 'Brak posiedzeń',
                // 'hlFields' => array('numer', 'liczba_debat'),
                'back' => '/dane/gminy/903,krakow/rada',
                'backTitle' => 'Rada Miasta Krakowa',
            ));

            $this->set('title_for_layout', 'Posiedzenia Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }

    public function punkty()
    {
        $this->request->params['action'] = 'rada';
        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $debata = $this->API->getObject('krakow_posiedzenia_punkty', $this->request->params['subid'], array(
                'layers' => array('neighbours', 'wystapienia', 'wyniki_glosowania'),
            ));

            $this->set('debata', $debata);

            $wystapienia = $debata->getLayer('wystapienia');
            $this->set('wystapienia', $wystapienia);

            $this->set('title_for_layout', $debata->getTitle());

            $this->render('debata');

        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'krakow_posiedzenia_punkty',
                'title' => 'Punkty porządku dziennego',
                'noResultsTitle' => 'Brak wyników',
                'hlFields' => array(),
                'order' => '_ord desc',
            ));

            $this->set('title_for_layout', 'Punkty porządku dziennego na posiedzeniach rady gminy ' . $this->object->getData('nazwa'));

        }
    }

    /*
    public function wystapienia()
    {
        $this->request->params['action'] = 'rada_wystapienia';
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'dataset' => 'rady_gmin_wystapienia',
            'title' => 'Wystąpienia podczas posiedzeń',
            'noResultsTitle' => 'Brak wystąpień',
            'hlFields' => array(),
        ));

        $this->set('title_for_layout', 'Wystąpienia na posiedzeniach rady gminy ' . $this->object->getData('nazwa'));
    }
    */

    public function rada_uchwaly()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $uchwala = $this->API->getObject('prawo_lokalne', $this->request->params['subid'], array(
                'layers' => array('neighbours'),
            ));
            $document = $this->API->document($uchwala->getData('dokument_id'));
            $this->set('uchwala', $uchwala);
            $this->set('document', $document);
            $this->set('documentPackage', 1);
            $this->set('title_for_layout', $uchwala->getTitle());

            $this->render('rada_uchwala');

        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'prawo_lokalne',
                'title' => 'Uchwały rady miasta',
                'noResultsTitle' => 'Brak danych',
                // 'hlFields' => $hl_fields = array('numer', 'liczba_debat'),
                'back' => '/dane/gminy/903,krakow/rada',
                'backTitle' => 'Rada Miasta Krakowa',
            ));
            $this->set('title_for_layout', 'Uchwały podjęte przez radę gminy ' . $this->object->getData('nazwa'));

        }
    }

    public function zarzadzenia()
    {
        $this->load();
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
			
            $druk = $this->API->getObject('rady_druki', $this->request->params['subid'], array(
                'layers' => 'neighbours',
            ));
            
            $this->set('druk', $druk);
            $this->set('title_for_layout', $druk->getTitle());
            
            if( 
            	isset( $this->request->params['subaction'] ) && 
            	( $this->request->params['subaction']=='dokumenty' ) && 
            	( $druk_dokument = $this->API->getObject('rady_druki_dokumenty', $this->request->params['subsubid'], array(
	                // 'layers' => 'neighbours',
	            )) )
            ) {
	            
	            $document = $this->API->document($druk_dokument->getData('dokument_id'));
	        	$this->set('document', $document);
				$this->set('documentPackage', 1);
				
				$this->set('druk_dokument', $druk_dokument);
	            $this->set('title_for_layout', $druk_dokument->getTitle());
				
				$this->render('druk_dokument');
            
           } elseif( isset($this->request->params['subaction']) && ($this->request->params['subaction']=='tresc') ) {
            	
            	$document = $this->API->document($druk->getData('dokument_id'));
	        	$this->set('document', $document);
				$this->set('documentPackage', 1);
				
				$this->render('druk_tresc');
	            
            } else {
            
	            $this->feed(array(
	                'dataset' => 'rady_druki',
	                'id' => $druk->getId(),
	                'direction' => 'asc',
	            ));	            
	
	            $this->render('druk');
            
            }

        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'rady_druki',
                'title' => 'Proces legislacyjny',
                'noResultsTitle' => 'Brak danych',
                // 'hlFields' => $hl_fields = array('numer', 'liczba_debat'),
                'back' => $this->object->getUrl() . '/rada',
                'backTitle' => 'Rada Miasta Krakowa',
            ));

            $this->set('title_for_layout', 'Materiały na posiedzenia rady gminy ' . $this->object->getData('nazwa'));

        }

    }

    public function dzielnice()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'dzielnice';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $subaction = (isset($this->request->params['subaction']) && $this->request->params['subaction']) ? $this->request->params['subaction'] : 'view';
            $sub_id = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;

            $dzielnica = $this->API->getObject('dzielnice', $this->request->params['subid'], array(// 'layers' => array('najblizszy_dyzur', 'neighbours'),
            ));

            // $radny->getLayer('neighbours');
            // $dyzur = $radny->getLayer('najblizszy_dyzur');
            // debug( $dzielnica ); die();
            $title_for_layout = $dzielnica->getTitle();

            switch ($subaction) {

                case 'view': {

                    $this->feed(array(
                        'dataset' => 'dzielnice',
                        'id' => $dzielnica->getId(),
                    ));

                    break;

                }

                case 'radni': {

                    if (
                        $sub_id &&
                        ($radny = $this->API->getObject('radni_dzielnic', $sub_id))
                    ) {

                        $this->set('radny', $radny);
                        $title_for_layout = $radny->getTitle();
                        $subaction = 'radny';

                        $this->dataobjectsBrowserView(array(
                            'source' => 'radni_dzielnic.glosy:' . $radny->getId(),
                            'dataset' => 'krakow_radni_dzielnic_glosy',
                            'noResultsTitle' => 'Brak wyników',
                            'excludeFilters' => array(
                                'dzielnica_id'
                            ),
                            'title' => 'Wyniki głosowań',
                            // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),
                            'renderFile' => 'radni_dzielnic-uchwaly',
                        ));

                    } else {

                        $this->dataobjectsBrowserView(array(
                            'source' => 'dzielnice.radni:' . $dzielnica->getId(),
                            'dataset' => 'radni_dzielnic',
                            'noResultsTitle' => 'Brak radnych',
                            'excludeFilters' => array(
                                'dzielnica_id'
                            ),
                            'title' => 'Radni dzielnicy ' . $dzielnica->getTitle(),
                            // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),
                            'back' => $dzielnica->getUrl(),
                            'backTitle' => 'Dzielnica ' . $dzielnica->getTitle(),
                            'limit' => 1000,
                        ));


                    }

                    break;


                }

                case 'rada_posiedzenia': {

                    if (
                        $sub_id &&
                        ($posiedzenie = $this->API->getObject('krakow_dzielnice_rady_posiedzenia', $sub_id, array(
                            'layers' => array(
                                'punkty'
                            )
                        )))
                    ) {


                        /* ob_end_clean();
                        var_dump($posiedzenie->getLayer('punkty'));
                        die(); */

                        // debug( $this->API->document($posiedzenie->getData('przedmiot_dokument_id')) ); die();

                        if ($posiedzenie->getData('protokol_dokument_id'))
                            $this->set('protokol_dokument', $this->API->document($posiedzenie->getData('protokol_dokument_id')));

                        if ($posiedzenie->getData('przedmiot_dokument_id'))
                            $this->set('przedmiot_dokument', $this->API->document($posiedzenie->getData('przedmiot_dokument_id')));

                        $punkty = (array) $posiedzenie->getLayer('punkty');
                        if(count($punkty) === 0) $punkty = false;

                        $this->set('documentPackage', 1);
                        $this->set('posiedzenie', $posiedzenie);
                        $this->set('punkty', $punkty);
                        $title_for_layout = $posiedzenie->getTitle();
                        $subaction = 'posiedzenie';


                    } else {

                        $this->dataobjectsBrowserView(array(
                            'source' => 'dzielnice.posiedzenia:' . $dzielnica->getId(),
                            'dataset' => 'krakow_dzielnice_rady_posiedzenia',
                            'noResultsTitle' => 'Brak posiedzen',
                            'excludeFilters' => array(
                                'dzielnica_id'
                            ),
                            'title' => 'Posiedzenia rady dzielnicy ' . $dzielnica->getTitle(),
                            // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),
                            'back' => $dzielnica->getUrl(),
                            'backTitle' => 'Dzielnica ' . $dzielnica->getTitle(),
                        ));

                    }

                    break;


                }

                case 'rada_uchwaly': {

                    if (
                        $sub_id &&
                        ($uchwala = $this->API->getObject('krakow_dzielnice_uchwaly', $sub_id))
                    ) {

                        if ($uchwala->getData('dokument_id'))
                            $this->set('document', $this->API->document($uchwala->getData('dokument_id')));

                        $this->set('uchwala', $uchwala);
                        $title_for_layout = $uchwala->getTitle();
                        $subaction = 'uchwala';

                        $this->dataobjectsBrowserView(array(
                            'source' => 'krakow_dzielnice_uchwaly.glosy:' . $uchwala->getId(),
                            'dataset' => 'krakow_radni_dzielnic_glosy',
                            'noResultsTitle' => 'Brak wyników',
                            'excludeFilters' => array(
                                'dzielnica_id'
                            ),
                            'title' => 'Wyniki głosowania nad uchwałą',
                            // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),
                            'renderFile' => 'krakow_dzielnice_uchwaly-glosy',
                            'limit' => 1000,
                        ));

                    } else {

                        $this->dataobjectsBrowserView(array(
                            'source' => 'dzielnice.uchwaly:' . $dzielnica->getId(),
                            'dataset' => 'krakow_dzielnice_uchwaly',
                            'noResultsTitle' => 'Brak uchwał',
                            'excludeFilters' => array(
                                'dzielnice_id'
                            ),
                            // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),
                            'title' => 'Uchwały rady dzielnicy',
                            'back' => $dzielnica->getUrl(),
                            'backTitle' => 'Dzielnica ' . $dzielnica->getTitle(),
                        ));

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
            $this->set('sub_id', $sub_id);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('dzielnica-' . $subaction);

        } else {

            $params = array(
                'source' => 'gminy.dzielnice:' . $this->object->getId(),
                'dataset' => 'dzielnice',
                'noResultsTitle' => 'Brak dzielnic dla tej gminy',
                /*
                'excludeFilters' => array(
                    'gmina_id', 'gminy.powiat_id', 'gminy.wojewodztwo_id'
                ),
                */
                // 'hlFields' => array('nazwa', 'liczba_glosow'),
                'limit' => 100,
                'title' => 'Dzielnice Miasta Kraków',
            );

            $this->dataobjectsBrowserView($params);
            $this->set('title_for_layout', 'Dzielnice miasta ' . $this->object->getData('nazwa'));

        }

    }

    public function dzielnice_uchwaly()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'dzielnice_uchwaly';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $uchwala = $this->API->getObject('krakow_dzielnice_uchwaly', $this->request->params['subid'], array(// 'layers' => 'neighbours',
            ));
            $this->redirect($uchwala->getUrl());

        } else {

            $this->dataobjectsBrowserView(array(
                // 'source'         => 'gminy.miejscowosci:' . $this->object->getId(),
                'dataset' => 'krakow_dzielnice_uchwaly',
                'noResultsTitle' => 'Brak uchwał',
                /*
                'excludeFilters' => array(
                    'gmina_id'
                ),
                */
                'hlFields' => array(),
                'title' => 'Uchwały Dzielnic Miasta Kraków',
            ));
            $this->set('title_for_layout', 'Uchwały rad dzielnic w gminie ' . $this->object->getData('nazwa'));

        }
    }

    public function komisje_posiedzenia()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $posiedzenie = $this->API->getObject('krakow_komisje_posiedzenia', $this->request->params['subid'], array(
                'layers' => array('neighbours'),
            ));
            $document = $this->API->document($posiedzenie->getData('dokument_id'));

            $this->set('komisja_posiedzenie', $posiedzenie);
            $this->set('document', $document);
            $this->set('documentPackage', 1);
            $this->set('title_for_layout', $posiedzenie->getTitle());

            $this->render('komisja_posiedzenie');

        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'krakow_komisje_posiedzenia',
                'title' => 'Posiedzenia komisji',
                'noResultsTitle' => 'Brak danych',
                // 'hl_fields' => array('krakow_komisje.nazwa'),
                'back' => $this->object->getUrl() . '/rada',
                'backTitle' => 'Rada Miasta ' . $this->object->getTitle(),
            ));

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

    public function radni_6()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        $params = array(
            'source' => 'gminy.radni6:' . $this->object->getId(),
            'dataset' => 'radni_gmin',
            'noResultsTitle' => 'Brak radnych dla tej gminy',
            'excludeFilters' => array(
                'gmina_id',
                'gminy.powiat_id',
                'gminy.wojewodztwo_id'
            ),
            'hlFields' => array('nazwa'),
            'limit' => 100,
        );

        if ($this->object->getData('id') == '903') {
            $params['title'] = 'Radni miasta 6-tej kadencji';
            $params['back'] = $this->object->getUrl() . '/rada';
        }

        $this->dataobjectsBrowserView($params);
        $this->set('title_for_layout', 'Radni gminy ' . $this->object->getData('nazwa') . ' 6-tej kadencji');

    }

    public function radni()
    {

        $this->load();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {
						
            $subaction = (isset($this->request->params['subaction']) && $this->request->params['subaction']) ? $this->request->params['subaction'] : 'view';
            $subsubid = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;
			
			
			$radny = $this->Dataobject->find('first', array(
				'conditions' => array(
					'dataset' => 'radni_gmin',
					'id' => $this->request->params['subid'],
				),
				'layers' => array('neighbours', 'bip_url'),
			));
			



            // $radny->getLayer( 'neighbours' );
            // $dyzur = $radny->getLayer('najblizszy_dyzur');
            // debug( $dyzur ); die();

            $title_for_layout = $radny->getTitle();

            switch ($subaction) {
                case 'view': {

                    // $radny->loadLayer( 'details' );

                    $this->feed(array(
                        'dataset' => 'radni_gmin',
                        'id' => $radny->getId(),
                    ));

                    break;
                }
                case 'wystapienia': {

                    $this->dataobjectsBrowserView(array(
                        'source' => 'radni_gmin.wystapienia:' . $radny->getId(),
                        'dataset' => 'rady_gmin_wystapienia',
                        'noResultsTitle' => 'Brak wystąpień',
                        'hlFields' => array(),
                        'routes' => array(
                            'shortTitle' => 'krakow_posiedzenia_punkty.tytul',
                            'title' => 'krakow_posiedzenia_punkty.tytul',
                        ),
                        'title' => 'Wystąpienia radnego na posiedzeniach rady miasta',
                        'back' => $radny->getUrl(),
                        'backTitle' => 'Profil radnego',
                    ));

                    $title_for_layout .= ' - Wystąpienia na posiedzeniach rady miasta';

                    break;
                }
                case 'glosowania': {

                    $this->dataobjectsBrowserView(array(
                        'source' => 'radni_gmin.glosy:' . $radny->getId(),
                        'dataset' => 'krakow_glosowania_glosy',
                        'noResultsTitle' => 'Brak głosowań',
                        // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),

                        'title' => 'Wyniki głosowań radnego na posiedzeniach rady miasta',
                        'back' => $radny->getUrl(),
                        'backTitle' => 'Profil radnego',
                    ));

                    $title_for_layout .= ' - Wyniki głosowań';

                    break;
                }
                case 'interpelacje': {

                    $this->dataobjectsBrowserView(array(
                        'source' => 'radni_gmin.interpelacje:' . $radny->getId(),
                        'dataset' => 'rady_gmin_interpelacje',
                        'noResultsTitle' => 'Brak interpelacji',
                        // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),

                        'title' => 'Interpelacje radnego',
                        'back' => $radny->getUrl(),
                        'backTitle' => 'Profil radnego',
                    ));

                    $title_for_layout .= ' - Interpelacje';

                    break;
                }
                case 'oswiadczenia': {

                    if ($sub_id) {

                        $oswiadczenie = $this->API->getObject('radni_gmin_oswiadczenia_majatkowe', $sub_id);
                        $document = $this->API->document($oswiadczenie->getData('dokument_id'));
                        $this->set('oswiadczenie', $oswiadczenie);
                        $this->set('document', $document);
                        $this->set('documentPackage', 1);

                    } else {

                        $this->dataobjectsBrowserView(array(
                            'source' => 'radni_gmin.oswiadczenia_majatkowe:' . $radny->getId(),
                            'order' => 'rok desc',
                            'dataset' => 'radni_gmin_oswiadczenia_majatkowe',
                            'noResultsTitle' => 'Brak oświadczeń majątkowych',
                            // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),
                            'title' => 'Oświadczenia majątkowe radnego',
                            'back' => $radny->getUrl(),
                            'backTitle' => 'Profil radnego',
                        ));

                        $title_for_layout .= ' - Oświadczenia majątkowe';

                    }

                    break;
                }
                case 'komisje': {

                    $radny->loadLayer('komisje');
                    break;

                }

                case 'dyzury': {

                    $radny->loadLayer('dyzury');
                    break;

                }

                case 'krs': {

                    $osoba = $this->API->getObject('krs_osoby', $radny->getData('krs_osoba_id'));
                    $osoba->loadLayer('organizacje');
                    $this->set('osoba', $osoba);

                    break;

                }


            }


            $this->set('radny', $radny);
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
            $sub_id = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;

            $komisja = $this->API->getObject('krakow_komisje', $this->request->params['subid'], array(
                'layers' => array('sklad'),
            ));
            // debug( $dyzur ); die();
            $title_for_layout = $komisja->getTitle();

            switch ($subaction) {
                case 'view': {

					$this->feed(array(
                        'dataset' => 'krakow_komisje',
                        'id' => $komisja->getId(),
                    ));
					
                    break;
                }
                case 'posiedzenia': {
					
					if (
                        $sub_id &&
                        ($posiedzenie = $this->API->getObject('krakow_komisje_posiedzenia', $sub_id, array(
                            'layers' => array('punkty')
                        )))
                    ) {

                        // debug( $this->API->document($posiedzenie->getData('przedmiot_dokument_id')) ); die();

                        $punkty = (array) $posiedzenie->getLayer('punkty');
                        if(count($punkty) === 0) $punkty = false;
                        $this->set('punkty', $punkty);

                        if ($posiedzenie->getData('dokument_id'))
                            $this->set('dokument', $this->API->document($posiedzenie->getData('dokument_id')));

                        $this->set('documentPackage', 1);
                        $this->set('posiedzenie', $posiedzenie);
                        $title_for_layout = $posiedzenie->getTitle();
                        $subaction = 'posiedzenie';


                    } else {
						
						$this->dataobjectsBrowserView(array(
	                        'source' => 'krakow_komisje.posiedzenia:' . $komisja->getId(),
	                        'dataset' => 'krakow_komisje_posiedzenia',
	                        'noResultsTitle' => 'Brak posiedzeń',
	                        'excludeFilters' => array(
                                'komisja_id'
                            ),
                            'title' => 'Posiedzenia komisji',
                            'back' => $komisja->getUrl(),
                            'backTitle' => $komisja->getTitle(),
                            'hlFields' => array(),
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
            $this->set('sub_id', $sub_id);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('komisja-' . $subaction);

        } else {

            $params = array(
                'dataset' => 'krakow_komisje',
                'noResultsTitle' => 'Brak komisji dla tej gminy',
                'title' => 'Komisje Rady Miasta',
                'limit' => 100,
                'back' => '/dane/gminy/903,krakow/rada',
                'backTitle' => 'Rada Miasta Kraków',
            );

            $this->dataobjectsBrowserView($params);
            $this->set('title_for_layout', 'Komisje Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }


    public function radni_dzielnic()
    {
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            // 'source'         => 'gminy.radni_dzielnic:' . $this->object->getId(),
            'dataset' => 'radni_dzielnic',
            'title' => 'Radni dzielnic',
            'noResultsTitle' => 'Brak radnych dzielnic dla tej gminy',
            'hlFields' => array('dzielnice.nazwa'),
            'order' => 'radni_dzielnic.nazwisko asc',
        ));
    }


    public function szukaj()
    {
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'gminy.szukaj:' . $this->object->getId(),
            'noResultsTitle' => 'Brak wyników',
            'dataset_dictionary' => array(
                'krakow_posiedzenia_punkty' => array(
                    'href' => 'punkty',
                    'label' => 'Punkty porządku dziennego',
                ),
                'zamowienia_publiczne' => array(
                    'href' => 'zamowienia',
                    'label' => 'Zamówienia publiczne',
                ),
                'rady_gmin_interpelacje' => array(
                    'href' => 'interpelacje',
                    'label' => 'Interpelacje radnych',
                ),
                'rady_druki' => array(
                    'href' => 'druki',
                    'label' => 'Druki',
                ),
                'radni_gmin' => array(
                    'href' => 'radni',
                    'label' => 'Radni',
                ),
                'krakow_posiedzenia' => array(
                    'href' => 'posiedzenia',
                    'label' => 'Posiedzenia Rady Miasta',
                ),
            ),
        ));
    }


    public function darczyncy()
    {
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'dataset' => 'wybory_darczyncy',
            'title' => 'Wpłaty na komitety wyborcze',
            'noResultsTitle' => 'Brak danych',
        ));
    }


    public function wskazniki()
    {
        $this->_prepareView();
        $this->innerSearch('bdl_wskazniki', array(
            'fields' => 'id, dataset, object_id, score, _data_*',
            '_multidata_gmina_id' => $this->object->object_id,
        ), array(
            'searchTitle' => sprintf(__d('dane', 'LC_DANE_WSKAZNIKI_W_GMINIE'), $this->object->getData('nazwa')),
        ));
    }

    public function zamowienia()
    {
	    
	    $this->load();
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

        $this->load();
				
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

        $this->load();
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
	    
	    $this->load();
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

    public function ngo()
    {
        
        $this->load();
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

    public function spzoz()
    {
	    
	    $this->load();
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
        $this->dataobjectsBrowserView(array(
            'source' => 'gminy.dotacje_ue:' . $this->object->getId(),
            'dataset' => 'dotacje_ue',
            'title' => 'Dotacje unijne',
            'noResultsTitle' => 'Brak dotacji dla tej gminy',
            'excludeFilters' => array(
                'gmina_id',
            ),
        ));

        $this->set('title_for_layout', 'Dotacje Unii Europejskiej w gminie ' . $this->object->getData('nazwa'));

    }

    public function urzednicy()
    {

        $this->request->params['action'] = 'urzad';

        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'dataset' => 'krakow_urzednicy',
            'title' => 'Urzędnicy Miasta Kraków',
            'back' => '/dane/gminy/903,krakow/urzad',
            'backTitle' => 'Urząd Miasta Kraków',
        ));

        $this->set('title_for_layout', 'Urzędnicy urzędu miasta ' . $this->object->getData('nazwa'));

    }

    public function jednostki()
    {

        $this->request->params['action'] = 'urzad';

        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'dataset' => 'krakow_jednostki',
            'title' => 'Jednostki administracyjne urzędu Miasta Kraków',
            'back' => '/dane/gminy/903,krakow/urzad',
            'backTitle' => 'Urząd Miasta Kraków',
        ));

        $this->set('title_for_layout', 'Jednostki administracyjne urzędu miasta ' . $this->object->getData('nazwa'));

    }

    public function oswiadczenia()
    {

        $this->request->params['action'] = 'urzad';

        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $oswiadczenie = $this->API->getObject('krakow_oswiadczenia', $this->request->params['subid'], array(// 'layers' => 'neighbours',
            ));
            $this->set('oswiadczenie', $oswiadczenie);
            $document = $this->API->document($oswiadczenie->getData('dokument_id'));
            $this->set('document', $document);
            $this->set('documentPackage', 1);
            $this->set('title_for_layout', $oswiadczenie->getTitle());
            $this->render('oswiadczenie');

        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'krakow_oswiadczenia',
                'title' => 'Oświadczenia majątkowe',
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

    public function finanse()
    {
        $this->addInitLayers(array(
            'finanse'
        ));
        $this->_prepareView();
        $this->request->params['action'] = 'finanse';
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

    public function beforeRender()
    {


        // PREPARE MENU
        $href_base = $this->object->getUrl();

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Gmina',
                ),
            )
        );

        if ($this->object->getId() == '903') {


            $menu['items'][] = array(
                'id' => 'rada',
                'label' => 'Rada Miasta',
                'href' => $href_base . '/rada',
            );

            $menu['items'][] = array(
                'id' => 'urzad',
                'label' => 'Urząd Miasta',
                'href' => $href_base . '/urzad',
            );


            $dzielnice_items = array();
            if ($dzielnice = $this->object->getLayer('dzielnice')) {

                $dzielnice_items[] = array(
                    'id' => 'dzielnice',
                    'label' => 'Lista dzielnic',
                    'href' => $href_base . '/dzielnice'
                );

                $dzielnice_items[] = array(
                    'id' => 'radni_dzielnic',
                    'label' => 'Radni dzielnic',
                    'href' => $href_base . '/radni_dzielnic'
                );

                $dzielnice_items[] = array(
                    'id' => 'dzielnice_uchwaly',
                    'label' => 'Uchwały rad dzielnic',
                    'href' => $href_base . '/dzielnice_uchwaly'
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
                    'dropdown' => array(
                        'items' => $dzielnice_items,
                    ),
                );

            }


        } else {

			/*
            $menu['items'][] = array(
                'id' => 'radni',
                'href' => $href_base . '/radni',
                'label' => 'Radni',
            );
            */

        }
		
		/*
		$menu['items'][] = array(
            'id' => 'finanse',
            'label' => 'Finanse',
            'href' => $href_base . '/finanse',
        );
        */

        $menu['items'][] = array(
            'id' => 'organizacje',
            'label' => 'Organizacje',
            'dropdown' => array(
                'items' => array(
                    array(
                        'id' => 'organizacje',
                        'label' => 'Wszystkie organizacje',
                        'href' => $href_base . '/organizacje',
                    ),
                    array(
                        'topborder' => true,
                        'id' => 'biznes',
                        'label' => 'Biznes',
                        'href' => $href_base . '/biznes',
                    ),
                    array(
                        'id' => 'ngo',
                        'label' => 'Organizacje pozarządowe',
                        'href' => $href_base . '/ngo',
                    ),
                    array(
                        'id' => 'spzoz',
                        'label' => 'Publiczne zakłady opieki zdrowotnej',
                        'href' => $href_base . '/spzoz',
                    ),
                ),
            ),
        );

        /*
        $menu['items'][] = array(
            'id' => 'wskazniki',
            'href' => $href_base . '/wskazniki',
            'label' => 'Wskaźniki GUS',
        );
        */

        $menu['items'][] = array(
            'id' => 'zamowienia',
            'href' => $href_base . '/zamowienia',
            'label' => 'Zamówienia publiczne',
            'icon' => '',
        );

        $menu['items'][] = array(
            'id' => 'wybory',
            'label' => 'Wybory',
            'dropdown' => array(
                'items' => array(
                    array(
                        'id' => 'okregi_wyborcze',
                        'label' => 'Okręgi wyborcze w wyborach samorządowych 2010 r.',
                        'href' => $href_base . '/okregi_wyborcze',
                    )
                ),
            ),
        );
		
		/*
        $menu['items'][] = array(
            'id' => 'miejscowosci',
            'href' => $href_base . '/miejscowosci',
            'label' => 'Miejscowości',
        );
        */


        /*
        $menu['items'][] = array(
            'id' => 'miejscowosci',
            'href' => $href_base . '/miejscowosci',
            'label' => 'Miejscowości',
        );

        $menu['items'][] = array(
            'id' => 'kody',
            'href' => $href_base . '/kody',
            'label' => 'Kody pocztowe',
        );
        */

        if ($this->request->params['action'] == 'szukaj') {

            $menu['items'][] = array(
                'id' => 'szukaj',
                'href' => $href_base . '/szukaj',
                'label' => 'Szukaj',
            );

        }
		
		$this->menu = $menu;
		parent::beforeRender();

    }
}