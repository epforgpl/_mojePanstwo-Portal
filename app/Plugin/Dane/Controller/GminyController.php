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
        
        /*
        if ($this->request->params['id'] == '903') {
            // $_layers[] = 'ostatnie_posiedzenie';
            $_layers[] = 'radni';
        }
        */

        $this->addInitLayers($_layers);
        $this->_prepareView();
		
		if( $this->request->params['id'] == '903' )
			$this->set('title_for_layout', 'Przejrzysty Kraków');
		
        $szef = $this->object->getLayer('szef');
        
		
		
		
		
		/*
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
		*/
		
				
		$this->Components->load('Dane.DataFeed', array(
            'feed' => $this->object->getDataset() . '/' . $this->object->getId(),
            'preset' => $this->object->getDataset(),
            // 'side' => 'gminy-rada',
            'searchTitle' => ( $this->object->getId()==903 ) ? 'Przejrzystym Krakowie' : $this->object->getTitle(),
        ));
		
		
		
		
		
		
        if ($this->object->getId() == 903) {
			
			$this->set('dzielnice', $this->Dataobject->find('all', array(
				'conditions' => array(
					'dataset' => 'dzielnice',
				),
				'limit' => 100,
			)));

            // $this->render('view-krakow');

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
        $this->_prepareView();
		
		$rada = $this->Dataobject->find('first', array(
			'conditions' => array(
				'dataset' => 'rady_gmin',
				'id' => $this->object->getId(),
			),
			'layers' => array('channels', 'subscriptions'),
		));
				
	    $this->Components->load('Dane.DataFeed', array(
            'feed' => 'rady_gmin' . '/' . $this->object->getId(),
            'channel' => 'rada',
            'preset' => $this->object->getDataset(),
            'side' => 'gminy-rada',
            'searchTitle' => 'Radzie Miasta',
            'object_subscriptions' => $rada->getLayer('subscriptions'),
        ));
        
		$this->channels = $rada->getLayer('channels');

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
					'dataset' => 'prawo_lokalne',
					'id' => $this->request->params['subid']
				),
				'layers' => array('neighbours')
			));
			
            $this->set('uchwala', $uchwala);
            $this->set('title_for_layout', $uchwala->getTitle());
            $this->render('rada_uchwala');

        } else {
			
			$this->_prepareView();
	        $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
		            'dataset' => 'prawo_lokalne',
	            ),
	            'aggsPreset' => 'prawo_lokalne',
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
            
            if( 
            	isset( $this->request->params['subaction'] ) && 
            	( $this->request->params['subaction']=='dokumenty' ) && 
            	( $druk_dokument = $this->Dataobject->find('first', array(
	            	'conditions' => array(
		            	'dataset' => 'rady_druki_dokumenty',
		            	'id' => $this->request->params['subsubid'],
	            	),
            	)) )
            ) {
	            
				$this->set('druk_dokument', $druk_dokument);
	            $this->set('title_for_layout', $druk_dokument->getTitle());
				$this->render('druk_dokument');
            
           } elseif( isset($this->request->params['subaction']) && ($this->request->params['subaction']=='tresc') ) {
				
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
                        ( $radny = $this->Dataobject->find('first', array(
	                        'conditions' => array(
		                        'dataset' => 'radni_dzielnic',
		                        'id' => $subsubid,
	                        ),
                        )) )
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
                        ( $posiedzenie = $this->Dataobject->find('first', array(
	                        'conditions' => array(
		                        'dataset' => 'krakow_dzielnice_rady_posiedzenia',
		                        'id' => $subsubid,
	                        ),
                        )) )
                    ) {


                        /* ob_end_clean();
                        var_dump($posiedzenie->getLayer('punkty'));
                        die(); */

                        // debug( $this->API->document($posiedzenie->getData('przedmiot_dokument_id')) ); die();

   

                        $punkty = (array) $posiedzenie->getLayer('punkty');
                        if(count($punkty) === 0) $punkty = false;

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
                        ( $uchwala = $this->Dataobject->find('first', array(
	                        'conditions' => array(
		                        'dataset' => 'krakow_dzielnice_uchwaly',
		                        'id' => $subsubid,
	                        ),
                        )) )
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
			
			
			$layers = array('channels', 'subscriptions', 'neighbours', 'bip_url');
			
			if( $subaction == 'komisje' ) {
				$layers[] = 'komisje';
			} elseif( $subaction == 'dyzury' ) {
				$layers[] = 'dyzury';
			} elseif( $subaction == 'obietnice' ) {
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

                    $this->Components->load('Dane.DataFeed', array(
			            'feed' => $radny->getDataset() . '/' . $radny->getId(),
			            'preset' => $radny->getDataset(),
			            'side' => 'radni_gmin',
			            'object_subscriptions' => $radny->getLayer('subscriptions'),
			        ));
			        
			        $this->loadChannels = true;
					$this->channels = $radny->getLayer('channels');

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
                case 'krs': {
					
                    $this->set('osoba', $this->Dataobject->find('first', array(
	                    'conditions' => array(
		                    'dataset' => 'krs_osoby',
		                    'id' => $radny->getData('krs_osoba_id'),
	                    ),
	                    'layers' => array('organizacje'),
                    )));

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
                        ( $posiedzenie = $this->Dataobject->find('first', array(
	                        'conditions' => array(
		                        'dataset' => 'krakow_komisje_posiedzenia',
		                        'id' => $subsubid,
	                        ),
	                        'layers' => array('punkty')
                        )) ) 
                    ) {

                        // debug( $this->API->document($posiedzenie->getData('przedmiot_dokument_id')) ); die();

                        $punkty = (array) $posiedzenie->getLayer('punkty');
                        if(count($punkty) === 0) $punkty = false;
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

    public function ngo()
    {
        if(isset($this->request->query['export'])) {
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

    public function beforeRender()
    {

        // PREPARE MENU
        $href_base = $this->object->getUrl();

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Aktualności',
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
                    'href' => $href_base . '/dzielnice',
                    /*
                    'dropdown' => array(
                        'items' => $dzielnice_items,
                    ),
                    */
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
		
		if ($this->object->getId() == '903') {
			$menu['items'][] = array(
	            'id' => 'finanse',
	            'href' => $href_base . '/finanse',
	            'label' => 'Finanse',
	            'icon' => '',
	        );
        }
		

		/*
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
        */
		
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

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        if($this->object->getId() == '903') {
            $this->setMeta('og:image', FULL_BASE_URL . '/dane/img/social/przejrzystykrakow.jpg');
        }
    }
}