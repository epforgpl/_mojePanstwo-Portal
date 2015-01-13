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

        $this->API->searchDataset('zamowienia_publiczne', array(
            'limit' => 8,
            'conditions' => array(
                'gmina_id' => $this->object->getId(),
                'status_id' => '0',
            ),
        ));
        $this->set('zamowienia_otwarte', $this->API->getObjects());

        $this->API->searchDataset('zamowienia_publiczne', array(
            'limit' => 8,
            'conditions' => array(
                'gmina_id' => $this->object->getId(),
                'status_id' => '2',
            ),
        ));
        $this->set('zamowienia_zamkniete', $this->API->getObjects());


        $this->API->searchDataset('krs_podmioty', array(
            'limit' => 5,
            'conditions' => array(
                'gmina_id' => $this->object->getId(),
                'forma_prawna_typ_id' => '1',
                'wykreslony' => '0',
            ),
            'order' => 'wartosc_kapital_zakladowy desc'
        ));
        $this->set('organizacje', $this->API->getObjects());

        $this->API->searchDataset('krs_podmioty', array(
            'limit' => 0,
            'conditions' => array(
                'gmina_id' => $this->object->getId(),
                'forma_prawna_typ_id' => '2',
                'wykreslony' => '0',
            ),
            'facets' => 1,
        ));

        $data = $this->API->getFacets();

        $ngos = array();

        foreach ($data as $d) {
            if ($d['field'] == 'krs_podmioty.forma_prawna_id') {
                $ngos = $d['params']['options'];
                break;
            }
        }
        unset($data);
        $this->set('ngos', $ngos);


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

            $this->API->searchDataset('prawo_lokalne', array(
                'limit' => 3,
                'conditions' => array(
                    'gmina_id' => $this->object->getId(),
                ),
            ));
            $this->set('prawo_lokalne', $this->API->getObjects());

            $this->API->searchDataset('krakow_zarzadzenia', array(
                'limit' => 3,
            ));
            $this->set('zarzadzenia', $this->API->getObjects());

            $this->API->searchDataset('dzielnice', array(
                'limit' => 100,
                'conditions' => array(
                    'gmina_id' => $this->object->getId(),
                ),
            ));
            $this->set('dzielnice', $this->API->getObjects());

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

        parent::view();

        $this->prepareFeed(array(
            'perPage' => 20,
            'channel' => 'rada',
        ));

        $this->set('title_for_layout', 'Rada Miasta Krakowa');
    }

    public function urzad()
    {


        // $this->addInitLayers( $_layers );

        parent::view();

        $this->prepareFeed(array(
            'perPage' => 20,
            'channel' => 'urzad',
        ));

        $this->set('title_for_layout', 'Urząd Miasta Krakowa');

    }

    public function okregi_wyborcze()
    {


        $this->_prepareView();
        $this->request->params['action'] = 'wybory';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $okreg = $this->API->getObject('gminy_okregi_wyborcze', $this->request->params['pass'][0], array(
                'layers' => array('kandydaci'),
            ));

            $this->set('okreg', $okreg);
            $this->set('title_for_layout', $okreg->getTitle());
            $this->render('okreg_wyborczy');


        } else {

            $this->dataobjectsBrowserView(array(
                'source' => 'gminy.okregi_wyborcze:' . $this->object->getId(),
                'dataset' => 'gminy_okregi_wyborcze',
                'title' => 'Okręgi wyborcze w wyborach samorządowych 2010 r.',
                'noResultsTitle' => 'Brak okręgów',
                'routes' => array(
                    'label' => false,
                ),
            ));
            $this->set('title_for_layout', 'Okręgi wyborcze w gminie ' . $this->object->getData('nazwa'));

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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $interpelacja = $this->API->getObject('rady_gmin_interpelacje', $this->request->params['pass'][0], array(
                'layers' => array('neighbours'),
            ));
            $document = $this->API->document($interpelacja->getData('dokument_id'));
            $this->set('interpelacja', $interpelacja);
            $this->set('document', $document);
            $this->set('documentPackage', 1);
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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $subaction = (isset($this->request->params['pass'][1]) && $this->request->params['pass'][1]) ? $this->request->params['pass'][1] : 'view';
            $sub_id = (isset($this->request->params['pass'][2]) && $this->request->params['pass'][2]) ? $this->request->params['pass'][2] : false;


            $posiedzenie = $this->API->getObject('krakow_posiedzenia', $this->request->params['pass'][0], array(
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
                            'href' => '/dane/gminy/903/posiedzenia/' . $this->request->params['pass'][0] . '/punkty',
                            'label' => 'Punkty porządku dziennego',
                        ),
                    ),
                ),
            );
            */


            $render_view = 'punkty';
            $subaction = 'punkty';

            switch ($subaction) {

                case "punkty": {

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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $debata = $this->API->getObject('krakow_posiedzenia_punkty', $this->request->params['pass'][0], array(
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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $uchwala = $this->API->getObject('prawo_lokalne', $this->request->params['pass'][0], array(
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
        $this->_prepareView();
        $this->request->params['action'] = 'urzad';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $akt = $this->API->getObject('krakow_zarzadzenia', $this->request->params['pass'][0], array(// 'layers' => array( 'neighbours' ),
            ));
            $document = $this->API->document($akt->getData('dokument_id'));
            $this->set('akt', $akt);
            $this->set('document', $document);
            $this->set('documentPackage', 1);
            $this->set('title_for_layout', $akt->getTitle());

            $this->render('zarzadzenie');

        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'krakow_zarzadzenia',
                'title' => 'Zarządzenia Prezydenta Krakowa',
                'noResultsTitle' => 'Brak danych',
                // 'hlFields' => $hl_fields = array('numer', 'liczba_debat'),
                'back' => '/dane/gminy/903,krakow/urzad',
                'backTitle' => 'Urząd Miasta Krakowa',
            ));
            $this->set('title_for_layout', 'Zarządzenia Prezydenta Krakowa');

        }
    }


    public function druki()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $druk = $this->API->getObject('rady_druki', $this->request->params['pass'][0], array(
                'layers' => 'neighbours',
            ));
            $document = $this->API->document($druk->getData('dokument_id'));
            $this->set('druk', $druk);
            $this->set('document', $document);
            $this->set('documentPackage', 1);
            $this->set('title_for_layout', $druk->getTitle());

            $this->render('druk');

        } else {

            $this->dataobjectsBrowserView(array(
                'dataset' => 'rady_druki',
                'title' => 'Materiały na posiedzenia rady miasta',
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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $subaction = (isset($this->request->params['pass'][1]) && $this->request->params['pass'][1]) ? $this->request->params['pass'][1] : 'view';
            $sub_id = (isset($this->request->params['pass'][2]) && $this->request->params['pass'][2]) ? $this->request->params['pass'][2] : false;

            $dzielnica = $this->API->getObject('dzielnice', $this->request->params['pass'][0], array(// 'layers' => array('najblizszy_dyzur', 'neighbours'),
            ));

            // $radny->getLayer('neighbours');
            // $dyzur = $radny->getLayer('najblizszy_dyzur');
            // debug( $dzielnica ); die();
            $title_for_layout = $dzielnica->getTitle();

            switch ($subaction) {

                case 'view': {

                    $this->prepareFeed(array(
                        'perPage' => 20,
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
                        ($posiedzenie = $this->API->getObject('krakow_dzielnice_rady_posiedzenia', $sub_id))
                    ) {

                        // debug( $this->API->document($posiedzenie->getData('przedmiot_dokument_id')) ); die();

                        if ($posiedzenie->getData('protokol_dokument_id'))
                            $this->set('protokol_dokument', $this->API->document($posiedzenie->getData('protokol_dokument_id')));

                        if ($posiedzenie->getData('przedmiot_dokument_id'))
                            $this->set('przedmiot_dokument', $this->API->document($posiedzenie->getData('przedmiot_dokument_id')));

                        $this->set('documentPackage', 1);
                        $this->set('posiedzenie', $posiedzenie);
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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $uchwala = $this->API->getObject('krakow_dzielnice_uchwaly', $this->request->params['pass'][0], array(// 'layers' => 'neighbours',
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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $posiedzenie = $this->API->getObject('krakow_komisje_posiedzenia', $this->request->params['pass'][0], array(
                'layers' => 'neighbours',
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

    /*
    public function radni() {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if ( isset( $this->request->params['pass'][0] ) && is_numeric( $this->request->params['pass'][0] ) ) {

            $subaction = ( isset( $this->request->params['pass'][1] ) && $this->request->params['pass'][1] ) ? $this->request->params['pass'][1] : 'view';
            $sub_id    = ( isset( $this->request->params['pass'][2] ) && $this->request->params['pass'][2] ) ? $this->request->params['pass'][2] : false;

            $radny = $this->API->getObject( 'radni_gmin', $this->request->params['pass'][0], array(
                'layers' => array('neighbours', 'bip_url'),
                // 'layers' => array( 'najblizszy_dyzur', 'komisje', 'neighbours', 'bip_url' ),
            ) );


            // $radny->getLayer( 'neighbours' );
            $dyzur = $radny->getLayer( 'najblizszy_dyzur' );
            // debug( $dyzur ); die();

            $title_for_layout = $radny->getTitle();

            switch ( $subaction ) {
                case 'view': {

                    // $radny->loadLayer( 'details' );

                    $this->prepareFeed(array(
                        'perPage' => 20,
                        'dataset' => 'radni_gmin',
                        'id' => $radny->getId(),
                    ));

                    break;
                }
                case 'wystapienia': {

                    $this->dataobjectsBrowserView( array(
                        'source'         => 'radni_gmin.wystapienia:' . $radny->getId(),
                        'dataset'        => 'rady_gmin_wystapienia',
                        'noResultsTitle' => 'Brak wystąpień',
                        'hlFields' => array(),
                        'routes' => array(
                            'shortTitle' => 'krakow_posiedzenia_punkty.tytul',
                            'title' => 'krakow_posiedzenia_punkty.tytul',
                        ),
                        'title' => 'Wystąpienia radnego na posiedzeniach rady miasta',
                        'back' => $radny->getUrl(),
                        'backTitle' => 'Profil radnego',
                    ) );

                    $title_for_layout .= ' - Wystąpienia na posiedzeniach rady miasta';

                    break;
                }
                case 'glosowania': {

                    $this->dataobjectsBrowserView( array(
                        'source'         => 'radni_gmin.glosy:' . $radny->getId(),
                        'dataset'        => 'krakow_glosowania_glosy',
                        'noResultsTitle' => 'Brak głosowań',
                        // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),

                        'title' => 'Wyniki głosowań radnego na posiedzeniach rady miasta',
                        'back' => $radny->getUrl(),
                        'backTitle' => 'Profil radnego',
                    ) );

                    $title_for_layout .= ' - Wyniki głosowań';

                    break;
                }
                case 'interpelacje': {

                    $this->dataobjectsBrowserView( array(
                        'source'         => 'radni_gmin.interpelacje:' . $radny->getId(),
                        'dataset'        => 'rady_gmin_interpelacje',
                        'noResultsTitle' => 'Brak interpelacji',
                        // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),

                        'title' => 'Interpelacje radnego',
                        'back' => $radny->getUrl(),
                        'backTitle' => 'Profil radnego',
                    ) );

                    $title_for_layout .= ' - Interpelacje';

                    break;
                }
                case 'oswiadczenia': {

                    if ( $sub_id ) {

                        $oswiadczenie = $this->API->getObject( 'radni_gmin_oswiadczenia_majatkowe', $sub_id );
                        $document     = $this->API->document( $oswiadczenie->getData( 'dokument_id' ) );
                        $this->set( 'oswiadczenie', $oswiadczenie );
                        $this->set( 'document', $document );
                        $this->set( 'documentPackage', 1 );

                    } else {

                        $this->dataobjectsBrowserView( array(
                            'source'         => 'radni_gmin.oswiadczenia_majatkowe:' . $radny->getId(),
                            'dataset'        => 'radni_gmin_oswiadczenia_majatkowe',
                            'noResultsTitle' => 'Brak oświadczeń majątkowych',
                            // 'hlFields' => array('dzielnice.nazwa', 'liczba_glosow'),
                            'title' => 'Oświadczenia majątkowe radnego',
                            'back' => $radny->getUrl(),
                            'backTitle' => 'Profil radnego',
                        ) );

                        $title_for_layout .= ' - Oświadczenia majątkowe';

                    }

                    break;
                }
                case 'komisje': {

                    $radny->loadLayer( 'komisje' );
                    break;

                }

                case 'dyzury': {

                    $radny->loadLayer( 'dyzury' );
                    break;

                }

                case 'krs': {

                    $osoba = $this->API->getObject( 'krs_osoby', $radny->getData( 'krs_osoba_id' ) );
                    $osoba->loadLayer( 'organizacje' );
                    $this->set( 'osoba', $osoba );

                    break;

                }


            }




            $this->set( 'radny', $radny );
            $this->set( 'sub_id', $sub_id );
            $this->set( 'title_for_layout', $title_for_layout );
            $this->render( 'radny-' . $subaction );

        } else {

            $params = array(
                'source'         => 'gminy.radni7:' . $this->object->getId(),
                'dataset'        => 'radni_gmin',
                'noResultsTitle' => 'Brak radnych dla tej gminy',
                'excludeFilters' => array(
                    'gmina_id',
                    'gminy.powiat_id',
                    'gminy.wojewodztwo_id'
                ),
                'hlFields'       => array( 'komitet' ),
                'limit'          => 100,
            );

            $this->set('title_for_layout', 'Uchwały rad dzielnic w gminie ' . $this->object->getData('nazwa'));

        }
    }
    */

    /*
    public function komisje_posiedzenia()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $posiedzenie = $this->API->getObject('krakow_komisje_posiedzenia', $this->request->params['pass'][0], array(
                'layers' => 'neighbours',
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
            ));

            $this->set('title_for_layout', 'Posiedzenia komisji Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }
    */

    /*
    public function radni_powiazania()
    {

        $this->addInitLayers('radni_powiazania');

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        $this->set('title_for_layout', 'Powiązania radnych gminy  ' . $this->object->getData('nazwa') . ' z organizacjami w Krajowym Rejestrze Sądowym');
    }
    */

    /*
    public function urzednicy_powiazania()
    {

        $this->addInitLayers('urzednicy_powiazania');

        $this->_prepareView();
        $this->request->params['action'] = 'urzednicy_powiazania';

        $this->set('title_for_layout', 'Powiązania urzędników gminy  ' . $this->object->getData('nazwa') . ' z organizacjami w Krajowym Rejestrze Sądowym');
    }
    */

    /*
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
    */

    public function radni()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $subaction = (isset($this->request->params['pass'][1]) && $this->request->params['pass'][1]) ? $this->request->params['pass'][1] : 'view';
            $sub_id = (isset($this->request->params['pass'][2]) && $this->request->params['pass'][2]) ? $this->request->params['pass'][2] : false;

            $radny = $this->API->getObject('radni_gmin', $this->request->params['pass'][0], array(
                'layers' => array('neighbours', 'bip_url'),
                // 'layers' => array( 'najblizszy_dyzur', 'komisje', 'neighbours', 'bip_url' ),
            ));


            // $radny->getLayer( 'neighbours' );
            $dyzur = $radny->getLayer('najblizszy_dyzur');
            // debug( $dyzur ); die();

            $title_for_layout = $radny->getTitle();

            switch ($subaction) {
                case 'view': {

                    // $radny->loadLayer( 'details' );

                    $this->prepareFeed(array(
                        'perPage' => 20,
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
            $this->set('sub_id', $sub_id);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('radny-' . $subaction);

        } else {

            $params = array(
                'source' => 'gminy.radni7:' . $this->object->getId(),
                'dataset' => 'radni_gmin',
                'noResultsTitle' => 'Brak radnych dla tej gminy',
                'excludeFilters' => array(
                    'gmina_id',
                    'gminy.powiat_id',
                    'gminy.wojewodztwo_id'
                ),
                'hlFields' => array('komitet'),
                'limit' => 100,
            );

            if ($this->object->getData('id') == '903') {
                $params['title'] = 'Radni miasta';
                $params['back'] = $this->object->getUrl() . '/rada';
                $params['backTitle'] = 'Rada Miasta Krakowa';
            }

            $this->dataobjectsBrowserView($params);
            $this->set('title_for_layout', 'Radni gminy ' . $this->object->getData('nazwa'));

        }
    }

    public function komisje()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $subaction = (isset($this->request->params['pass'][1]) && $this->request->params['pass'][1]) ? $this->request->params['pass'][1] : 'view';
            $sub_id = (isset($this->request->params['pass'][2]) && $this->request->params['pass'][2]) ? $this->request->params['pass'][2] : false;

            $komisja = $this->API->getObject('krakow_komisje', $this->request->params['pass'][0], array(
                'layers' => array('sklad'),
            ));
            // debug( $dyzur ); die();
            $title_for_layout = $komisja->getTitle();

            switch ($subaction) {
                case 'view': {


                    break;
                }
                case 'posiedzenia': {

                    $this->dataobjectsBrowserView(array(
                        'source' => 'krakow_komisje.posiedzenia:' . $komisja->getId(),
                        'dataset' => 'krakow_komisje_posiedzenia',
                        'noResultsTitle' => 'Brak posiedzeń',
                        'hlFields' => array(),
                    ));

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
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'gminy.zamowienia_publiczne:' . $this->object->getId(),
            'dataset' => 'zamowienia_publiczne',
            'noResultsTitle' => 'Brak zamówień dla tej gminy',
            'excludeFilters' => array(
                'gmina_id',
            ),
        ));

        $this->set('title_for_layout', 'Zamówienia publiczne w gminie ' . $this->object->getData('nazwa'));
    }

    public function miejscowosci()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'miejscowosci';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $miejscowosc = $this->API->getObject('miejscowosci', $this->request->params['pass'][0], array(// 'layers' => 'neighbours',
            ));
            $this->set('miejscowosc', $miejscowosc);
            $this->set('title_for_layout', $miejscowosc->getTitle() . ' w gminie ' . $this->object->getTitle());
            $this->render('miejscowosc');

        } else {

            $this->dataobjectsBrowserView(array(
                'source' => 'gminy.miejscowosci:' . $this->object->getId(),
                'dataset' => 'miejscowosci',
                'noResultsTitle' => 'Brak miejscowości',
                'excludeFilters' => array(
                    'gmina_id'
                ),
                'hlFields' => array(),
            ));
            $this->set('title_for_layout', 'Miejscowości w gminie ' . $this->object->getData('nazwa'));

        }

    }

    public function organizacje()
    {
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'gminy.organizacje:' . $this->object->getId(),
            'dataset' => 'krs_podmioty',
            'noResultsTitle' => 'Brak organizacji w tej gminie',
            'excludeFilters' => array(
                'gmina_id',
            ),
        ));
        $this->set('title_for_layout', 'Organizacje w gminie ' . $this->object->getData('nazwa'));
    }

    public function biznes()
    {
        $this->request->params['action'] = 'biznes';
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'gminy.biznes:' . $this->object->getId(),
            'dataset' => 'krs_podmioty',
            'title' => 'Organizacje biznesowe',
            'noResultsTitle' => 'Brak organizacji biznesowych w tej gminie',
            'excludeFilters' => array(
                'gmina_id',
                'forma_prawna_typ_id'
            ),
        ));
        $this->set('title_for_layout', 'Organizacje biznesowe w gminie ' . $this->object->getData('nazwa'));
    }

    public function ngo()
    {
        $this->request->params['action'] = 'ngo';
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'gminy.ngo:' . $this->object->getId(),
            'dataset' => 'krs_podmioty',
            'title' => 'Organizacje pozarządowe',
            'noResultsTitle' => 'Brak organizacji pozarządowych w tej gminie',
            'excludeFilters' => array(
                'gmina_id',
                'forma_prawna_typ_id'
            ),
        ));
        $this->set('title_for_layout', 'Organizacje pozarządowe w gminie ' . $this->object->getData('nazwa'));
    }

    public function spzoz()
    {
        $this->request->params['action'] = 'spzoz';
        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'gminy.spzoz:' . $this->object->getId(),
            'dataset' => 'krs_podmioty',
            'title' => 'Publiczne zakłady opieki zdrowotnej',
            'noResultsTitle' => 'Brak publicznych zakładów opieki zdrowotnej w tej gminie',
            'excludeFilters' => array(
                'gmina_id',
                'forma_prawna_typ_id',
                'forma_prawna_id'
            ),
        ));
        $this->set('title_for_layout', 'Samodzielne Publiczne Zakłady Opieki Zdrowotnej w gminie ' . $this->object->getData('nazwa'));
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

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $oswiadczenie = $this->API->getObject('krakow_oswiadczenia', $this->request->params['pass'][0], array(// 'layers' => 'neighbours',
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

            $menu['items'][] = array(
                'id' => 'radni',
                'href' => $href_base . '/radni',
                'label' => 'Radni',
            );

        }

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

        $menu['items'][] = array(
            'id' => 'miejscowosci',
            'href' => $href_base . '/miejscowosci',
            'label' => 'Miejscowości',
        );


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

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];

        $this->set('_menu', $menu);

    }
}