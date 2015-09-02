<?php

App::uses('DataobjectsController', 'Dane.Controller');

class GminyController extends DataobjectsController
{

    public $observeOptions = true;
    public $addDatasetBreadcrumb = false;

    public $submenus = array(
        'rada' => array(
            'items' => array(
                array(
                    'id' => 'rada',
                    'label' => 'Radni',
                ),
                array(
                    'id' => 'posiedzenia',
                    'label' => 'Posiedzenia',
                ),
                array(
                    'id' => 'interpelacje',
                    'label' => 'Interpelacje',
                ),
                array(
                    'id' => 'druki',
                    'label' => 'Projekty legislacyjne',
                ),
                array(
                    'id' => 'rada_uchwaly',
                    'label' => 'Uchwały',
                ),
                array(
                    'id' => 'komisje',
                    'label' => 'Komisje',
                ),
                array(
                    'id' => 'komisje_posiedzenia',
                    'label' => 'Posiedzenia komisji',
                ),
                array(
                    'id' => 'radni_powiazania',
                    'label' => 'Radni w KRS',
                ),
                array(
                    'id' => 'darczyncy',
                    'label' => 'Darczyńcy',
                ),
                array(
                    'id' => 'okregi',
                    'label' => 'Okręgi wyborcze',
                ),
            ),
        ),
        'urzad' => array(
            'items' => array(
                array(
                    'id' => 'urzad',
                    'label' => 'Urząd',
                ),
                array(
                    'id' => 'zarzadzenia',
                    'label' => 'Zarządzenia Prezydenta',
                ),
                array(
                    'id' => 'umowy',
                    'label' => 'Umowy',
                ),
                array(
                    'id' => 'pomoc_publiczna',
                    'label' => 'Pomoc publiczna',
                ),
                array(
                    'id' => 'urzad_zamowienia',
                    'label' => 'Zamówienia publiczne',
                ),
                array(
                    'id' => 'jednostki',
                    'label' => 'Jednostki i Wydziały',
                ),
                array(
                    'id' => 'urzednicy',
                    'label' => 'Urzędnicy',
                ),
                array(
                    'id' => 'urzednicy_powiazania',
                    'label' => 'Urzędnicy w KRS',
                ),
            ),
        ),
        'organizacje' => array(
            'items' => array(
                array(
                    'id' => 'organizacje',
                    'label' => 'Wszystkie organizacje',
                ),
                array(
                    'id' => 'ngo',
                    'label' => 'Organizacje pozarządowe',
                ),
                array(
                    'id' => 'biznes',
                    'label' => 'Biznes',
                ),
                array(
                    'id' => 'spzoz',
                    'label' => 'SPZOZ',
                ),
                array(
                    'id' => 'osoby',
                    'label' => 'Osoby',
                ),
            ),
        ),
        'komisje' => array(
            'items' => array(
                array(
                    'label' => 'Komisja',
                    'id' => '',
                ),
                array(
                    'id' => 'posiedzenia',
                    'label' => 'Posiedzenia',
                ),
            ),
        ),
        'dzielnice' => array(
            'items' => array(
                array(
                    'label' => 'Dzielnica',
                    'id' => '',
                ),
                array(
                    'id' => 'rada_posiedzenia',
                    'label' => 'Posiedzenia',
                ),
                array(
                    'id' => 'rada_uchwaly',
                    'label' => 'Uchwały',
                ),
            ),
        ),
    );

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

