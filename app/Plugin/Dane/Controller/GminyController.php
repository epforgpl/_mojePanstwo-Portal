<?php

App::uses('DataobjectsController', 'Dane.Controller');

class GminyController extends DataobjectsController
{

    private static $voteSessionName = 'Krakow.Vote';
    public $observeOptions = true;
    public $addDatasetBreadcrumb = false;
    public $objectActivities = true;
    public $objectData = true;
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
                    'id' => 'komisje_opinie',
                    'label' => 'Opinie komisji',
                ),
                array(
                    'id' => 'radni_powiazania',
                    'label' => 'Radni w KRS',
                ),
                array(
                    'id' => 'darczyncy',
                    'label' => 'Darczyńcy komitetów wyborczych',
                ),
                array(
                    'id' => 'okregi',
                    'label' => 'Okręgi wyborcze',
                ),
                /*
                array(
                    'id' => 'aktywnosci',
                    'label' => 'Aktywność radnych',
                ),
                */
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
                    'id' => 'praca',
                    'label' => 'Praca',
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
                array(
                    'id' => 'opinie',
                    'label' => 'Opinie',
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
        'finanse' => array(
            'items' => array(
                array(
                    'label' => 'Wydatki',
                    'id' => '',
                ),
                /*
                array(
                    'id' => 'dochody',
                    'label' => 'Dochody',
                ),
                */
            ),
        ),
        'wpf' => array(
	        'items' => array(
		        array(
			        'id' => 'wpf',
			        'label' => 'Wykaz Przedsięwzięć Wieloletnich',
		        ),
		        array(
			        'id' => 'wpf_finanse',
			        'label' => 'Wieloletni Plan Finansowy',
		        ),
	        ),
        ),
    );

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
    public $loadChannels = true;
    public $menu = array();
    public $helpers = array(
        'Number' => array(
            'className' => 'Dane.NumberPlus',
        ),
    );
    public $objectOptions = array(
        'bigTitle' => true,
    );
    private $histogramIntervals = array(
        100000000,                  // 100 mln.
        10000000,                   // 10 mln.
        1000000,                    // 1 mln.
        100000,                     // 100 tys.
        1000
    );

    public function view()
    {

        $_layers = array('szef', 'channels', 'udzialy');
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
                            'must_not' => array(
	                            array(
		                            'term' => array(
			                            'data.radni_gmin.id' => 39267,
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
                /*
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
                */
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

			if(
                @$this->request->query['order'] &&
                ($parts = explode(' ', $this->request->query['order'])) &&
            	( count($parts)>1 )
        	) {

	        	foreach(array('osoby', 'organizacje', 'pomoc_publiczna', 'radni_gminy', 'rady_gmin_interpelacje', 'rady_druki', 'krakow_rada_uchwaly', 'darczyncy', 'krakow_komisje', 'krakow_zarzadzenia', 'krakow_umowy', 'krakow_jednostki', 'krakow_urzednicy', 'dzielnice', 'urzad_zamowienia') as $a)
	        		$aggs[$a]['aggs']['top']['top_hits']['sort'] = array(
		        		$parts[0] => array(
			        		'order' => $parts[1],
		        		),
                    );

        	}

            $options = array(
                'searchTitle' => 'Szukaj powiązań w Krakowie...',
                'conditions' => array(
                    'dataset' => array('krakow_pomoc_publiczna', 'krs_osoby', 'krakow_darczyncy', 'radni_gmin', 'rady_gmin_interpelacje', 'rady_druki', 'krakow_rada_uchwaly', 'krakow_komisje', 'krakow_zarzadzenia', 'krakow_umowy', 'krakow_jednostki', 'krakow_urzednicy', 'dzielnice', 'krs_podmioty', 'krakow_zamowienia_publiczne'),
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
                'sort' => array(
	                'date' => array(
						'label' => 'Data',
						'options' => array(
							'desc' => 'od najnowszych',
							'asc' => 'od najstarszych'
						)
					),
					'score' => array(
						'label' => 'Trafność',
						'options' => array(
							'desc' => 'najtrafniejsze'
						)
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
                /*
                'zamowienia_publiczne' => array(
                    'title' => 'Zamówienia publiczne w Krakowie',
                    'href' => $this->object->getUrl() . '/zamowienia',
                ),
                */
                'urzad_zamowienia' => array(
                    'title' => 'Zamówienia publiczne Urzędu Miasta Kraków',
                    'href' => $this->object->getUrl() . '/urzad_zamowienia',
                ),
            ));
            $this->Components->load('Dane.DataBrowser', $options);


        } else {

            $global_aggs = array(
	            /*
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
                */
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
                                        'data.dzialania.dataset' => 'gminy',
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
                /*
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
                */
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
                                'field' => 'data.krs_podmioty.forma_prawna_id',
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
                                'field' => 'data.krs_podmioty.wartosc_kapital_zakladowy',
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
                    'cache' => true,
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
                /*
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
                */
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
            'browserTitle' => 'Radni Miasta Krakowa',
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
                'sortPreset' => 'rady_gmin_interpelacje',
                'phrasesPreset' => 'rady_gmin_interpelacje',
                'searchTitle' => 'Szukaj w interpelacjach...',
                'browserTitle' => 'Interpelacje Radnych Miasta Krakowa',
            ));

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'interpelacje',
            )));
            $this->set('title_for_layout', 'Interpelacje Radnych Miasta ' . $this->object->getData('nazwa'));

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
            'beforeBrowserElements' => 'gminy/darczyncy_msg',
            'browserTitle' => 'Darczyńcy komitetów wyborczych w Krakowie',
        ));

        $this->set('_submenu', array_merge($this->submenus['rada'], array(
            'selected' => 'darczyncy',
        )));
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
				'items' => array(),
			);
			
			if( $posiedzenie->getData('liczba_punktow') ) {
			
				$_submenu['items'][] = array(
	                'id' => '',
	                'label' => 'Punkty porządku dziennego',
	            );
            
            }

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
					
					if( $posiedzenie->getData('liczba_punktow') ) {
					
	                    $_submenu['selected'] = '';
	                    $submenu['selected'] = 'punkty';
	                    $render_view = 'posiedzenie-punkty';
	
	                    $this->Components->load('Dane.DataBrowser', array(
	                        'conditions' => array(
	                            'dataset' => 'krakow_posiedzenia_punkty',
	                            'krakow_posiedzenia_punkty.posiedzenie_id' => $posiedzenie->getId(),
	                        ),
	                        'order' => 'krakow_posiedzenia_punkty._ord asc',
	                        'limit' => 1000,
	                        'browserTitle' => 'Punkty porządku dziennego na posiedzeniu',
	                    ));
	
	                    $this->set('title_for_layout', 'Posiedzenie Rady Miasta Kraków');
	                    // $this->set('DataBrowserTitle', 'Organizacje w gminie ' . $this->object->getData('nazwa'));
	                    
                    } else {
	                    
	                    $_submenu['selected'] = 'informacja';
	                    $render_view = 'posiedzenie-informacja';
	                    
                    }


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
                'sortPreset' => 'krakow_posiedzenia',
                'phrasesPreset' => 'krakow_posiedzenia',
                'browserTitle' => 'Posiedzenia Rady Miasta Kraków',
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
			
			
			if( 
				( @$this->request->params['ext'] == 'json' ) && 
				( @$this->request->params['subaction']=='wystapienia' ) && 
				( is_numeric( $this->request->params['subsubid'] ) )
			) {
				
				$wystapienie = $this->Dataobject->find('first', array(
	                'conditions' => array(
	                    'dataset' => 'krakow_posiedzenia_wystapienia',
	                    'id' => $this->request->params['subsubid'],
	                ),
	                'layers' => array(
		                'html',
	                ),
	            ));
	            
	            $this->set('data', $wystapienie->getData());
	            $this->set('layers', $wystapienie->getLayers());
	            $this->set('_serialize', array('data', 'layers'));
	            return true;
				
			}
			
			
			$debata = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_posiedzenia_punkty',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('neighbours', 'wystapienia'),
            ));
						
			$global_aggs = array(
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
                'wystapienia' => array(
                    'filter' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'dataset' => 'krakow_posiedzenia_wystapienia',
                                    ),
                                ),
                                array(
                                    'term' => array(
                                        'data.krakow_posiedzenia_wystapienia.punkt_id' => $this->request->params['subid'],
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
                                    'data.krakow_posiedzenia_wystapienia._ord' => array(
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
                    'dataset' => 'krakow_posiedzenia_punkty',
                    'data.krakow_posiedzenia_punkty.id' => $debata->getId(),
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
	                    'dataset' => 'krakow_posiedzenia_wystapienia',
	                    'id' => $this->request->params['subsubid'],
	                ),
	                'layers' => array(
		                'html',
	                ),
	            ));	
	            	            
	            $this->set('wystapienie', $wystapienie);
				
			}
			
			/*
            $this->set('debata', $debata);
            $this->set('title_for_layout', $debata->getTitle());
            $this->render('sejm_debata');
			*/
			
            $this->set('debata', $debata);

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

            if($this->Session->check(self::$voteSessionName) && $this->object->getId() == '903') {
                $header_vote = $this->Session->read(self::$voteSessionName);
                $header_vote_progress = 0;
                $votes_cout = count($header_vote);
                $progress = 100 / $votes_cout;
                foreach($header_vote as $vote) {
                    if($vote['vote'] !== false)
                        $header_vote_progress += $progress;
                }
                $this->set('header_vote_progress', $header_vote_progress);
                $this->set('header_vote', $header_vote);
            }

            $uchwala = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_rada_uchwaly',
                    'id' => $this->request->params['subid']
                ),
                'layers' => array('neighbours', 'druki', 'docs'),
            ));

            $this->set('file',
                isset($this->request->query['file']) ?
                    (int)$this->request->query['file'] : $uchwala->getData('dokument_id')
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
                'sortPreset' => 'krakow_rada_uchwaly',
                'phrasesPreset' => 'krakow_rada_uchwaly',
                'searchTitle' => 'Szukaj w uchwałach Rady Miasta Kraków...',
                'browserTitle' => 'Uchwały podjęte przez Radę Miasta ' . $this->object->getData('nazwa'),
            ));

            $this->set('title_for_layout', 'Uchwały podjęte przez Radę Miasta ' . $this->object->getData('nazwa'));
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
                'sortPreset' => 'krakow_zarzadzenia',
                'searchTitle' => 'Szukaj w zarządzeniach Prezydenta Krakowa...',
                'browserTitle' => 'Zarządzenia Prezydenta Krakowa',
            ));

            $this->set('title_for_layout', 'Zarządzenia Prezydenta Krakowa');
            $this->set('_submenu', array_merge($this->submenus['urzad'], array(
                'selected' => 'zarzadzenia',
            )));

        }
    }
    
    public function praca()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'praca';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $ogloszenie = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_praca',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('html'),
            ));

            $this->set('ogloszenie', $ogloszenie);
            $this->set('title_for_layout', $ogloszenie->getTitle());
            $this->render('praca-ogloszenie');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_praca',
                ),
                'aggsPreset' => 'krakow_praca',
                'sortPreset' => 'krakow_praca',
                'searchTitle' => 'Szukaj w ogłoszeniach o pracę...',
                'browserTitle' => 'Ogłoszenia o pracę',
            ));

            $this->set('title_for_layout', 'Ogłoszenia o pracę w Krakowie');
            $this->set('_submenu', array_merge($this->submenus['urzad'], array(
                'selected' => 'praca',
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
                'browserTitle' => 'Pomoc publiczna w Krakowie',
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
                'browserTitle' => 'Zamówienia publiczne Urzędu Miasta w Krakowie',
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
                'sortPreset' => 'rady_durki',
                'phrasesPreset' => 'rady_druki',
                'searchTitle' => 'Szukaj w projektach legislacyjnych...',
                'browserTitle' => 'Projekty legislacyjne rozpatrywane przez Radę Miasta Kraków',
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

            $cadences = array(
                'items' => array(
                    '7' => array(
                        'label' => 'Kadencja VII'
                    ),
                    '6' => array(
                        'label' => 'Kadencja VI'
                    ),
                ),
                'param' => 'kadencja',
                'selected' => '7'
            );

            if(isset($this->request->query[$cadences['param']]) &&
                array_key_exists($this->request->query[$cadences['param']], $cadences['items'])) {
                $cadences['selected'] = $this->request->query[$cadences['param']];
            }


            $subaction = (isset($this->request->params['subaction']) && $this->request->params['subaction']) ? $this->request->params['subaction'] : 'view';
            $subsubid = (isset($this->request->params['subsubid']) && $this->request->params['subsubid']) ? $this->request->params['subsubid'] : false;

            $dzielnica = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'dzielnice',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array('info', 'channels', 'subscriptions'),
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
                                        array(
                                            'term' => array(
                                                'data.radni_dzielnic.kadencja_id' => $cadences['selected'],
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
                                                'data.krakow_dzielnice_rady_posiedzenia.kadencja_id' => $cadences['selected'],
                                            ),
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

                    $cadences = null;

                    if (
                        $subsubid &&
                        ($posiedzenie = $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'krakow_dzielnice_rady_posiedzenia',
                                'id' => $subsubid,
                            ),
                        )))
                    ) {

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
                            'browserTitle' => 'Posiedzenia Rady Dzielnicy',
                        ));

                    }

                    $this->set('_submenu', array_merge($this->submenus['dzielnice'], array(
                        'selected' => 'rada_posiedzenia',
                    )));

                    break;


                }

                case 'rada_uchwaly': {

                    $cadences = null;

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
                            'browserTitle' => 'Uchwały Rady Dzielnicy',
                        ));

                        $this->set('titleForLayout', 'Uchwały rady dzielnicy ' . $dzielnica->getTitle());

                    }

                    $this->set('_submenu', array_merge($this->submenus['dzielnice'], array(
                        'selected' => 'rada_uchwaly',
                    )));

                    break;

                }
            }


            $this->set('cadences', $cadences);
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
                'sortPreset' => 'krakow_komisje_posiedzenia',
                'renderFile' => 'gminy/krakow_komisje_posiedzenia',
				'browserTitle' => 'Posiedzenia komisji Rady Miasta ' . $this->object->getData('nazwa'),
            ));

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'komisje_posiedzenia',
            )));

            $this->set('title_for_layout', 'Posiedzenia komisji Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }

    public function komisje_opinie()
    {
        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $opinia = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje_dokumenty',
                    'id' => $this->request->params['subid'],
                ),
            ));

            $this->set('komisja_opinia', $opinia);
            $this->set('title_for_layout', $opinia->getTitle());

            $this->render('komisja_opinia');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje_dokumenty',
                ),
				'browserTitle' => 'Opinie komisji Rady Miasta ' . $this->object->getData('nazwa'),
            ));

            $this->set('_submenu', array_merge($this->submenus['rada'], array(
                'selected' => 'komisje_opinie',
            )));

            $this->set('title_for_layout', 'Posiedzenia komisji Rady Miasta ' . $this->object->getData('nazwa'));

        }
    }

    public function radni_powiazania()
    {

        $this->addInitLayers('radni_powiazania');

        $this->_prepareView();
        $this->request->params['action'] = 'rada';

        $this->set('title_for_layout', 'Powiązania Radnych Miasta  ' . $this->object->getData('nazwa') . ' z organizacjami w Krajowym Rejestrze Sądowym');

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
                        'id' => '',
                        'label' => 'Dane',
                    ),
                    array(
                        'label' => 'Dyżury',
                        'id' => 'dyzury',
                    ),
                    array(
                        'label' => 'Wystąpienia',
                        'id' => 'wystapienia',
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
                        /*
                        'wystapienia' => array(
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'krakow_posiedzenia_wystapienia',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.krakow_posiedzenia_wystapienia.radny_id' => $radny->getId(),
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
                                            'data.krakow_posiedzenia_wystapienia._ord' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                            'scope' => 'global'
                        ),
                        */
                        /*
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
                                            'data.radni_gmin_oswiadczenia_majatkowe.rok' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                            'scope' => 'global'
                        ),
                        */
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
                        /*
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
                                                'data.krakow_glosowania_glosy.radny_id' => $radny->getId(),
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
                                        '_source' => array(
	                                        'include' => array('data.*'),
                                        ),
                                    ),
                                ),
                            ),
                            'scope' => 'global'
                        ),
                        */
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
                                        '_source' => array(
	                                        'include' => array('data.*'),
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
	                    try {
	                        $this->set('osoba', $this->Dataobject->find('first', array(
	                            'conditions' => array(
	                                'dataset' => 'krs_osoby',
	                                'id' => $radny->getData('krs_osoba_id'),
	                            ),
	                            'layers' => array('organizacje'),
	                        )));
                        } catch(Exception $e) {
	                        
                        }
                    }

                    $this->Components->load('Dane.DataBrowser', $options);
                    $this->channels = $radny->getLayer('channels');

                    $submenu['selected'] = '';

                    break;
                }
                case 'wystapienia': {

                    $this->Components->load('Dane.DataBrowser', array(
                        'browserTitle' => 'Wystąpienia radnego',
                        'conditions' => array(
                            'dataset' => 'krakow_posiedzenia_wystapienia',
                            'krakow_posiedzenia_wystapienia.radny_id' => $radny->getData('id'),
                        ),
                        // 'aggsPreset' => 'rady_gmin_wystapienia',
                        // 'renderFile' => 'radni_gmin/rady_gmin_wystapienia',
                    ));

                    $submenu['selected'] = 'wystapienia';
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
                        'browserTitle' => 'Wyniki głosowań radnego',
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
                        'browserTitle' => 'Interpelacje radnego',
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
	                        'browserTitle' => 'Oświadczenia majątkowe radnego',
                        ));

                        $submenu = array_merge($submenu, array(
                            'selected' => 'oswiadczenia',
                        ));
                        $title_for_layout .= ' - Oświadczenia majątkowe';

                    }

                    break;
                }
                case 'obietnice': {

					if( isset($this->request->query['editKey']) ) {

						$this->loadModel('Dane.Gmina');

						if( $this->request->isPost() ) {

                            $promises = array();
							foreach( $this->request->data as $k => $v )
								if( is_numeric($k) )
									$promises[] = array(
										'id' => $k,
										'content' => $v,
									);

                            if( !empty($promises) )
								$res = $this->Gmina->savePromises($radny->getId(), $this->request->query['editKey'], $promises);

                        } elseif( $this->Gmina->checkEditKey( $radny->getId(), $this->request->query['editKey'] ) ) {

                            $this->set('editKey', true);

                        }

                    }

                    $submenu['selected'] = 'obietnice';
                    break;
                }

                case 'krs': {
                    $submenu = array_merge($submenu, array(
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
                                        /*
                                        'script_fields' => array(
                                            'komisje' => array(
                                                'script' => "_source['radni_gmin-komisje']",
                                            ),
                                        ),
                                        */
                                        'fielddata_fields' => array('dataset', 'id'),
                                        'sort' => array(
                                            'data.radni_gmin.funkcja_id' => 'desc',
                                            'data.radni_gmin.nazwisko' => 'asc',
                                        ),
                                        '_source' => array(
	                                        'include' => array('data.*', 'radni_gmin-komisje'),
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
                            'aggs' => array(
	                            'dokumenty' => array(
		                            'scope' => 'global',
		                            'filter' => array(
			                            'bool' => array(
				                            'must' => array(
					                            array(
						                            'term' => array(
							                            'dataset' => 'krakow_komisje_dokumenty',
						                            ),
					                            ),
					                            array(
						                            'term' => array(
							                            'data.krakow_komisje_dokumenty.posiedzenie_id' => $subsubid,
						                            ),
					                            ),
				                            ),
			                            ),
		                            ),
		                            'aggs' => array(
			                            'labels' => array(
				                            'terms' => array(
					                            'field' => 'data.krakow_komisje_dokumenty.label',
					                            'size' => 10000,
				                            ),
				                            'aggs' => array(
					                            'top' => array(
						                            'top_hits' => array(
							                            'size' => 10000,
							                            'fielddata_fields' => array('dataset', 'id'),
						                            ),
					                            ),
				                            ),
			                            ),
		                            ),
	                            ),
                            ),
                            'layers' => array('punkty')
                        )))
                    ) {


                        $aggs = @$this->Dataobject->getAggs();
						if( @$aggs['dokumenty']['labels']['buckets'] ) {

                            $wybrany_dokument = false;
							$this->set('dokumenty', $aggs['dokumenty']['labels']['buckets']);

                            if (isset($this->request->query['d']))
                                foreach ($aggs['dokumenty']['labels']['buckets'] as $b)
									foreach( $b['top']['hits']['hits'] as $h )
										if( $h['fields']['id'][0]==$this->request->query['d'] )
											$wybrany_dokument = $h;

                            if( $wybrany_dokument )
								$this->set('wybrany_dokument', $wybrany_dokument);

                        }

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
                            'browserTitle' => 'Posiedzenia komisji',
                        ));


                    }

                    $this->set('_submenu', array_merge($this->submenus['komisje'], array(
                        'selected' => 'posiedzenia',
                    )));


                    break;


                }
                case 'opinie': {

                    if (
                        $subsubid &&
                        ($posiedzenie = $this->Dataobject->find('first', array(
                            'conditions' => array(
                                'dataset' => 'krakow_komisje_posiedzenia',
                                'id' => $subsubid,
                            ),
                            'aggs' => array(
	                            'dokumenty' => array(
		                            'scope' => 'global',
		                            'filter' => array(
			                            'bool' => array(
				                            'must' => array(
					                            array(
						                            'term' => array(
							                            'dataset' => 'krakow_komisje_dokumenty',
						                            ),
					                            ),
					                            array(
						                            'term' => array(
							                            'data.krakow_komisje_dokumenty.posiedzenie_id' => $subsubid,
						                            ),
					                            ),
				                            ),
			                            ),
		                            ),
		                            'aggs' => array(
			                            'labels' => array(
				                            'terms' => array(
					                            'field' => 'data.krakow_komisje_dokumenty.label',
					                            'size' => 10000,
				                            ),
				                            'aggs' => array(
					                            'top' => array(
						                            'top_hits' => array(
							                            'size' => 10000,
							                            'fielddata_fields' => array('dataset', 'id'),
						                            ),
					                            ),
				                            ),
			                            ),
		                            ),
	                            ),
                            ),
                            'layers' => array('punkty')
                        )))
                    ) {


                        $aggs = @$this->Dataobject->getAggs();
						if( @$aggs['dokumenty']['labels']['buckets'] ) {

                            $wybrany_dokument = false;
							$this->set('dokumenty', $aggs['dokumenty']['labels']['buckets']);

                            if (isset($this->request->query['d']))
                                foreach ($aggs['dokumenty']['labels']['buckets'] as $b)
									foreach( $b['top']['hits']['hits'] as $h )
										if( $h['fields']['id'][0]==$this->request->query['d'] )
											$wybrany_dokument = $h;

                            if( $wybrany_dokument )
								$this->set('wybrany_dokument', $wybrany_dokument);

                        }

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
                                'dataset' => 'krakow_komisje_dokumenty',
                                'krakow_komisje.id' => $komisja->getId(),
                            ),
                            'aggsPreset' => 'krakow_komisje_dokumenty',
                            'browserTitle' => 'Opinie wydane przez komisję',
                        ));


                    }

                    $this->set('_submenu', array_merge($this->submenus['komisje'], array(
                        'selected' => 'opinie',
                    )));


                    break;


                }

            }


            $this->set('komisja', $komisja);
            $this->set('title_for_layout', $title_for_layout);
            $this->render('komisja-' . $subaction);

        } else {

            if (!isset($this->request->query['conditions']['krakow_komisje.kadencja_id']))
                $this->request->query['conditions']['krakow_komisje.kadencja_id'] = '7';

            $this->_prepareView();

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_komisje',
                ),
                'aggsPreset' => 'krakow_komisje',
                'browserTitle' => 'Komisje Rady Miasta Krakowa',
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
		
		if (isset($this->request->params['subid']) && is_numeric($this->request->params['subid'])) {

            $umowa = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_contracts',
                    'id' => $this->request->params['subid'],
                ),
            ));
            
            $this->set('umowa', $umowa);
            $this->set('title_for_layout', $umowa->getTitle());
            $this->render('umowa');

        } else {

	        $global_aggs = array(
	            'umowy' => array(
	                'filter' => array(
	                    'bool' => array(
	                        'must' => array(
	                            array(
	                                'term' => array(
	                                    'dataset' => 'krakow_contracts',
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
	                                    'field' => 'data.krakow_contracts.kwota',
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
	                'dataset' => 'krakow_contracts',
	            ),
	            'cover' => array(
	                'view' => array(
	                    'plugin' => 'Dane',
	                    'element' => 'gminy/umowy-cover',
	                ),
	                'aggs' => $global_aggs,
	            ),
	            'searchTitle' => 'Szukaj w umowach...',
                'browserTitle' => 'Umowy zawierane przez Urząd Miasta Kraków',
	
	        );
	
	        $this->Components->load('Dane.DataBrowser', $options);
	
	        $this->set('title_for_layout', 'Umowy zawierane przez Urząd Miasta Kraków');
	        $this->set('_submenu', array_merge($this->submenus['urzad'], array(
	            'selected' => 'umowy',
	        )));
        
        }

    }

    public function zamowienia()
    {

        $this->_prepareView();

        $global_aggs = array(
            'procurements' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'procurements',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.procurements_purchasers.gmina_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
	                'announcements' => array(
		                'nested' => array(
			                'path' => 'procurements-announcements',
			            ),
			            'aggs' => array(
				            'pln' => array(
					            'filter' => array(
						            'bool' => array(
							            'must' => array(
								            array(
									            'terms' => array(
										            'procurements-announcements.cena_waluta' => array('pln', 'PLN', 'zł', 'ZŁ'), 
									            ),
								            ),
								            array(
									            'range' => array(
				                                    'procurements-announcements.data_udzielenia_zamowienia' => array(
				                                        'gt' => 'now-3M'
				                                    ),
				                                ),
								            ),
							            ),
						            ),
					            ),
					            'aggs' => array(
						            'histogram' => array(
				                        'date_histogram' => array(
				                            'field' => 'procurements-announcements.data_udzielenia_zamowienia',
				                            'interval' => 'day',
				                        ),
				                        'aggs' => array(
					                        'total_value' => array(
						                        'sum' => array(
							                        'field' => 'procurements-announcements.wartosc_umowy',
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
            ),
            'aggsPreset' => 'zamowienia_publiczne',
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
            'sortPreset' => 'zamowienia_publiczne_dokumenty'
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
		return $this->redirect('https://rejestr.io');
        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'krs_podmioty',
            'browserTitle' => 'Organizacje w gminie ' . $this->object->getData('nazwa'),
        ));

        $this->set('title_for_layout', 'Organizacje w gminie ' . $this->object->getData('nazwa'));
        $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
            'selected' => 'organizacje',
        )));

    }

    public function osoby()
    {
		return $this->redirect('https://rejestr.io');
        $this->request->params['action'] = 'organizacje';
        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_osoby',
                'krs_osoby.gmina_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'krs_osoby',
			'browserTitle' => 'Osoby występujące w Krajowym Rejestrze Sądowym w gminie ' . $this->object->getData('nazwa')
        ));

        $this->set('title_for_layout', 'Osoby w gminie ' . $this->object->getData('nazwa'));
        $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
            'selected' => 'osoby',
        )));

    }

    public function biznes()
    {
		return $this->redirect('https://rejestr.io');
        $this->request->params['action'] = 'organizacje';
        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.gmina_id' => $this->object->getId(),
                'krs_podmioty.forma_prawna_typ_id' => '1',
            ),
            'aggsPreset' => 'krs_podmioty',
            'browserTitle' => 'Organizacje biznesowe w gminie ' . $this->object->getData('nazwa'),
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
		return $this->redirect('https://rejestr.io');
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
                'browserTitle' => 'Organizacje pozarządowe w gminie ' . $this->object->getData('nazwa'),
            ));

            $this->set('title_for_layout', 'Organizacje pozarządowe w gminie ' . $this->object->getData('nazwa'));
            $this->set('_submenu', array_merge($this->submenus['organizacje'], array(
                'selected' => 'ngo',
            )));
        }
    }

    public function spzoz()
    {
		return $this->redirect('https://rejestr.io');
        $this->request->params['action'] = 'organizacje';
        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.gmina_id' => $this->object->getId(),
                'krs_podmioty.forma_prawna_typ_id' => '3',
            ),
            'aggsPreset' => 'krs_podmioty',
            'browserTitle' => 'Samodzielne Publiczne Zakłady Opieki Zdrowotnej w gminie ' . $this->object->getData('nazwa'),
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
                'browserTitle' => 'Urzędnicy Urzędu Miasta',
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
                'browserTitle' => 'Urzędnicy zatrudnieni w tej jednostce',
                'phrases' => array('osoba', 'osoby', 'osób'),
            ));

            $this->set('jednostka', $jednostka);
            $this->set('title_for_layout', $jednostka->getTitle());
            $this->render('jednostka');

        } else {

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_jednostki',
                ),
                'aggsPreset' => 'krakow_jednostki',
                'browserTitle' => 'Jednostki administracyjne Urzędu Miasta',
            ));

            $this->set('title_for_layout', 'Jednostki administracyjne Urzędu Miasta ' . $this->object->getData('nazwa'));
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

    public function mapa_layer()
    {

        App::import('Model', 'Dane.MapLayers');
        $layer = new MapLayers;
        $data = $layer->get_layer($this->request->query['type']);
        $this->set('data', $data);
        $this->set('_serialize', 'data');

    }

    public function mapa()
    {
        $this->_prepareView();
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
        $this->_prepareView();
        $this->request->params['action'] = 'wpf';
        if (isset($this->request->params['subid'])) {

            $program = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'krakow_wpf_programy',
                    'id' => $this->request->params['subid'],
                ),
                'layers' => array(
                    'przedsiewziecia', 'location'
                )
            ));

            if( $this->request->isPost() ) {

                $this->loadModel('Dane.Gmina');
	            $res = $this->Gmina->saveWpf($program->getId(), $this->request->data);

                $this->set('res', $res);
	            $this->set('_serialize', 'res');

                return $this->redirect( $program->getUrl() );

            } else {

	            $this->set('program', $program);
	            $this->set('title_for_layout', $program->getShortTitle());
	            $this->set('superuser', $this->isSuperUser());
                $this->set('can_edit', $this->isSuperUser()); //TODO: should be checking if is permition to change content on page (superuser, admins, moderators, etc)
            }

            $this->render('Dane.Gminy/wpf_program');
        } else {

            $this->set('title_for_layout', 'Wykaz Przedsięwzięć Wieloletnich dla Krakowa');
            $this->set('_submenu', array_merge($this->submenus['wpf'], array(
	            'selected' => 'wpf',
	        )));
            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'krakow_wpf_programy',
                ),
                'browserTitle' => 'Wykaz Przedsięwzięć Wieloletnich dla Krakowa',
                'limit' => 50
            ));


        }
    }

    public function wpf_finanse() {
        $this->addInitLayers(array(
            'wpf'
        ));
        $this->_prepareView();
        $this->request->params['action'] = 'wpf';
        $this->set('title_for_layout', 'Wieloletni Plan Finansowy dla Krakowa');
        $this->set('_submenu', array_merge($this->submenus['wpf'], array(
            'selected' => 'wpf_finanse',
        )));
    }
    
    public function wpf_mapa() {
        $this->addInitLayers(array(
            'wpf_mapa'
        ));
        $this->_prepareView();
        $this->request->params['action'] = 'wpf';
        $this->set('title_for_layout', 'Mapa Wieloletniego Planu Finansowego dla Krakowa');
        $this->set('_submenu', array_merge($this->submenus['wpf'], array(
            'selected' => 'wpf_mapa',
        )));
    }

    public function finanse()
    {

        $this->_prepareView();
        $this->loadModel('Dane.Gmina');

        $population = $this->object->getData('liczba_ludnosci');
        $populationRange = $this->Gmina->getPopulationRange($population);

        $compare = array(
            'items' => array()
        );

        if ($this->object->getData('wojewodzka') == '1') {
            $compare['items'][] = array(
                'id' => 'wojewodzkie',
                'label' => 'Miasta wojewódzkie',
            );
        }

        if ($this->object->getData('powiatowa') == '1') {
            $compare['items'][] = array(
                'id' => 'powiatowe',
                'label' => 'Miasta na prawach powiatów',
            );
        }

        $compare['items'][] = array(
            'id' => 'liczba_ludnosci',
            'label' => 'Gminy w przedziale ludności ' . number_format($populationRange['min']) . ' - ' . number_format($populationRange['max']),
        );

        $compare['items'][] = array(
            'id' => 'wojewodztwo',
            'label' => 'Inne gminy: wojwództwo ' . $this->object->getData('wojewodztwa.nazwa'),
        );

        $types = array(
            '1' => array(
                'id' => 'miejskie',
                'interval' => 100000000, // 100 mln
                'interval_pp' => 100,
            ),
            '3' => array(
                'id' => 'miejsko-wiejskie',
                'interval' => 10000000, // 10 mln
                'interval_pp' => 100,
            ),
            '2' => array(
                'id' => 'wiejskie',
                'interval' => 1000000,  // 1 mln
                'interval_pp' => 100,
            ),
        );

        $types['4'] = $types['1']; // miejskie typ_id IN (1, 4)

        if ($type = $this->object->getData('typ_id')) {
            if (array_key_exists($type, $types)) {

                $type = $types[$type];

                $compare['items'][] = array(
                    'id' => $type['id'],
                    'label' => 'Gminy ' . $type['id'],
                );
            }
        }

        $compare['items'][] = array(
            'id' => 'wszystkie',
            'label' => 'Wszystkie gminy',
        );

        if (!$type)
            $type = $types['1'];

        $mode = false;

        $options = array(
            'data' => array(
                'items' => array(
                    array(
                        'id' => 'wydatki',
                        'label' => 'Wydatki - wartości absolutne',
                    ),
                    array(
                        'id' => 'wydatki_na_osobe',
                        'label' => 'Wydatki w przeliczeniu na osobę'
                    ),
                    array(
                        'id' => 'dochody',
                        'label' => 'Dochody - wartości absolutne',
                    ),
                    array(
                        'id' => 'dochody_na_osobe',
                        'label' => 'Dochody w przeliczeniu na osobę'
                    )
                ),
            ),
            'timerange' => array(
                'items' => array(
                    array(
                        'id' => '2015Q1',
                        'label' => '2015, I kwartał',
                    ),
                    array(
                        'id' => '2014',
                        'label' => '2014, cały rok',
                    ),
                    array(
                        'id' => '2014Q4',
                        'label' => '2014, IV kwartał',
                    ),
                    array(
                        'id' => '2014Q3',
                        'label' => '2014, III kwartał',
                    ),
                    array(
                        'id' => '2014Q2',
                        'label' => '2014, II kwartał',
                    ),
                    array(
                        'id' => '2014Q1',
                        'label' => '2014, I kwartał',
                    ),
                    array(
                        'id' => '2013',
                        'label' => '2013, cały rok',
                    ),
                    array(
                        'id' => '2013Q4',
                        'label' => '2013, IV kwartał',
                    ),
                    array(
                        'id' => '2013Q3',
                        'label' => '2013, III kwartał',
                    ),
                    array(
                        'id' => '2013Q2',
                        'label' => '2013, II kwartał',
                    ),
                    array(
                        'id' => '2013Q1',
                        'label' => '2013, I kwartał',
                    ),
                    array(
                        'id' => '2012',
                        'label' => '2012, cały rok',
                    ),
                    array(
                        'id' => '2012Q4',
                        'label' => '2012, IV kwartał',
                    ),
                    array(
                        'id' => '2012Q3',
                        'label' => '2012, III kwartał',
                    ),
                    array(
                        'id' => '2012Q2',
                        'label' => '2012, II kwartał',
                    ),
                    array(
                        'id' => '2012Q1',
                        'label' => '2012, I kwartał',
                    ),
                ),
            ),
            'compare' => $compare,
        );


        foreach ($options as $key => &$option) {

            $allowed_values = array_column($option['items'], 'id');

            if (
                array_key_exists($key, $this->request->query) &&
                in_array($this->request->query[$key], $allowed_values)
            ) {

                $option['selected_id'] = $this->request->query[$key];
                $option['selected_i'] = array_search($this->request->query[$key], $allowed_values);

            } else {

                $option['selected_id'] = $option['items'][0]['id'];
                $option['selected_i'] = 0;

            }

        }

        $this->set('filter_options', $options);

        $main_chart = array();


        // DATA

        $data = $options['data']['items'][$options['data']['selected_i']]['id'];
        $field = 'wydatki';
        $dataset = 'wydatki';
        $histogram_interval = $type['interval'];

        if ($data == 'wydatki') {

            $mode = 'absolute';
            $main_chart['title'] = 'Wydatki - wartości absolutne';

        } elseif ($data == 'wydatki_na_osobe') {

            $mode = 'perperson';
            $main_chart['title'] = 'Wydatki w przeliczeniu na osobę';
            $field = 'wydatki_pp';
            $histogram_interval = $type['interval_pp'];
            $this->histogramIntervals = array(
                100,
                50,
                20,
                10
            );

        } elseif( $data == 'dochody') {

            $mode = 'absolute';
            $main_chart['title'] = 'Dochody - wartości absolutne';
            $field = 'dochody';
            $dataset = 'dochody';

        } elseif( $data = 'dochody_pp') {

            $mode = 'perperson';
            $main_chart['title'] = 'Dochody w przeliczeniu na osobę';
            $field = 'dochody_pp';
            $dataset = 'dochody';
            $this->histogramIntervals = array(
                100,
                50,
                20,
                10
            );

        }


        $histogramAggs = array();
        foreach ($this->histogramIntervals as $i => $interval) {
            $histogramAggs['histogram_' . $i] = array(
                'histogram' => array(
                    'field' => 'gminy-'. $dataset . '-dzialy.' . $field,
                    'interval' => $interval,
                    'min_doc_count' => 1,
                ),
            );
        }

        // TIMERANGE

        $timerange = $options['timerange']['items'][$options['timerange']['selected_i']]['id'];

        if (preg_match('/^([0-9]{4})$/', $timerange)) {
            $rok = (int)$timerange;
            $kwartal = 0;
        } elseif (preg_match('/^([0-9]{4})Q([0-4]{1})$/', $timerange)) {
            $p = explode('Q', $timerange);
            $rok = (int)$p[0];
            $kwartal = (int)$p[1];
        } else {
            throw new NotFoundException;
        }


        // COMPARE

        $compare = $options['compare']['items'][$options['compare']['selected_i']]['id'];

        if ($compare == 'wszystkie') {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' ze wszystkimi gminami';

            $histogram_interval = $mode == 'absolute' ? 100000000 : $type['interval_pp'];

        } elseif ($compare == 'powiatowe') {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z miastami na prawach powiatu';


        } elseif ($compare == 'wojewodzkie') {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.wojewodzka' => '1',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z gminami wojewódzkimi';


        } elseif ($compare == 'miejskie') {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.typ_id' => array('1', '4'),
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z gminami miejskimi';

        } elseif ($compare == 'miejsko-wiejskie') {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.typ_id' => '3',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z gminami miejsko-wiejskimi';

        } elseif ($compare == 'wiejskie') {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.typ_id' => '2',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z gminami wiejskimi';

        } elseif ($compare == 'liczba_ludnosci') {

            $gminy_filter = array(
                'range' => array(
                    'data.gminy.liczba_ludnosci' => array(
                        'gte' => $populationRange['min'],
                        'lt' => $populationRange['max']
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z gminami w przedziale ludności ' . number_format($populationRange['min']) . ' - ' . number_format($populationRange['max']);

        } elseif ($compare == 'wojewodztwo') {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.wojewodztwo_id' => $this->object->getData('wojewodztwo_id'),
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z gminami w tym samym województwie';
        }


        $aggs = array(
            'gminy' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => $gminy_filter,
                    ),
                ),
                'scope' => 'global',
                'aggs' => array(
                    /*
                    'top' => array(
                        'top_hits' => array(
                            'size' => 100,
                        ),
                    ),
                    */
                    'sumy' => array(
                        'nested' => array(
                            'path' => 'gminy-' . $dataset . '-okresy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-okresy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-okresy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'min' => array(
                                        'terms' => array(
                                            'field' => 'gminy-' . $dataset . '-okresy.' . $field,
                                            'size' => '1',
                                            'order' => array(
                                                '_term' => 'asc',
                                            ),
                                        ),
                                        'aggs' => array(
                                            'reverse' => array(
                                                'reverse_nested' => '_empty',
                                                'aggs' => array(
                                                    'top' => array(
                                                        'top_hits' => array(
                                                            'size' => 1,
                                                            '_source' => array(
	                                                            'include' => 'data.*',
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'max' => array(
                                        'terms' => array(
                                            'field' => 'gminy-' . $dataset . '-okresy.' . $field,
                                            'size' => '1',
                                            'order' => array(
                                                '_term' => 'desc',
                                            ),
                                        ),
                                        'aggs' => array(
                                            'reverse' => array(
                                                'reverse_nested' => '_empty',
                                                'aggs' => array(
                                                    'top' => array(
                                                        'top_hits' => array(
                                                            'size' => 1,
                                                            '_source' => array(
	                                                            'include' => 'data.*',
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'percentiles' => array(
                                        'percentiles' => array(
                                            'field' => 'gminy-' . $dataset . '-okresy.' . $field,
                                            'percents' => array(50),
                                        ),
                                    ),
                                    'stats' => array(
                                        'stats' => array(
                                            'field' => 'gminy-' . $dataset . '-okresy.' . $field,
                                        ),
                                    ),
                                    'histogram' => array(
                                        'histogram' => array(
                                            'field' => 'gminy-' . $dataset . '-okresy.' . $field,
                                            'interval' => $histogram_interval,
                                            'min_doc_count' => 1
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    
                    'dzialy' => array(
                        'nested' => array(
                            'path' => 'gminy-' . $dataset . '-dzialy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-dzialy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-dzialy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'dzialy' => array(
                                        'terms' => array(
                                            'field' => 'gminy-' . $dataset . '-dzialy.dzial_id',
                                            'size' => 100,
                                        ),
                                        'aggs' => array_merge(array(
                                            'label' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-' . $dataset . '-dzialy.dzial',
                                                    'size' => 1,
                                                ),
                                            ),
                                            'min' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-' . $dataset . '-dzialy.' . $field,
                                                    'size' => 1,
                                                    'order' => array(
                                                        '_term' => 'asc',
                                                    ),
                                                ),
                                                'aggs' => array(
                                                    'reverse' => array(
                                                        'reverse_nested' => '_empty',
                                                        'aggs' => array(
                                                            'top' => array(
                                                                'top_hits' => array(
                                                                    'size' => 1,
                                                                    '_source' => array(
			                                                            'include' => 'data.*',
		                                                            ),
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'max' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-' . $dataset . '-dzialy.' . $field,
                                                    'size' => 1,
                                                    'order' => array(
                                                        '_term' => 'desc',
                                                    ),
                                                ),
                                                'aggs' => array(
                                                    'reverse' => array(
                                                        'reverse_nested' => '_empty',
                                                        'aggs' => array(
                                                            'top' => array(
                                                                'top_hits' => array(
                                                                    'size' => 1,
                                                                    '_source' => array(
			                                                            'include' => 'data.*',
		                                                            ),
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'percentiles' => array(
                                                'percentiles' => array(
                                                    'field' => 'gminy-' . $dataset . '-dzialy.' . $field,
                                                    'percents' => array(50),
                                                ),
                                            ),
                                            'stats' => array(
                                                'stats' => array(
                                                    'field' => 'gminy-' . $dataset . '-dzialy.' . $field,
                                                ),
                                            ),
                                        ),
                                            $histogramAggs
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'gmina' => array(
                'scope' => 'global',
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'gminy',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'id' => $this->object->getId(),
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'sumy' => array(
                        'nested' => array(
                            'path' => 'gminy-' . $dataset . '-okresy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-okresy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-okresy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    $dataset => array(
                                        'sum' => array(
                                            'field' => 'gminy-' . $dataset . '-okresy.' . $field,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'dzialy' => array(
                        'nested' => array(
                            'path' => 'gminy-' . $dataset . '-dzialy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-dzialy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-dzialy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'dzialy' => array(
                                        'terms' => array(
                                            'field' => 'gminy-' . $dataset . '-dzialy.dzial_id',
                                            'size' => 100,
                                            'order' => array(
                                                $dataset => 'desc',
                                            ),
                                        ),
                                        'aggs' => array(
                                            'label' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-' . $dataset . '-dzialy.dzial',
                                                    'size' => 1,
                                                ),
                                            ),
                                            $dataset => array(
                                                'sum' => array(
                                                    'field' => 'gminy-' . $dataset . '-dzialy.' . $field,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'rozdzialy' => array(
                        'nested' => array(
                            'path' => 'gminy-' . $dataset . '-rozdzialy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-rozdzialy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-' . $dataset . '-rozdzialy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'dzialy' => array(
                                        'terms' => array(
                                            'field' => 'gminy-' . $dataset . '-rozdzialy.dzial_id',
                                            'size' => 100,
                                        ),
                                        'aggs' => array(
                                            'rozdzialy' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-' . $dataset . '-rozdzialy.rozdzial_id',
                                                    'size' => 100,
                                                    'order' => array(
                                                        $dataset => 'desc',
                                                    ),
                                                ),
                                                'aggs' => array(
                                                    'nazwa' => array(
                                                        'terms' => array(
                                                            'field' => 'gminy-' . $dataset . '-rozdzialy.rozdzial',
                                                            'size' => 1,
                                                        ),
                                                    ),
                                                    $dataset => array(
                                                        'sum' => array(
                                                            'field' => 'gminy-' . $dataset . '-rozdzialy.' . $field,
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
        );

        //debug($aggs); die();

        $options = array(
            'searcher' => false,
            'searchTitle' => 'Szukaj w budżecie gminy ' . $this->object->getTitle() . '...',
            'conditions' => array(),
            'cover' => array(
                'force' => true,
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'gminy/wydatki-cover',
                ),
                'aggs' => $aggs,
            ),
        );

        $this->Components->load('Dane.DataBrowser', $options);

        $this->request->params['action'] = 'finanse';
        $this->set('title_for_layout', ucfirst($dataset) . ' w gminie ' . $this->object->getTitle());
        $this->set('main_chart', $main_chart);
        $this->set('mode', $mode);
        $this->set('histogram_interval', $histogram_interval);
        $this->set('_submenu', array_merge($this->submenus['finanse'], array(
            'selected' => '',
        )));

    }

    public function okregi()
    {

        $this->request->params['action'] = 'rada';
        $this->_prepareView();

        if ($this->object->getId() != '903')
            throw new NotFoundException;

        $this->loadModel('PrzejrzystyKrakow.Krakow');

        if ($subid = @$this->request->params['subid']) {

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
                                    '_source' => array(
                                        'include' => 'data.*',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'layers' => array('geo', 'data')
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
    public function aktywnosci() {
        $this->request->params['action'] = 'rada';
        $this->_prepareView();

        if ($this->object->getId() != '903')
            throw new NotFoundException;

        $this->loadModel('Dane.GminyKrakowRadni');

        $activityQuery = array('type' => 'activity');
        if(isset($this->request->query['m']))
            $activityQuery['m'] = $this->request->query['m'];
        $this->set('activity_ranking', $this->GminyKrakowRadni->getRanking($activityQuery));
        $this->set('openness_ranking', $this->GminyKrakowRadni->getRanking(array(
            'type' => 'openness'
        )));

        $this->set('aggs',  $this->Dataobject->getAggs());

        $this->set('_submenu', array_merge($this->submenus['rada'], array(
            'selected' => 'aktywnosci',
        )));

        $this->set('title_for_layout', 'Ranking aktywności Rady Miasta Kraków');
    }
    */

    public function glosuj() {
        $this->_prepareView();

        if($this->object->getId() != '903')
            throw new NotFoundException;

        if($this->Session->check(self::$voteSessionName))
            $this->set('vote', $this->Session->read(self::$voteSessionName));

        if(isset($this->request->data['start'])) { /* Rozpoczęcie głosowania */

            $druki = $this->Dataobject->find('all', array(
                'conditions' => array(
                    'dataset' => 'krakow_rada_uchwaly',
                    'krakow_rada_uchwaly.druki' => 'true',
                ),
                'limit' => 10
            ));

            $fields = array('id', 'tytul', 'opis', 'data');
            $_druki = array();
            foreach($druki as $druk) {
                $data = $druk->getData();
                $row = array(
                    'vote' => false
                );
                foreach($fields as $f)
                    $row[$f] = $data[$f];
                $row['tytul'] = 'Uchwała ' . $data['tytul_skrocony'];
                $_druki[] = $row;
            }

            $this->Session->write(self::$voteSessionName, $_druki);

            $this->redirect(
                (isset($this->domainMode) && $this->domainMode == 'MP' ?
                    '/dane/gminy/903,krakow/rada_uchwaly/' . $_druki[0]['id']
                    : '/rada_uchwaly/' . $_druki[0]['id']
                )
            );

        } elseif(isset($this->request->query['reset'])) {

            $this->Session->delete(self::$voteSessionName);
            $this->redirect(
                (isset($this->domainMode) && $this->domainMode == 'MP' ?
                    '/dane/gminy/903,krakow/glosuj'
                    : '/glosuj'
                )
            );

        } elseif( /* Oddany głos */
            $this->Session->check(self::$voteSessionName) &&
            isset($this->request->data['vote']) &&
            isset($this->request->data['vote_id'])
        ) {
            $dict = array(
                'Za' => 1,
                'Wstrzymuje się' => 0,
                'Przeciw' => -1
            );
            $user_vote = $this->request->data['vote'];
            if (!in_array($user_vote, array_keys($dict)))
                throw new NotFoundException;
            $user_vote = (int)$dict[$user_vote];

            $vote_id = (int)$this->request->data['vote_id'];
            $votes = $this->Session->read(self::$voteSessionName);
            $next = 0;
            $completed = true;

            foreach ($votes as $v => $vote) {
                if ($votes[$v]['id'] == $vote_id) {
                    $votes[$v]['vote'] = $user_vote;
                }

                if ($next === 0 && $votes[$v]['vote'] === false) {
                    $next = (int) $votes[$v]['id'];
                    $completed = false;
                }
            }

            $this->Session->write(self::$voteSessionName, $votes);

            if ($completed === false && $next !== false) {
                $this->redirect(
                    (isset($this->domainMode) && $this->domainMode == 'MP' ?
                        '/dane/gminy/903,krakow/rada_uchwaly/' . $next
                        : '/rada_uchwaly/' . $next
                    )
                );
            }

            if($completed === true) {
                $this->redirect(
                    (isset($this->domainMode) && $this->domainMode == 'MP' ?
                        '/dane/gminy/903,krakow/glosuj/'
                        : '/glosuj'
                    )
                );
            }


        } elseif(
            $this->Session->check(self::$voteSessionName)
        ) { /* Zakończono głosowanie lub nie ($completed) */

            $votes = $this->Session->read(self::$voteSessionName);
            $completed = true;
            $next = 0;

            foreach ($votes as $v => $vote) {
                if ($votes[$v]['vote'] === false)
                    $completed = false;

                if ($next === 0 && $votes[$v]['vote'] === false) {
                    $next = (int) $votes[$v]['id'];
                    $completed = false;
                }
            }

            if ($completed === true) {

                /* Głosuj dalej */
                if(isset($this->request->query['more'])) {
                    $votes = $this->Session->read(self::$voteSessionName);

                    $druki = $this->Dataobject->find('all', array(
                        'conditions' => array(
                            'dataset' => 'krakow_rada_uchwaly',
                            'krakow_rada_uchwaly.druki' => 'true',
                            'id!=' => array_column($votes, 'id'),
                        ),
                        'limit' => 10
                    ));

                    $fields = array('id', 'tytul', 'opis', 'data');
                    $_druki = array();
                    foreach($druki as $druk) {
                        $data = $druk->getData();
                        $row = array(
                            'vote' => false
                        );
                        foreach($fields as $f)
                            $row[$f] = $data[$f];
                        $row['tytul'] = 'Uchwała ' . $data['tytul_skrocony'];
                        $_druki[] = $row;
                    }

                    foreach($votes as $vote) {
                        $_druki[] = $vote;
                    }

                    $this->Session->write(self::$voteSessionName, $_druki);

                    $this->redirect(
                        (isset($this->domainMode) && $this->domainMode == 'MP' ?
                            '/dane/gminy/903,krakow/rada_uchwaly/' . $_druki[0]['id']
                            : '/rada_uchwaly/' . $_druki[0]['id']
                        )
                    );
                }

                $userVotes = array();
                foreach($votes as $vote) {
                    $userVotes[] = array(
                        'uchwala_id' => $vote['id'],
                        'vote' => $vote['vote']
                    );
                }
                $this->loadModel('Dane.Gmina');
                $results = $this->Gmina->getRadniByUserVotes($userVotes);

                $radni = $this->Dataobject->find('all', array(
                    'conditions' => array(
                        'dataset' => 'radni_gmin',
                        'id' => array_keys($results),
                    ),
                ));

                foreach($radni as $r => $radny) {
                    foreach($results as $id => $fit) {
                        if($radny->getId() == $id) {
                            $radni[$r]->data['fit'] = $fit;
                        }
                    }
                }

                usort($radni, function($a, $b) {
                    return $a->data['fit'] < $b->data['fit'];
                });

                $this->set('completed', $completed);
                $this->set('radni', $radni);
            }

            $this->set('next', $next);


        } else { /* Strona startowa */

        }
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
            $aggs = array_merge($aggs, $this->object_aggs);

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

            /*$menu['items'][] = array(
               'id' => 'mapa',
               'label' => 'Mapa',
           );

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
			
			/*
            if (isset($aggs['zamowienia']) && $aggs['zamowienia']['doc_count'])
                $menu['items'][] = array(
                    'label' => 'Zamówienia publiczne',
                    'id' => 'zamowienia',
                    'count' => $aggs['zamowienia']['doc_count'],
                );
			*/
			
            $menu['items'][] = array(
                'label' => 'KRS',
                'id' => 'organizacje',
            );

        }

        $menu['items'][] = array(
            'id' => 'finanse',
            'label' => 'Finanse',
        );

        if (
            ($this->object->getId() != '903') &&
	        (
	            @$this->object_aggs['dzialania']['doc_count'] ||
	            $this->_canEdit()
            )
        ) {
            $menu['items'][] = array(
                'id' => 'dzialania',
                'label' => 'Działania',
                'count' => @$this->object_aggs['dzialania']['doc_count'],
            );
        }

        if (
            ($this->object->getId() != '903') &&
        	$this->_canEdit()
        ) {
            $menu['items'][] = array(
                'id' => 'dane',
                'label' => 'Edycja danych'
            );
        }


        if ($object->getId() == '903') {

            $menu['items'][] = array(
	            'id' => 'wpf',
	            'label' => 'Wieloletnia Prognoza Finansowa',
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


            if ($this->request->params['action'] == 'finanse') {

                $aggs = $this->viewVars['dataBrowser']['aggs'];
                $this->viewVars['dataBrowser']['aggs'] = null;

                $dataset = 'wydatki';
                if(empty($aggs['gmina']['sumy']['timerange'][$dataset]))
                    $dataset = 'dochody';
						
								
                $global = array(
                    'min' => array(
                        'value' => $aggs['gminy']['sumy']['timerange']['min']['buckets'][0]['key'],
                        'label' => $aggs['gminy']['sumy']['timerange']['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                        'id' => $aggs['gminy']['sumy']['timerange']['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                    ),
                    'max' => array(
                        'value' => $aggs['gminy']['sumy']['timerange']['max']['buckets'][0]['key'],
                        'label' => $aggs['gminy']['sumy']['timerange']['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                        'id' => $aggs['gminy']['sumy']['timerange']['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                    ),
                    'cur' => $aggs['gmina']['sumy']['timerange'][$dataset]['value'],
                    'median' => $aggs['gminy']['sumy']['timerange']['percentiles']['values']['50.0'],
                    'histogram' => $aggs['gminy']['sumy']['timerange']['histogram']['buckets'],
                );

                $global = array_merge($global, array(
                    'left' => ($global['min']['value'] == $global['max']['value']) ? 0 : 100 * ($global['cur'] - $global['min']['value']) / ($global['max']['value'] - $global['min']['value']),
                    'median_left' => ($global['min']['value'] == $global['max']['value']) ? 0 : 100 * ($global['median'] - $global['min']['value']) / ($global['max']['value'] - $global['min']['value']),
                ));


                $dzialy = array();

                foreach ($aggs['gmina']['dzialy']['timerange']['dzialy']['buckets'] as $b) {

                    $dzial = array(
                        'id' => $b['key'],
                        'label' => @$b['label']['buckets'][0]['key'],
                    );

                    foreach ($aggs['gminy']['dzialy']['timerange']['dzialy']['buckets'] as $d) {
                        if ($d['key'] == $b['key']) {

                            $min = (int)$d['min']['buckets'][0]['key'];
                            $max = (int)$d['max']['buckets'][0]['key'];
                            $range = $max - $min;

                            $histogram_i = (string)(count($this->histogramIntervals) - 1);

                            foreach ($this->histogramIntervals as $i => $interval) {
                                $buckets = ceil($range / $interval);
                                if ($buckets > 8 && $buckets < 100) {
                                    $histogram_i = $i;
                                    break;
                                }
                            }

                            if ($range > 300000 && $histogram_i == (count($this->histogramIntervals) - 1)) {
                                $histogram_i = (string)(count($this->histogramIntervals) - 2);
                            }

                            $dzial['global'] = array(
                                'min' => array(
                                    'value' => $d['min']['buckets'][0]['key'],
                                    'label' => $d['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                                    'id' => $d['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                                ),
                                'max' => array(
                                    'value' => $d['max']['buckets'][0]['key'],
                                    'label' => $d['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                                    'id' => $d['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                                ),
                                'cur' => $b[$dataset]['value'],
                                'median' => $d['percentiles']['values']['50.0'],
                                'histogram' => $d['histogram_' . $histogram_i]['buckets'],
                                'interval' => $this->histogramIntervals[(int)$histogram_i]
                            );

                            $dzial['global'] = array_merge($dzial['global'], array(
                                'left' => ($dzial['global']['min']['value'] == $dzial['global']['max']['value']) ? 0 : 100 * ($dzial['global']['cur'] - $dzial['global']['min']['value']) / ($dzial['global']['max']['value'] - $dzial['global']['min']['value']),
                                'median_left' => ($dzial['global']['min']['value'] == $dzial['global']['max']['value']) ? 0 : 100 * ($dzial['global']['median'] - $dzial['global']['min']['value']) / ($dzial['global']['max']['value'] - $dzial['global']['min']['value']),
                                'class' => ($dzial['global']['cur'] > $dzial['global']['median']) ? 'more' : 'less',
                            ));

                            break;

                        }
                    }

                    foreach ($aggs['gmina']['rozdzialy']['timerange']['dzialy']['buckets'] as &$c) {
                        if ($c['key'] == $dzial['id']) {

                            $rozdzialy = $c['rozdzialy']['buckets'];
                            foreach ($rozdzialy as &$r) {

                                if (!$r['key'])
                                    continue;

                                $r = array(
                                    'id' => $r['key'],
                                    'label' => $r['nazwa']['buckets'][0]['key'],
                                    'wydatki' => $r[$dataset]['value'],
                                );

                            }

                            $dzial['rozdzialy'] = $rozdzialy;

                            unset($c);
                            break;

                        }
                    }

                    $dzialy[] = $dzial;

                }

                // debug( $dzialy ); die();

                $this->set('global', $global);
                $this->set('dzialy', $dzialy);

            }

        }

    }

    public function radni_ranking() {
        $this->_prepareView();
        if($this->object->getId() != '903')
            throw new NotFoundException;

        $this->loadModel('Dane.GminyKrakowRadni');
        $this->set('results', $this->GminyKrakowRadni->getRanking($this->request->query));
        $this->set('_serialize', array('results'));
    }

}