        if (
            ($this->request->params['id'] == '903') &&
            isset($this->request->query['q']) &&
            $this->request->query['q']
        ) {


            $aggs = array(
                'osoby' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krs_osoby',
                                    ),
                                ),
                                array(
                                    'term' => array(
                                        'data.krs_osoby.gmina_id' => $this->object->getId(),
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
                            ),
                        ),
                    ),
                ),
                'organizacje' => array(
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
                                        'data.krs_podmioty.gmina_id' => $this->object->getId(),
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
                            ),
                        ),
                    ),
                ),
                'pomoc_publiczna' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_pomoc_publiczna',
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
                            ),
                        ),
                    ),
                ),
                'radni_gminy' => array(
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
                            ),
                        ),
                    ),
                    'aggs' => array(
                        'top' => array(
                            'top_hits' => array(
                                'fielddata_fields' => array('dataset', 'id'),
                                'size' => 3,
                            ),
                        ),
                    ),
                ),
                'rady_gmin_interpelacje' => array(
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
                                'fielddata_fields' => array('dataset', 'id'),
                                'size' => 3,
                            ),
                        ),
                    ),
                ),
                'rady_druki' => array(
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
                                'fielddata_fields' => array('dataset', 'id'),
                                'size' => 3,
                            ),
                        ),
                    ),
                ),
                'krakow_rada_uchwaly' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_rada_uchwaly',
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
                            ),
                        ),
                    ),
                ),
                'darczyncy' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_darczyncy',
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
                            ),
                        ),
                    ),
                ),
                'krakow_komisje' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_komisje',
                                    ),
                                ),
                                array(
                                    'term' => array(
                                        'data.krakow_komisje.kadencja_id' => '7',
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
                            ),
                        ),
                    ),
                ),
                'krakow_zarzadzenia' => array(
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
                                'fielddata_fields' => array('dataset', 'id'),
                                'size' => 3,
                            ),
                        ),
                    ),
                ),
                'krakow_umowy' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_umowy',
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
                            ),
                        ),
                    ),
                ),
                'krakow_jednostki' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_jednostki',
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
                            ),
                        ),
                    ),
                ),
                'krakow_urzednicy' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_urzednicy',
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
                            ),
                        ),
                    ),
                ),
                'dzielnice' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'dzielnice',
                                    ),
                                ),
                                array(
                                    'term' => array(
                                        'data.dzielnice.gmina_id' => $this->object->getId(),
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
                            ),
                        ),
                    ),
                ),
                'zamowienia_publiczne' => array(
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
                                        'data.zamowienia_publiczne.gmina_id' => $this->object->getId(),
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
                            ),
                        ),
                    ),
                ),
                'urzad_zamowienia' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_zamowienia_publiczne',
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
                            ),
                        ),
                    ),
                ),
            );

            $options = array(
                'searchTitle' => 'Szukaj powiązań w Krakowie...',
                'conditions' => array(
                    'dataset' => array('krakow_pomoc_publiczna', 'krs_osoby', 'krakow_darczyncy', 'radni_gmin', 'rady_gmin_interpelacje', 'rady_druki', 'krakow_rada_uchwaly', 'krakow_komisje', 'krakow_zarzadzenia', 'krakow_umowy', 'krakow_jednostki', 'krakow_urzednicy', 'dzielnice', 'zamowienia_publiczne', 'krs_podmioty', 'krakow_zamowienia_publiczne'),
                ),
                'cover' => array(
                    'view' => array(
                        'plugin' => 'Dane',
                        'element' => 'gminy/powiazania-cover',
                    ),
                    'force' => true,
                    'aggs' => $aggs,
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

            $this->set('aggs_dictionary', array(
                'osoby' => array(
                    'title' => 'Osoby w Krajowym Rejestrze Sądowym dla Krakowa',
                    'href' => $this->object->getUrl() . '/osoby'
                ),
                'organizacje' => array(
                    'title' => 'Organizacje w Krajowym Rejestrze Sądowym dla Krakowa',
                    'href' => $this->object->getUrl() . '/organizacje'
                ),
                'pomoc_publiczna' => array(
                    'title' => 'Pomoc publiczna udzielona przez urząd gminy Kraków',
                    'href' => $this->object->getUrl() . '/pomoc_publiczna'
                ),
                'darczyncy' => array(
                    'title' => 'Darczyńcy komitetów wyborczych',
                    'href' => $this->object->getUrl() . '/darczyncy'
                ),
                'radni_gminy' => array(
                    'title' => 'Radni Miasta Kraków',
                    'href' => $this->object->getUrl() . '/rada'
                ),
                'rady_gmin_interpelacje' => array(
                    'title' => 'Interpelacje radnych',
                    'href' => $this->object->getUrl() . '/interpelacje'
                ),
                'rady_druki' => array(
                    'title' => 'Projekty legislacyjne',
                    'href' => $this->object->getUrl() . '/druki'
                ),
                'krakow_rada_uchwaly' => array(
                    'title' => 'Uchwały Rady Miasta',
                    'href' => $this->object->getUrl() . '/rada_uchwaly',
                ),
                'krakow_komisje' => array(
                    'title' => 'Komisje Rady Miasta',
                    'href' => $this->object->getUrl() . '/komisje',
                ),
                'krakow_zarzadzenia' => array(
                    'title' => 'Zarządzenia Prezydenta Miasta',
                    'href' => $this->object->getUrl() . '/zarzadzenia',
                ),
                'krakow_umowy' => array(
                    'title' => 'Umowy zawierane przez Urząd Miasta Kraków',
                    'href' => $this->object->getUrl() . '/umowy',
                ),
                'krakow_jednostki' => array(
                    'title' => 'Jednostki i wydziały Urzędu Miasta Kraków',
                    'href' => $this->object->getUrl() . '/jednostki',
                ),
                'krakow_urzednicy' => array(
                    'title' => 'Urzędnicy Urzędu Miasta Kraków',
                    'href' => $this->object->getUrl() . '/urzednicy',
                ),
                'dzielnice' => array(
                    'title' => 'Dzielnice Miasta Kraków',
                    'href' => $this->object->getUrl() . '/dzielnice',
                ),
                'zamowienia_publiczne' => array(
                    'title' => 'Zamówienia publiczne w Krakowie',
                    'href' => $this->object->getUrl() . '/zamowienia',
                ),
                'urzad_zamowienia' => array(
                    'title' => 'Zamówienia publiczne Urzędu Miasta Kraków',
                    'href' => $this->object->getUrl() . '/urzad_zamowienia',
                ),
            ));
            $this->Components->load('Dane.DataBrowser', $options);


        } else {

            $global_aggs = array(
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
                    'scope' => 'global',
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

            if ($this->object->getId() == 903) {

                $global_aggs['rada_posiedzenia'] = array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_posiedzenia',
                                    ),
                                ),
                                array(
                                    'range' => array(
                                        'date' => array(
                                            'lte' => 'now',
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
                                'size' => 1,
                                'fielddata_fields' => array('dataset', 'id'),
                                'sort' => array(
                                    'date' => 'desc',
                                ),
                            ),
                        ),
                    ),
                );

                $global_aggs['rada_komisje_posiedzenia'] = array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_komisje_posiedzenia',
                                    ),
                                ),
                            ),
                            'must_not' => array(
                                array(
                                    'term' => array(
                                        'data.krakow_komisje_posiedzenia.yt_video_id' => '',
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
                );

                $global_aggs['dzielnice_posiedzenia'] = array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_dzielnice_rady_posiedzenia',
                                    ),
                                ),
                            ),
                            'must_not' => array(
                                array(
                                    'term' => array(
                                        'data.krakow_dzielnice_rady_posiedzenia.yt_video_id' => '',
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
                    'scope' => 'global',
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
                    'scope' => 'global',
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
                    'scope' => 'global',
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

                $global_aggs['krakow_rada_uchwaly'] = array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_rada_uchwaly',
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
                                    'date' => 'desc',
                                ),
                            ),
                        ),
                    ),
                );


            } else {

                $global_aggs['prawo'] = array(
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
                            ),
                        ),
                    ),
                );

            }

            $options = array(
                'searchTitle' => 'Szukaj w gminie ' . $this->object->getTitle() . '...',
                'conditions' => array(
                    '_object' => 'gminy.' . $this->object->getId(),
                ),
                'cover' => array(
                    'view' => array(
                        'plugin' => 'Dane',
                        'element' => 'gminy/cover',
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

    }

    public function _prepareView()
    {

        if ($this->request->action != 'view')
            $this->addInitAggs(array(
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
                    'scope' => 'global',
                ),
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
                    'scope' => 'global',
                ),
            ));

        if ($this->params->id == 903)
            $this->addInitLayers(array('dzielnice'));

        if ($this->domainMode == 'PK')
            $this->_layout['header']['element'] = 'pk';

        if (
            defined('PORTAL_DOMAIN') &&
            defined('PK_DOMAIN') &&
            ($pieces = parse_url(Router::url($this->here, true))) &&
            ($pieces['host'] == PK_DOMAIN)
        ) {

            if ($this->params->id != 903) {

                $this->redirect($this->protocol . PORTAL_DOMAIN . $this->port . $_SERVER['REQUEST_URI']);
                die();

            }

        }

        return parent::_prepareView();

    }

    public function powiazania()
    {

        $this->_prepareView();

        $aggs = array();

        if (isset($this->request->query['q'])) {
            $aggs = array(
                'osoby' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krs_osoby',
                                    ),
                                ),
                                array(
                                    'term' => array(
                                        'data.krs_osoby.gmina_id' => $this->object->getId(),
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
                            ),
                        ),
                    ),
                ),
                'pomoc_publiczna' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_pomoc_publiczna',
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
                            ),
                        ),
                    ),
                ),
                'darczyncy' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_darczyncy',
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
                            ),
                        ),
                    ),
                ),
            );
        }

        $options = array(
            'searchTitle' => 'Szukaj powiązań w Krakowie...',
            'conditions' => array(
                'dataset' => array('krakow_pomoc_publiczna', 'krs_osoby', 'krakow_darczyncy'),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'gminy/powiazania-cover',
                ),
                'force' => true,
                'aggs' => $aggs,
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

        $this->set('aggs_dictionary', array(
            'osoby' => array(
                'title' => 'Osoby w Krajowym Rejestrze Sądowym dla Krakowa',
                'href' => $this->object->getUrl() . '/osoby'
            ),
            'pomoc_publiczna' => array(
                'title' => 'Pomoc publiczna udzielona przez urząd gminy Kraków',
                'href' => $this->object->getUrl() . '/pomoc_publiczna'
            ),
            'darczyncy' => array(
                'title' => 'Darczyńcy komitetów wyborczych',
                'href' => $this->object->getUrl() . '/darczyncy'
            ),
        ));
        $this->Components->load('Dane.DataBrowser', $options);

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

        if ($this->object->getId() == 903) {

            $global_aggs['radni'] = array(
                'filter' => array(
                    'match_all' => '_empty',
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'size' => 100,
                            'fielddata_fields' => array('dataset', 'id'),
                            'sort' => array(
                                'data.radni_gmin.funkcja_id' => 'desc',
                                'data.radni_gmin.nazwisko' => 'asc',
                            ),
                        ),
                    ),
                ),
            );

        }

        $options = array(
            'searchTitle' => 'Szukaj radnego gminy ' . $this->object->getTitle() . '...',
            'conditions' => array(
                'dataset' => 'radni_gmin',
                'radni_gmin.gmina_id' => '903',
                'radni_gmin.aktywny' => '1',
                'radni_gmin.kadencja_id' => '7',
            ),
            'cover' => array(
	            'force' => true,
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'gminy/radni-cover',
                ),
                'aggs' => $global_aggs,
            ),
            'aggsPreset' => 'radni_gmin',
        );

        $this->set('_submenu', array_merge($this->submenus['rada'], array(
            'selected' => 'rada',
        )));

        $this->Components->load('Dane.DataBrowser', $options);
        $this->set('title_for_layout', 'Rada Miasta Krakowa');

    }


    public function urzad()
    {

        $this->_prepareView();

        $global_aggs = array();

        if ($this->object->getId() == 903) {

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
                'scope' => 'global',
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

        $options = array(
            'searchTitle' => 'Szukaj w urzędzie miasta ' . $this->object->getTitle() . '...',
            'conditions' => array(
                'dataset' => 'radni_gmin',
                'radni_gmin.gmina_id' => '903',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'gminy/urzad-cover',
                ),
                'aggs' => $global_aggs,
            ),
        );

        $this->set('_submenu', array_merge($this->submenus['urzad'], array(
            'selected' => 'urzad',
        )));

        $this->Components->load('Dane.DataBrowser', $options);
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
                'searchTitle' => 'Szukaj w interpelacjach...',
            ));

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'interpelacje',
            )));
            $this->set('title_for_layout', 'Interpelacje radnych Miasta ' . $this->object->getData('nazwa'));

        }

    }

    public function darczyncy()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krakow_darczyncy',
            ),
            'aggsPreset' => 'krakow_darczyncy',
        ));

        $this->set('_submenu', array_merge($this->submenus['rada'], array(
            'selected' => 'darczyncy',
        )));
        $this->set('DataBrowserTitle', 'Darczyńcy komitetów wyborczych w Krakowie');
        $this->set('title_for_layout', 'Darczyńcy komitetów wyborczych w Krakowie');


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


            $_submenu = array(
                'items' => array(
                    array(
                        'id' => '',
                        'label' => 'Punkty porządku dziennego',
                    ),
                ),
            );


            if ($posiedzenie->getData('zwolanie_dokument_id')) {
                $_submenu['items'][] = array(
                    'id' => 'informacja',
                    'label' => 'Zwołanie posiedzenia',
                );
            }

            if ($posiedzenie->getData('porzadek_dokument_id')) {
                $_submenu['items'][] = array(
                    'id' => 'porzadek',
                    'label' => 'Porządek obrad',
                );
            }

            if ($posiedzenie->getData('podsumowanie_dokument_id')) {
                $_submenu['items'][] = array(
                    'id' => 'podsumowanie',
                    'label' => 'Podsumowanie posiedzenia',
                );
            }

            if ($posiedzenie->getData('wyniki_dokument_id')) {
                $_submenu['items'][] = array(
                    'id' => 'glosowania',
                    'label' => 'Wyniki głosowań',
                );
            }

            if ($posiedzenie->getData('stenogram_dokument_id')) {
                $_submenu['items'][] = array(
                    'id' => 'stenogram',
                    'label' => 'Stenogram',
                );
            }

            if ($posiedzenie->getData('protokol_dokument_id')) {
                $_submenu['items'][] = array(
                    'id' => 'protokol',
                    'label' => 'Protokół',
                );
            }


            switch ($subaction) {

                case "informacja": {

                    $_submenu['selected'] = 'informacja';
                    $render_view = 'posiedzenie-informacja';
                    break;

                }

                case "porzadek": {

                    $_submenu['selected'] = 'porzadek';
                    $render_view = 'posiedzenie-porzadek';
                    break;

                }

                case "podsumowanie": {

                    $_submenu['selected'] = 'podsumowanie';
                    $render_view = 'posiedzenie-podsumowanie';
                    break;

                }

                case "glosowania": {

                    $_submenu['selected'] = 'glosowania';
                    $render_view = 'posiedzenie-glosowania';
                    break;

                }

                case "stenogram": {

                    $_submenu['selected'] = 'stenogram';
                    $render_view = 'posiedzenie-stenogram';
                    break;

                }

                case "protokol": {

                    $_submenu['selected'] = 'protokol';
                    $render_view = 'posiedzenie-protokol';
                    break;

                }

                default: {

                    $_submenu['selected'] = '';
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


            $this->set('_submenu', $_submenu);
            $this->render($render_view);


        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_posiedzenia',
                ),
                'aggsPreset' => 'krakow_posiedzenia',
            ));

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'posiedzenia',
            )));
            $this->set('title_for_layout', 'Posiedzenia Rady Miasta ' . $this->object->getData('nazwa'));

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
                'layers' => array('neighbours', 'wystapienia'),
                'aggs' => array(
                    'druk' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'dataset' => 'rady_druki',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.rady_druki.punkt_id' => $this->request->params['subid'],
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'scope' => 'global',
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'size' => 1
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
                                            'dataset' => 'krakow_glosowania',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.krakow_glosowania.punkt_id' => $this->request->params['subid'],
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'scope' => 'global',
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'size' => 100
                                ),
                            ),
                        ),
                    ),
                ),
            ));

            $this->set('debata', $debata);
            $this->set('aggs', $this->Dataobject->getAggs());

            $wystapienia = $debata->getLayer('wystapienia');
            $this->set('wystapienia', $wystapienia);

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'posiedzenia',
            )));

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

    public function glosowania()
    {
        $this->request->params['action'] = 'rada';
        $this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $glosowanie = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_glosowania',
                    'id' => $this->request->params['subid'],
                ),
                'aggs' => array(
                    'glosy' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'dataset' => 'krakow_glosowania_glosy',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.krakow_glosowania_glosy.glosowanie_id' => $this->request->params['subid'],
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'scope' => 'global',
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'size' => 100
                                ),
                            ),
                        ),
                    ),
                ),
            ));

            $this->set('glosowanie', $glosowanie);
            $this->set('aggs', $this->Dataobject->getAggs());

            $this->set('title_for_layout', $glosowanie->getTitle());
            $this->render('glosowanie');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_glosowania',
                ),
                'aggsPreset' => 'krakow_glosowania',
                'order' => 'ord desc',
            ));

            $this->set('title_for_layout', 'Głosowania na posiedzeniach rady gminy ' . $this->object->getData('nazwa'));

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
                'layers' => array('neighbours', 'druki', 'docs')
            ));

            $this->set('file',
                isset($this->request->query['file']) ?
                    (int) $this->request->query['file'] : $uchwala->getData('dokument_id')
            );

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
                'searchTitle' => 'Szukaj w uchwałach Rady Miasta Kraków...',
            ));

            $this->set('title_for_layout', 'Uchwały podjęte przez radę gminy ' . $this->object->getData('nazwa'));
            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'rada_uchwaly',
            )));

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
                'searchTitle' => 'Szukaj w zarządzeniach Prezydenta Krakowa...',
            ));

            $this->set('title_for_layout', 'Zarządzenia Prezydenta Krakowa');
            $this->set('_submenu', array_merge($this->submenus['urzad'], array(
                'selected' => 'zarzadzenia',
            )));

        }
    }

    public function pomoc_publiczna()
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
                    'dataset' => 'krakow_pomoc_publiczna',
                ),
                'aggsPreset' => 'krakow_pomoc_publiczna',
                'searchTitle' => 'Szukaj w pomocy publicznej...',
                'order' => 'krakow_pomoc_publiczna.rok desc',
            ));

            $this->set('title_for_layout', 'Pomoc publiczna w Krakowie');
            $this->set('_submenu', array_merge($this->submenus['urzad'], array(
                'selected' => 'pomoc_publiczna',
            )));

        }
    }

    public function urzad_zamowienia()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'urzad';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $akt = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_zamowienia_publiczne',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->set('akt', $akt);
            $this->set('title_for_layout', $akt->getTitle());
            $this->render('zarzadzenie');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_zamowienia_publiczne',
                ),
                'aggsPreset' => 'krakow_zamowienia_publiczne',
                'searchTitle' => 'Szukaj w zamówieniach publicznych...',
                'order' => 'krakow_zamowienia_publiczne.rok desc',
            ));

            $this->set('title_for_layout', 'Zamówienia publiczne Urzędu Miasta w Krakowie');
            $this->set('_submenu', array_merge($this->submenus['urzad'], array(
                'selected' => 'urzad_zamowienia',
            )));

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
                'searchTitle' => 'Szukaj w projektach legislacyjnych...',
            ));

            $this->set('title_for_layout', 'Proces legislacyjny Rady Miasta Krakowa');
            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'druki',
            )));

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


            $title_for_layout = $dzielnica->getTitle();

            switch ($subaction) {

                case 'view': {

                    if ($this->object->getId() == 903) {

                        $global_aggs['radni'] = array(
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'radni_dzielnic',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.radni_dzielnic.dzielnica_id' => $dzielnica->getId(),
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
                                            'data.radni_dzielnic.nazwisko' => 'asc',
                                        ),
                                    ),
                                ),
                            ),
                            'scope' => 'global'
                        );

                        $global_aggs['posiedzenia'] = array(
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'krakow_dzielnice_rady_posiedzenia',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.krakow_dzielnice_rady_posiedzenia.dzielnica_id' => $dzielnica->getId(),
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
                            'scope' => 'global'
                        );

                        $options = array(
                            'searchTitle' => 'Szukaj w ' . $dzielnica->getTitle() . '...',
                            'conditions' => array(
                                'dataset' => 'radni_gmin',
                                'radni_gmin.gmina_id' => '903',
                            ),
                            'cover' => array(
                                'view' => array(
                                    'plugin' => 'Dane',
                                    'element' => 'gminy/dzielnica-cover',
                                ),
                                'aggs' => $global_aggs,
                            ),
                        );

                        $this->set('_submenu', array_merge($this->submenus['dzielnice'], array(
                            'selected' => '',
                        )));

                        $this->Components->load('Dane.DataBrowser', $options);

                    }
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

                    }

                    $this->set('_submenu', array_merge($this->submenus['dzielnice'], array(
                        'selected' => 'rada_posiedzenia',
                    )));

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

                        $this->set('titleForLayout', 'Uchwały rady dzielnicy ' . $dzielnica->getTitle());

                    }

                    $this->set('_submenu', array_merge($this->submenus['dzielnice'], array(
                        'selected' => 'rada_uchwaly',
                    )));

                    break;

                }
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

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'komisje_posiedzenia',
            )));

            $this->set('title_for_layout', 'Posiedzenia komisji Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }


    public function radni_powiazania()
    {

        $this->addInitLayers('radni_powiazania');

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        $this->set('title_for_layout', 'Powiązania radnych gminy  ' . $this->object->getData('nazwa') . ' z organizacjami w Krajowym Rejestrze Sądowym');

        $this->set('_submenu', array_merge($this->submenus['rada'], array(
            'selected' => 'radni_powiazania',
        )));
    }

    public function urzednicy_powiazania()
    {

        $this->addInitLayers('urzednicy_powiazania');
        $this->request->params['action'] = 'urzad';

        $this->_prepareView();

        $this->set('title_for_layout', 'Powiązania urzędników gminy  ' . $this->object->getData('nazwa') . ' z organizacjami w Krajowym Rejestrze Sądowym');

        $this->set('_submenu', array_merge($this->submenus['urzad'], array(
            'selected' => 'urzednicy_powiazania',
        )));
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
                        'label' => 'Wyniki głosowań',
                        'id' => 'glosowania',
                    ),
                    array(
                        'label' => 'Interpelacje',
                        'id' => 'interpelacje',
                    ),
                    array(
                        'label' => 'Obietnice wyborcze',
                        'id' => 'obietnice',
                    ),
                    array(
                        'label' => 'Oświadczenia majątkowe',
                        'id' => 'oswiadczenia',
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
            } elseif ($subaction == 'view') {
                $layers[] = 'okreg';
                $layers[] = 'powiazania';
            }


            $radny = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'radni_gmin',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => $layers,
            ));

            $submenu['items'][] = array(
                'label' => ($radny->getData('radni_gmin.plec') == 'M' ? 'Radny' : 'Radna') . ' w KRS',
                'id' => 'krs',
            );

            // $radny->getLayer( 'neighbours' );
            // $dyzur = $radny->getLayer('najblizszy_dyzur');
            // debug( $dyzur ); die();

            $title_for_layout = $radny->getTitle();

            switch ($subaction) {
                case 'view': {
                    $global_aggs = array(
                        'oswiadczenia' => array(
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'radni_gmin_oswiadczenia_majatkowe',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.radni_gmin_oswiadczenia_majatkowe.radny_id' => $radny->getId(),
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
                                            'radni_gmin_oswiadczenia_majatkowe.rok' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                            'scope' => 'global'
                        ),
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
                            'scope' => 'global'
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
                                        /*
                                        array(
	                                        'nested' => array(
		                                        'path' => 'radni_gmin-komisje',
		                                        'filter' => array(
			                                        'term' => array(
				                                        'radni_gmin-komisje.kadencja_id' => '7',
			                                        ),
		                                        ),
	                                        ),
                                        ),
                                        */
                                    ),
                                ),
                            ),
                            'aggs' => array(
                                'komisje' => array(
                                    'nested' => array(
                                        'path' => 'radni_gmin-komisje',
                                    ),
                                    'aggs' => array(
                                        'kadencja' => array(
                                            'filter' => array(
                                                'term' => array(
                                                    'radni_gmin-komisje.kadencja_id' => '7',
                                                ),
                                            ),
                                            'aggs' => array(
                                                'top' => array(
                                                    'top_hits' => array(
                                                        'size' => 100,
                                                        'fielddata_fields' => array('komisja_id', 'komisja_nazwa', 'stanowisko_id', 'stanowisko_nazwa', 'kadencja_id'),
                                                        'sort' => array(
                                                            'radni_gmin-komisje.stanowisko_id' => 'desc',
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'scope' => 'global'
                        ),
                        'glosowania' => array(
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'krakow_glosowania_glosy',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'radni_gmin.id' => $radny->getId(),
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
                            'scope' => 'global'
                        ),
                        'oswiadczenia' => array(
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'krakow_oswiadczenia',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.krakow_urzednicy.radny_id' => $radny->getId(),
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
                            'scope' => 'global'
                        ),
                    );

                    $options = array(
                        'searchTitle' => 'Szukaj w ' . $radny->getTitle() . '...',
                        'conditions' => array(
                            '_object' => 'radni_gmin.' . $radny->getId(),
                        ),
                        'cover' => array(
                            'view' => array(
                                'plugin' => 'Dane',
                                'element' => 'radni_gmin/cover',
                            ),
                            'aggs' => $global_aggs
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

                    if ($radny->getData('krs_osoba_id')) {
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

                    $submenu['selected'] = 'glosowania';
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

                        $submenu=array_merge($submenu, array(
                            'selected' => 'oswiadczenia',
                        ));
                        $this->set('DataBrowserTitle', 'Oświadczenia majątkowe');
                        $title_for_layout .= ' - Oświadczenia majątkowe';

                    }

                    break;
                }
                case 'obietnice': {

                    $submenu['selected'] = 'obietnice';
                    break;
                }

                case 'krs':{
                    $submenu=array_merge($submenu, array(
                        'selected' => 'krs',
                    ));

                    if ($radny->getData('krs_osoba_id')) {
                        $this->set('osoba', $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'krs_osoby',
                                'id' => $radny->getData('krs_osoba_id'),
                            ),
                            'layers' => array('organizacje'),
                        )));
                    }
                    break;
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

		if( !isset($this->request->query['conditions']['krakow_komisje.kadencja_id']) )
			$this->request->query['conditions']['krakow_komisje.kadencja_id'] = '7';

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

                    if ($this->object->getId() == 903) {

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
                                        array(
                                            'nested' => array(
                                                'path' => 'radni_gmin-komisje',
                                                'filter' => array(
                                                    'bool' => array(
                                                        'must' => array(
                                                            array(
                                                                'term' => array(
                                                                    'radni_gmin-komisje.komisja_id' => $komisja->getId(),
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
                                        'size' => 100,
                                        'script_fields' => array(
                                            'komisje' => array(
                                                'script' => "_source['radni_gmin-komisje']",
                                            ),
                                        ),
                                        'fielddata_fields' => array('dataset', 'id'),
                                        'sort' => array(
                                            'data.radni_gmin.funkcja_id' => 'desc',
                                            'data.radni_gmin.nazwisko' => 'asc',
                                        ),
                                    ),
                                ),
                            ),
                        );

                        $global_aggs['rada_komisje_posiedzenia'] = array(
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'krakow_komisje_posiedzenia',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.krakow_komisje_posiedzenia.komisja_id' => $komisja->getId(),
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
                                            'date' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        );

                        $options = array(
                            'searchTitle' => 'Szukaj w ' . $komisja->getTitle() . '...',
                            'conditions' => array(
                                'dataset' => 'radni_gmin',
                                'radni_gmin.gmina_id' => '903',
                            ),
                            'cover' => array(
                                'view' => array(
                                    'plugin' => 'Dane',
                                    'element' => 'gminy/komisja-cover',
                                ),
                                'aggs' => $global_aggs,
                            ),
                        );

                        $this->set('_submenu', array_merge($this->submenus['komisje'], array(
                            'selected' => '',
                        )));

                        $this->Components->load('Dane.DataBrowser', $options);

                    }
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

                    $this->set('_submenu', array_merge($this->submenus['komisje'], array(
                        'selected' => 'posiedzenia',
                    )));


                    break;


                }

            }


            $this->set('komisja', $komisja);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('komisja-' . $subaction);

        } else {

            $this->_prepareView();

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje',
                ),
                'aggsPreset' => 'krakow_komisje'
            ));

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'komisje',
            )));

            $this->set('title_for_layout', 'Komisje Rady Miasta Krakowa');

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

    public function umowy()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'urzad';


        $global_aggs = array(
            'umowy' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'krakow_umowy',
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
                            'suma' => array(
                                'sum' => array(
                                    'field' => 'data.krakow_umowy.wartosc_brutto',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );


        $options = array(
            'searchTitle' => 'Szukaj w umowach...',
            'conditions' => array(
                'dataset' => 'krakow_umowy',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'gminy/umowy-cover',
                ),
                'aggs' => $global_aggs,
            ),

        );

        $this->Components->load('Dane.DataBrowser', $options);

        $this->set('title_for_layout', 'Umowy zawierane przez Urząd Gminy Kraków');
        $this->set('_submenu', array_merge($this->submenus['urzad'], array(
            'selected' => 'umowy',
        )));

    }

    public function zamowienia()
    {

        $this->_prepareView();

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
                'scope' => 'global'
            ),
        );


        $options = array(
            'searchTitle' => 'Szukaj w zamówieniach publicznych...',
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne',
                'zamowienia_publiczne.gmina_id' => $this->object->getId(),
                'aggsPreset' => 'zamowienia_publiczne',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'gminy/zamowienia-cover',
                ),
                'aggs' => $global_aggs
            ),

        );

        $this->Components->load('Dane.DataBrowser', $options);

        $this->set('title_for_layout', 'Zamówienia publiczne w gminie ' . $this->object->getData('nazwa'));

    }

    public function zamowienia_rozstrzygniete()
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne_dokumenty',
                'zamowienia_publiczne_dokumenty.gmina_id' => $this->object->getId(),
            ),
            'renderFile' => 'zamowienia_publiczne_dokumenty',
            'aggsPreset' => 'zamowienia_publiczne_dokumenty',
        ));

        $this->menu_selected = 'zamowienia';
        $this->set('DataBrowserTitle', 'Rozstrzygnięcia zamówień publicznych');
        $this->set('title_for_layout', "Rozstrzygnięte zamówienia publiczne w gminie " . $this->object->getTitle());

        $this->menu['selected'] = 'zamowienia';
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
        $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
            'selected' => 'organizacje',
        )));

    }

    public function osoby()
    {

        $this->request->params['action'] = 'organizacje';
        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_osoby',
                'krs_osoby.gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'krs_osoby',
        ));

        $this->set('title_for_layout', 'Osoby w gminie ' . $this->object->getData('nazwa'));
        $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
            'selected' => 'osoby',
        )));

    }

    public function biznes()
    {

        $this->request->params['action'] = 'organizacje';
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
        $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
            'selected' => 'biznes',
        )));

    }

    public function prawo()
    {

		$this->_prepareView();

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $prawo = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'prawo_wojewodztwa',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->set('prawo', $prawo);
            $this->set('title_for_layout', $prawo->getTitle());
            $this->render('prawo-view');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
	            'conditions' => array(
	                'dataset' => 'prawo_wojewodztwa',
	                'prawo_wojewodztwa.gmina_id' => $this->object->getId(),
	            ),
	            'aggsPreset' => 'prawo_lokalne',
	        ));

	        $this->set('title_for_layout', 'Prawo lokalne gminy ' . $this->object->getData('nazwa'));

        }

    }

    public function ngo()
    {

        $this->request->params['action'] = 'organizacje';
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
            $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
                'selected' => 'ngo',
            )));
        }
    }

    public function spzoz()
    {

        $this->request->params['action'] = 'organizacje';
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
        $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
            'selected' => 'spzoz',
        )));

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

        $this->_prepareView();
        $this->request->params['action'] = 'urzad';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $urzednik = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_urzednicy',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $global_aggs = array(
                'oswiadczenia' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_oswiadczenia',
                                    ),
                                ),
                                array(
                                    'term' => array(
                                        'data.krakow_oswiadczenia.urzednik_id' => $urzednik->getId(),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'aggs' => array(
                        'top' => array(
                            'top_hits' => array(
                                'size' => 999,
                                'fielddata_fields' => array('dataset', 'id'),
                                'sort' => array(
                                    'data.krakow_oswiadczenia.rok' => array(
                                        'order' => 'desc',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'scope' => 'global'
                ),
            );

            $options = array(
                'searcher' => false,
                'searchTitle' => 'Szukaj w ' . $urzednik->getTitle() . '...',
                'conditions' => array(
                    '_object' => 'krakow_urzednicy.' . $urzednik->getId(),
                ),
                'cover' => array(
                    'view' => array(
                        'plugin' => 'Dane',
                        'element' => 'krakow_urzednicy/cover',
                    ),
                    'aggs' => $global_aggs
                ),
                /*
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
                                'krakow_oswiadczenia' => array('prawo', 'Prawo lokalne'),
                            ),
                        ),
                    ),
                ),
                */
            );

            if ($urzednik->getData('krs_osoba_id')) {
                $this->set('osoba', $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'krs_osoby',
                        'id' => $urzednik->getData('krs_osoba_id'),
                    ),
                    'layers' => array('organizacje'),
                )));
            }

            $this->Components->load('Dane.DataBrowser', $options);

            $this->set('urzednik', $urzednik);
            $this->set('title_for_layout', $urzednik->getTitle());
            $this->render('urzednik');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_urzednicy',
                    'krakow_urzednicy.jednostka_id!=' => '17',
                ),
                'aggsPreset' => 'krakow_urzednicy',
            ));

            $this->set('title_for_layout', 'Urzędnicy Urzędu Miasta');
            $this->set('_submenu', array_merge($this->submenus['urzad'], array(
                'selected' => 'urzednicy',
            )));

        }

    }

    public function jednostki()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'urzad';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $jednostka = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_jednostki',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_urzednicy',
                    'krakow_urzednicy.jednostka_id' => $this->request->params['subid'],
                ),
            ));

            $this->set('DataBrowserTitle', 'Urzędnicy zatrudnieniu w tej jednostce:');
            $this->set('jednostka', $jednostka);
            $this->set('title_for_layout', $jednostka->getTitle());
            $this->render('jednostka');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_jednostki',
                ),
                'aggsPreset' => 'krakow_jednostki',
            ));

            $this->set('title_for_layout', 'Jednostki administracyjne urzędu miasta ' . $this->object->getData('nazwa'));
            $this->set('_submenu', array_merge($this->submenus['urzad'], array(
                'selected' => 'jednostki',
            )));

        }

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
            //'finanse'
        ));
        $this->_prepareView();
        $this->loadModel('Finanse.GminaBudzet');
        $this->request->params['action'] = 'finanse';
        $this->set('title_for_layout', 'Wydatki w gminie ' . $this->object->getTitle());
        $this->set('dzialy', $this->GminaBudzet->getDzialy(
            $this->object->getId(),
            'wydatki'
        ));
    }

    public function okregi()
    {

	    $this->request->params['action'] = 'rada';
        $this->_prepareView();

        if ($this->object->getId() != '903')
            throw new NotFoundException;

        $this->loadModel('PrzejrzystyKrakow.Krakow');

        if($subid = @$this->request->params['subid']) {

            $okreg = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_okregi_wyborcze',
                    'id' => $this->request->params['subid'],
                ),
                'aggs' => array(
	                'radni' => array(
		                'scope' => 'global',
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
		                            array(
		                                'term' => array(
		                                    'data.radni_gmin.krakow_okreg_id' => $this->request->params['subid'],
		                                ),
		                            ),
		                        ),
		                    ),
		                ),
		                'aggs' => array(
			                'hits' => array(
				                'top_hits' => array(
					                'size' => 100,
	                                'fielddata_fields' => array('dataset', 'id'),
				                ),
			                ),
		                ),
	                ),
                ),
                'layers' => array('geo')
            ));

            $aggs = $this->Dataobject->getAggs();
            $this->set('okreg_aggs', $aggs);

            $this->set('okreg', $okreg);
            $this->set('title_for_layout', $okreg->getTitle());
            $this->render('okreg');


        } else {
            $this->set('okregi', $this->Krakow->okregi());
            $this->set('title_for_layout', 'Okręgi wyborcze');
        }

        $this->request->params['action'] = 'rada';
        $this->set('_submenu', array_merge($this->submenus['rada'], array(
            'selected' => 'okregi',
        )));
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
            'base' => $this->object->getUrl(),
        );


        $aggs = array();
        if (isset($this->viewVars['dataBrowser']['aggs']) && !empty($this->viewVars['dataBrowser']['aggs']))
            $aggs = $this->viewVars['dataBrowser']['aggs'];

        if (isset($this->object_aggs) && !empty($this->object_aggs))
            $aggs = $this->object_aggs;

        $menu['items'][] = array(
            'id' => '',
            'label' => 'Aktualności',
            'icon' => array(
                'src' => 'glyphicon',
                'id' => 'home',
            ),
        );


        if ($object->getId() == '903') {

            $menu['items'][] = array(
                'id' => 'rada',
                'label' => 'Rada Miasta',
            );
            $menu['items'][] = array(
                'id' => 'urzad',
                'label' => 'Urząd Miasta',
            );
            $menu['items'][] = array(
                'id' => 'dzielnice',
                'label' => 'Dzielnice',
            );
            $menu['items'][] = array(
                'id' => 'zamowienia',
                'label' => 'Zamówienia publiczne',
            );
            $menu['items'][] = array(
                'id' => 'organizacje',
                'label' => 'KRS',
            );
            $menu['items'][] = array(
                'id' => 'finanse',
                'label' => 'Finanse',
            );
            /*
            $menu['items'][] = array(
                'id' => 'powiazania',
                'label' => 'Powiązania',
            );
            */

        } else {

            if (isset($aggs['prawo']) && $aggs['prawo']['doc_count'])
                $menu['items'][] = array(
                    'label' => 'Prawo lokalne',
                    'id' => 'prawo',
                    'count' => $aggs['prawo']['doc_count'],
                );

            if (isset($aggs['zamowienia']) && $aggs['zamowienia']['doc_count'])
                $menu['items'][] = array(
                    'label' => 'Zamówienia publiczne',
                    'id' => 'zamowienia',
                    'count' => $aggs['zamowienia']['doc_count'],
                );

            $menu['items'][] = array(
                'label' => 'KRS',
                'id' => 'organizacje',
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

    public function beforeRender()
    {

        if ($this->domainMode == 'PK') {
            $this->_layout['footer']['element'] = 'pk';
            $this->_layout['header']['element'] = 'pk';
        }

        parent::beforeRender();


        if ($this->object) {

            $this->addBreadcrumb(array(
                'href' => '/dane/wojewodztwa/' . $this->object->getData('wojewodztwa.id'),
                'label' => 'Województwo ' . lcfirst($this->object->getData('wojewodztwa.nazwa')),
            ));

            if ($this->object->getData('powiaty.typ_id') == '1') {
                $this->addBreadcrumb(array(
                    'href' => '/dane/powiaty/' . $this->object->getData('powiaty.id'),
                    'label' => 'Powiat ' . lcfirst($this->object->getData('powiaty.nazwa')),
                ));
            }

        }

    }

}
