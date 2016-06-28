<?php

class DataBrowserComponent extends Component
{

    public $settings = array();
    public $conditions = array();
    public $order = array();
    private $Dataobject = false;
    private $aggs_visuals_map = array();
    private $cover = false;
    private $chapters = array();
    private $searchTitle = false;
    private $browserTitle = false;
    private $browserTitleElement = false;
    private $searchTag = false;
    private $autocompletion = false;
    private $aggsMode = false;
    private $searcher = true;
    private $routes = array();
    public $dataset = false;
    public $searchAction = false;
    public $type = 'objects';
    public $observe = false;
		
	private $phrases_presets = array(
		'krakow_posiedzenia' => array(
			'paginator' => array('posiedzenie', 'posiedzenia', 'posiedzeń'),
		),
		'ustawy' => array(
			'paginator' => array('ustawa', 'ustawy', 'ustaw'),
		),
		'rozporzadzenia' => array(
			'paginator' => array('rozporządzenie', 'rozporządzenia', 'rozporządzeń'),
		),
		'umowy_miedzynarodowe' => array(
			'paginator' => array('umowa', 'umowy', 'umów'),
		),
		'akty_prawne' => array(
			'paginator' => array('akt prawny', 'akty prawne', 'aktów prawnych'),
		),
		'rady_gmin_interpelacje' => array(
			'paginator' => array('interpelacja', 'interpelacje', 'interpelacji'),
		),
		'rady_druki' => array(
			'paginator' => array('projekt', 'projekty', 'projektów'),
		),
		'krakow_rada_uchwaly' => array(
			'paginator' => array('uchwała', 'uchwały', 'uchwał'),
		),
		'msig_pozycje' => array(
			'paginator' => array('ogłoszenie', 'ogłoszenia', 'ogłoszeń'),
		),
	);

	private $sort_presets = array(
		'prawo' => array(
			'prawo.data_publikacji' => array(
				'label' => 'Data publikacji',
				'options' => array(
					'desc' => 'od najnowszych',
					'asc' => 'od najstarszych',
				),
			),
			'prawo.data_wejscia_w_zycie' => array(
				'label' => 'Data wejścia w życie',
				'options' => array(
					'asc' => 'od najwcześniejszych',
					'desc' => 'od najpóźniejszych',
				),
			),
		),
		'dziennik_ustaw' => array(
			'dziennik_ustaw.data_publikacji' => array(
				'label' => 'Data publikacji',
				'options' => array(
					'desc' => 'od najnowszych',
					'asc' => 'od najstarszych',
				),
			),
			'dziennik_ustaw.data_wejscia_w_zycie' => array(
				'label' => 'Data wejścia w życie',
				'options' => array(
					'asc' => 'od najwcześniejszych',
					'desc' => 'od najpóźniejszych',
				),
			),
		),
		'monitor_polski' => array(
			'monitor_polski.data_publikacji' => array(
				'label' => 'Data publikacji',
				'options' => array(
					'desc' => 'od najnowszych',
					'asc' => 'od najstarszych',
				),
			),
			'monitor_polski.data_wejscia_w_zycie' => array(
				'label' => 'Data wejścia w życie',
				'options' => array(
					'asc' => 'od najwcześniejszych',
					'desc' => 'od najpóźniejszych',
				),
			),
		),
		'rady_gmin_interpelacje' => array(
			'date' => array(
				'label' => 'Data wysłania',
				'options' => array(
					'desc' => 'od najnowszych',
					'asc' => 'od najstarszych',
				),
			),
		),
		'krakow_rada_uchwaly' => array(
			'date' => array(
				'label' => 'Data wydania',
				'options' => array(
					'desc' => 'od najnowszych',
					'asc' => 'od najstarszych',
				),
			),
		),
        'krakow_posiedzenia' => array(
            'date' => array(
                'label' => 'Data posiedzenia',
                'options' => array(
                    'desc' => 'od najnowszych',
                    'asc' => 'od najstarszych',
                ),
            ),
        ),
        'rady_durki' => array(
            'date' => array(
                'label' => 'Data wydania',
                'options' => array(
                    'desc' => 'od najnowszych',
                    'asc' => 'od najstarszych',
                ),
            ),
        ),
        'krakow_komisje_posiedzenia' => array(
            'date' => array(
                'label' => 'Data posiedzenia',
                'options' => array(
                    'desc' => 'od najnowszych',
                    'asc' => 'od najstarszych',
                ),
            ),
        ),
        'krakow_zarzadzenia' => array(
            'date' => array(
                'label' => 'Data zarządzenia',
                'options' => array(
                    'desc' => 'od najnowszych',
                    'asc' => 'od najstarszych',
                ),
            ),
        ),
        'zamowienia_publiczne_dokumenty' => array(
            'date' => array(
                'label' => 'Data rozstrzygnięcia',
                'options' => array(
                    'desc' => 'od najnowszych',
                    'asc' => 'od najstarszych',
                ),
            ),
        ),
	);

    private $aggs_presets = array(
        'ngo_konkursy' => array(
            'area' => array(
                'terms' => array(
                    'field' => 'ngo_konkursy.area_id',
                ),
                'visual' => array(
                    'label' => 'Obszar tematyczny',
                    'skin' => 'list',
                    'field' => 'ngo_konkursy.area_id',
                    'all' => 'Wszystkie obszary tematyczne',
                    'dict' => 'ngo_konkursy_areas',
                ),
            ),
         ),
        'msig_pozycje' => array(
            'dzial' => array(
                'terms' => array(
                    'field' => 'msig_dzialy.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Działy',
                    'skin' => 'list',
                    'field' => 'msig_dzialy.typ_id',
                    'all' => 'Wszystkie działy',
                    'dict' => 'msig_dzialy_typy',
                ),
            ),
            'forma_prawna' => array(
                'terms' => array(
                    'field' => 'msig_pozycje.krs_forma_prawna_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Formy prawne',
                    'skin' => 'list',
                    'field' => 'msig_pozycje.krs_forma_prawna_id',
                    'all' => 'Wszystkie formy prawne',
                    'dict' => 'krs_formy_prawne',
                ),
            ),
         ),
        'bdl_wskazniki' => array(
            'kategoria_id' => array(
                'terms' => array(
                    'field' => 'bdl_wskazniki.kategoria_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.bdl_wskazniki.kategoria_tytul',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Kategorie',
                    'skin' => 'list',
                    'field' => 'bdl_wskazniki.kategoria_id',
                    'all' => 'Wszystkie kategorie',
                ),
            ),
            'grupa_id' => array(
                'terms' => array(
                    'field' => 'bdl_wskazniki.grupa_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.bdl_wskazniki.grupa_tytul',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Grupy',
                    'skin' => 'list',
                    'field' => 'bdl_wskazniki.grupa_id',
                    'all' => 'Wszystkie grupy',
                ),
            ),
        ),
        'bdl_wskazniki_grupy' => array(
            'kategoria_id' => array(
                'terms' => array(
                    'field' => 'bdl_wskazniki_grupy.kategoria_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.bdl_wskazniki_grupy.tytul',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Kategorie',
                    'skin' => 'list',
                    'field' => 'bdl_wskazniki_grupy.kategoria_id',
                    'all' => 'Wszystkie kategorie',
                ),
            ),
        ),
        'urzednicy' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'urzednicy.stanowisko_aktywne',
                ),
                'visual' => array(
                    'label' => 'Status',
                    'skin' => 'list',
                    'field' => 'urzednicy.stanowisko_aktywne',
                    'dictionary' => array(
                        '0' => 'Urzędujący w przeszłości',
                        '1' => 'Aktualnie urzędujący',
                    ),
                    'all' => 'Wszyscy urzędnicy',
                ),
            ),
        ),
        'gminy' => array(
            'wojewodztwo_id' => array(
                'terms' => array(
                    'field' => 'gminy.wojewodztwo_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.wojewodztwa.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Województwa',
                    'skin' => 'list',
                    'field' => 'gminy.wojewodztwo_id',
                    'all' => 'Wszystkie województwa',
                ),
            ),
            'powiat_id' => array(
                'terms' => array(
                    'field' => 'gminy.powiat_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.powiaty.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Powiaty',
                    'skin' => 'list',
                    'field' => 'gminy.powiat_id',
                    'all' => 'Wszystkie powiaty',
                ),
            ),
            'typ_id' => array(
                'terms' => array(
                    'field' => 'gminy.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy gmin',
                    'skin' => 'list',
                    'field' => 'gminy.typ_id',
                    'dictionary' => array(
                        '1' => 'Gmina miejska',
                        '2' => 'Gmina wiejska',
                        '3' => 'Gmina miejsko-wiejska',
                        '4' => 'Miasto stołeczne',
                    ),
                    'all' => 'Wszystkie typy gmin',
                ),
            ),
        ),
        'powiaty' => array(
            'wojewodztwo_id' => array(
                'terms' => array(
                    'field' => 'powiaty.wojewodztwo_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.wojewodztwa.nazwa',
                            'size' => '1',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Województwo',
                    'skin' => 'list',
                    'params' => array(
                        'unit' => 'wojewodztwa',
                    ),
                    'all' => 'Wszystkie województwa',
                    'field' => 'powiaty.wojewodztwo_id',
                ),
            ),
            'typ_id' => array(
                'terms' => array(
                    'field' => 'powiaty.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy powiatów',
                    'skin' => 'list',
                    'field' => 'powiaty.typ_id',
                    'all' => 'Wszystkie typy powiatów',
                    'dictionary' => array(
                        '1' => 'Powiat',
                        '2' => 'Miasto na prawach powiatu',
                        '3' => 'Miasto stołeczne',
                    ),
                ),
            ),
            
        ),
        'miejscowosci' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'miejscowosci.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'miejscowosci_typy.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy miejscowości',
                    'skin' => 'pie_chart',
                    'field' => 'miejscowosci.typ_id'
                ),
            ),
        ),
        'twitter_accounts' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'twitter_accounts.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy obserwowanych kont',
                    'all' => 'Wszystkie obserwowane konta',
                    'skin' => 'list',
                    'field' => 'twitter_accounts.typ_id',
                    'dictionary' => array(
                        '2' => 'Komentatorzy polityczni',
                        '3' => 'Urzędy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partie polityczne',
                        '9' => 'NGO',
                        '10' => 'Miasta',
                    ),
                ),
            ),
        ),
        'fb_accounts' => array(
            'type_id' => array(
                'terms' => array(
                    'field' => 'fb_accounts.type_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy obserwowanych kont',
                    'all' => 'Wszystkie obserwowane konta',
                    'skin' => 'list',
                    'field' => 'fb_accounts.type_id',
                    'dictionary' => array(
                        '2' => 'Komentatorzy polityczni',
                        '3' => 'Urzędy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partie polityczne',
                        '9' => 'NGO',
                        '10' => 'Miasta',
                    ),
                ),
            ),
        ),
        'twitter' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba tweetów w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Kiedykolwiek',
                ),
            ),
            'account_id' => array(
                'terms' => array(
                    'field' => 'twitter.twitter_account_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.twitter_accounts.name',
                            'size' => 1,
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Konta',
                    'all' => 'Wszystkie konta',
                    'skin' => 'list',
                    'field' => 'twitter.twitter_account_id',
                ),
            ),
            'typ_id' => array(
                'terms' => array(
                    'field' => 'twitter_accounts.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy kont',
                    'all' => 'Wszystkie typy kont',
                    'skin' => 'list',
                    'field' => 'twitter_accounts.typ_id',
                    'dictionary' => array(
                        '2' => 'Komentatorzy polityczni',
                        '3' => 'Urzędy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partie polityczne',
                        '9' => 'NGO',
                        '10' => 'Miasta',
                    ),
                ),
            ),
        ),
        'fb_posts' => array(
            'type_id' => array(
                'terms' => array(
                    'field' => 'fb_accounts.type_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy kont',
                    'all' => 'Wszystkie typy kont',
                    'skin' => 'list',
                    'field' => 'fb_accounts.type_id',
                    'dictionary' => array(
                        '2' => 'Komentatorzy polityczni',
                        '3' => 'Urzędy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partie polityczne',
                        '9' => 'NGO',
                        '10' => 'Miasta',
                    ),
                ),
            ),
            'account_id' => array(
                'terms' => array(
                    'field' => 'fb_accounts.id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.fb_accounts.name',
                            'size' => 1,
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Konta',
                    'all' => 'Wszystkie konta',
                    'skin' => 'list',
                    'field' => 'fb_accounts.id',
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba postów w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'zamowienia_publiczne_dokumenty' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba rozstrzygnięć w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'rady_druki' => array(
            'autor_id' => array(
                'terms' => array(
                    'field' => 'rady_druki.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.rady_druki.autor_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy projektów',
                    'all' => 'Wszyscy autorzy',
                    'skin' => 'pie_chart',
                    'field' => 'rady_druki.autor_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba druków w czasie',
                    'all' => 'Złożone kiedykolwiek',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'prawo_wojewodztwa' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba aktów prawnych w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'prawo_urzedowe' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba aktów prawnych w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'sejm_interpelacje' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba interpelacji w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'krakow_posiedzenia' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba posiedzeń w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Przeprowadzone kiedykolwiek',
                ),
            ),
        ),
        'krakow_rada_uchwaly' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'krakow_rada_uchwaly.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy uchwał',
                    'all' => 'Wszystkie typy',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_rada_uchwaly.typ_id',
                    'dictionary' => array(
                        '1' => 'Uchwały',
                        '2' => 'Rezolucje',
                    ),
                ),
            ),
            'kadencja' => array(
                'terms' => array(
                    'field' => 'krakow_rada_uchwaly.kadencja_id',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                    'exclude' => array(
	                    'pattern' => '0',
                    ),
                ),
                'visual' => array(
                    'label' => 'Kadencje',
                    'skin' => 'list',
                    'field' => 'krakow_rada_uchwaly.kadencja_id',
                    'dictionary' => array(
                        '1' => 'I kadencja',
                        '2' => 'II kadencja',
                        '3' => 'III kadencja',
                        '4' => 'IV kadencja',
                        '5' => 'V kadencja',
                        '6' => 'VI kadencja',
                        '7' => 'VII kadencja',
                        '8' => 'VIII kadencja',
                    ),
                    'all' => 'Wszystkie kadencje',
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba uchwał w czasie',
                    'all' => 'Kiedykolwiek',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'krakow_komisje' => array(
            'kadencje' => array(
                'terms' => array(
                    'field' => 'krakow_komisje.kadencja_id',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                ),
                'visual' => array(
                    'label' => 'Kadencje',
                    'all' => false,
                    'skin' => 'list',
                    'field' => 'krakow_komisje.kadencja_id',
                    'dictionary' => array(
                        '6' => 'Kadencja VI',
                        '7' => 'Kadencja VII',
                        '8' => 'Kadencj VIII',
                        '9' => 'Kadencja IX',
                    ),
                ),
            ),
        ),
        'krakow_komisje_posiedzenia' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba posiedzeń w czasie',
                    'all' => 'Kiedykolwiek',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'radni_dzielnic' => array(
            'dzielnice' => array(
                'terms' => array(
                    'field' => 'radni_dzielnic.dzielnica_id',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'dzielnice.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Dzielnice',
                    'skin' => 'pie_chart',
                    'field' => 'radni_dzielnic.dzielnica_id'
                ),
            ),
        ),
        'krakow_pomoc_publiczna' => array(
            'roczniki' => array(
                'terms' => array(
                    'field' => 'krakow_pomoc_publiczna.rok',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                ),
                'visual' => array(
                    'label' => 'Rok',
                    'all' => 'Wszystkie lata',
                    ' g' => 'list',
                    'field' => 'krakow_pomoc_publiczna.rok',
                    'skin' => 'columns_horizontal',
                ),
            ),
            'beneficjenci' => array(
                'terms' => array(
                    'field' => 'krakow_pomoc_publiczna.beneficjent_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                    'order' => array(
                        'sum' => 'desc',
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_pomoc_publiczna.beneficjent',
                        ),
                    ),
                    'sum' => array(
                        'sum' => array(
                            'field' => 'data.krakow_pomoc_publiczna.wartosc',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Beneficjenci',
                    'all' => 'Wszyscy beneficjenci',
                    'skin' => 'columns_horizontal',
                    'field' => 'krakow_pomoc_publiczna.beneficjent_id',
                    'counter_field' => 'sum',
                ),
            ),
            'przeznaczenie' => array(
                'terms' => array(
                    'field' => 'krakow_pomoc_publiczna.przeznaczenie_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_pomoc_publiczna.przeznaczenie',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Przeznaczenie',
                    'all' => 'Dowolne przeznaczenie',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_pomoc_publiczna.przeznaczenie_id'
                ),
            ),
        ),
        'krakow_zamowienia_publiczne' => array(
            'roczniki' => array(
                'terms' => array(
                    'field' => 'krakow_zamowienia_publiczne.rok',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                ),
                'visual' => array(
                    'label' => 'Rok',
                    'all' => 'Wszystkie lata',
                    'skin' => 'list',
                    'field' => 'krakow_zamowienia_publiczne.rok'
                ),
            ),
            'wykonawcy' => array(
                'terms' => array(
                    'field' => 'krakow_zamowienia_publiczne.wykonawca_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                    'order' => array(
                        'sum' => 'desc',
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_zamowienia_publiczne.wykonawca',
                        ),
                    ),
                    'sum' => array(
                        'sum' => array(
                            'field' => 'data.krakow_zamowienia_publiczne.wartosc_brutto',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Beneficjenci',
                    'all' => 'Wszyscy beneficjenci',
                    'skin' => 'columns_horizontal',
                    'field' => 'krakow_zamowienia_publiczne.wykonawca_id',
                    'counter_field' => 'sum',
                ),
            ),
        ),
        'krakow_darczyncy' => array(
            'roczniki' => array(
                'terms' => array(
                    'field' => 'krakow_darczyncy.rok',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                ),
                'visual' => array(
                    'label' => 'Rok',
                    'all' => 'Wszystkie lata',
                    'skin' => 'list',
                    'field' => 'krakow_darczyncy.rok'
                ),
            ),
            'komitety' => array(
                'terms' => array(
                    'field' => 'krakow_darczyncy.komitet_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                    'order' => array(
                        'sum' => 'desc',
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_darczyncy_komitety.nazwa',
                        ),
                    ),
                    'sum' => array(
                        'sum' => array(
                            'field' => 'data.krakow_darczyncy.wartosc_laczne_wplaty',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Komitety',
                    'all' => 'Wszystkie komitety',
                    'skin' => 'columns_horizontal',
                    'field' => 'krakow_darczyncy.komitet_id',
                    'counter_field' => 'sum',
                    'desc' => 'Liczba wpłat, sumujących się na kwotę powyżej minimalnego wynagrodzenia za pracę.',
                ),
            ),
        ),
        'radni_gmin' => array(
	        'kadencja' => array(
                'terms' => array(
                    'field' => 'radni_gmin.kadencja_id',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                    'exclude' => array(
	                    'pattern' => '0',
                    ),
                ),
                'visual' => array(
                    'label' => 'Kadencje',
                    'skin' => 'list',
                    'field' => 'radni_gmin.kadencja_id',
                    'dictionary' => array(
                        '1' => 'I kadencja',
                        '2' => 'II kadencja',
                        '3' => 'III kadencja',
                        '4' => 'IV kadencja',
                        '5' => 'V kadencja',
                        '6' => 'VI kadencja',
                        '7' => 'VII kadencja',
                        '8' => 'VIII kadencja',
                    ),
                    'all' => 'Radni wszystkich kadencji',
                ),
            ),
        ),
        'rady_gmin_interpelacje' => array(
            'radni' => array(
                'terms' => array(
                    'field' => 'radni_gmin.id',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'radni_gmin.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy interpelacji',
                    'all' => 'Interpelacje wszystkich radnych',
                    'skin' => 'columns_horizontal',
                    'field' => 'radni_gmin.id'
                ),
            ),
            /*
			'kadencja' => array(
                'terms' => array(
                    'field' => 'rady_gmin_interpelacje.kadencja_id',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                    'exclude' => array(
	                    'pattern' => '0',
                    ),
                ),
                'visual' => array(
                    'label' => 'Kadencje',
                    'skin' => 'list',
                    'field' => 'rady_gmin_interpelacje.kadencja_id',
                    'dictionary' => array(
                        '1' => 'I kadencja',
                        '2' => 'II kadencja',
                        '3' => 'III kadencja',
                        '4' => 'IV kadencja',
                        '5' => 'V kadencja',
                        '6' => 'VI kadencja',
                        '7' => 'VII kadencja',
                        '8' => 'VIII kadencja',
                    ),
                    'all' => 'Wszystkie kadencje',
                ),
            ),
            */
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba interpelacji w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Wysłane kiedykolwiek',
                ),
            ),
        ),
        'krakow_dzielnice_uchwaly' => array(
            'dzielnice' => array(
                'terms' => array(
                    'field' => 'krakow_dzielnice_uchwaly.dzielnica_id',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'dzielnice.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Dzielnice',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_dzielnice_uchwaly.dzielnica_id'
                ),
            ),
        ),
        'krakow_zarzadzenia' => array(
            'realizacja' => array(
                'terms' => array(
                    'field' => 'krakow_zarzadzenia.realizacja_str',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_zarzadzenia.realizacja_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Statusy',
                    'all' => 'Wszystkie statusy',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_zarzadzenia.realizacja_str'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba zarządzeń w czasie',
                    'all' => 'Kiedykolwiek',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
            'status' => array(
                'terms' => array(
                    'field' => 'krakow_zarzadzenia.status_str',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_zarzadzenia.status_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Statusy obowiązywania',
                    'all' => 'Wszystkie statusy obowiązywania',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_zarzadzenia.status_str'
                ),
            ),
        ),
        'prawo' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'prawo.typ_id',
                    'exclude' => array(0),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.prawo.typ_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy aktów prawnych',
                    'all' => 'Wszystkie typy aktów',
                    'skin' => 'list',
                    'field' => 'prawo.typ'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba aktów prawnych w czasie',
                    'all' => 'Wydane kiedykolwiek',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
            'autor_id' => array(
                'terms' => array(
                    'field' => 'prawo.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.prawo.autor_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy aktów prawnych',
                    'all' => 'Wszyscy autorzy',
                    'skin' => 'list',
                    'field' => 'prawo.autor_nazwa'
                ),
            ),
        ),
        'dziennik_ustaw' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'dziennik_ustaw.typ_id',
                    'exclude' => array(0),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.dziennik_ustaw.typ_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy aktów prawnych',
                    'all' => 'Wszystkie typy aktów',
                    'skin' => 'list',
                    'field' => 'dziennik_ustaw.typ_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba aktów prawnych w czasie',
                    'all' => 'Wydane kiedykolwiek',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
            'autor_id' => array(
                'terms' => array(
                    'field' => 'dziennik_ustaw.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.dziennik_ustaw.autor_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy aktów prawnych',
                    'all' => 'Wszyscy autorzy',
                    'skin' => 'list',
                    'field' => 'dziennik_ustaw.autor_id'
                ),
            ),
        ),
        'monitor_polski' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'monitor_polski.typ_id',
                    'exclude' => array(0),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.monitor_polski.typ_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy aktów prawnych',
                    'all' => 'Wszystkie typy aktów',
                    'skin' => 'list',
                    'field' => 'monitor_polski.typ_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba aktów prawnych w czasie',
                    'all' => 'Wydane kiedykolwiek',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
            'autor_id' => array(
                'terms' => array(
                    'field' => 'monitor_polski.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.monitor_polski.autor_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy aktów prawnych',
                    'all' => 'Wszyscy autorzy',
                    'skin' => 'list',
                    'field' => 'monitor_polski.autor_id'
                ),
            ),
        ),
        'poslowie' => array(
            'klub_id' => array(
                'terms' => array(
                    'field' => 'poslowie.klub_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.sejm_kluby.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'all' => 'Wszystkie kluby',
                    'label' => 'Kluby parlamentarne',
                    'skin' => 'list',
                    'field' => 'poslowie.klub_id'
                ),
            ),
            'okreg_id' => array(
                'terms' => array(
                    'field' => 'poslowie.sejm_okreg_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'poslowie.okreg_wyborczy_numer',
                        ),
                    ),
                ),
                'visual' => array(
                    'all' => 'Wszystkie okręgi',
                    'label' => 'Okręg wyborczy',
                    'skin' => 'list',
                    'field' => 'poslowie.sejm_okreg_id',
                    'activePrefix' => 'Okręg wyborczy nr ',
                    'activeObject' => array(
	                    'dataset' => 'sejm_okregi_wyborcze',
                    ),
                ),
            ),
            'zawod' => array(
                'terms' => array(
                    'field' => 'poslowie.zawod',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'poslowie.zawod',
                        ),
                    ),
                ),
                'visual' => array(
	                'all' => 'Wszystkie zawody',
                    'label' => 'Zawody posłów',
                    'skin' => 'list',
                    'field' => 'poslowie.zawod'
                ),
            ),
            'plec' => array(
                'terms' => array(
                    'field' => 'poslowie.plec',
                    'include' => array(
                        'pattern' => '(K|M)'
                    ),
                ),
                'visual' => array(
	                'all' => 'Obie płcie',
                    'label' => 'Płeć',
                    'skin' => 'list',
                    'field' => 'poslowie.plec',
                    'dictionary' => array(
                        'K' => 'Kobiety',
                        'M' => 'Mężczyźni',
                    ),
                ),
            ),
        ),
        'poslowie_glosy' => array(
            'klub_id' => array(
                'terms' => array(
                    'field' => 'poslowie_glosy.klub_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.sejm_kluby.skrot',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Fitruj według klubów:',
                    'skin' => 'list',
                    'field' => 'poslowie_glosy.klub_id'
                ),
            ),
            'glosy' => array(
                'terms' => array(
                    'field' => 'poslowie_glosy.glos_id',
                    'include' => array(
                        'pattern' => '(1|2|3|4)'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'poslowie_glosy.glos_id',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Fitruj według głosu:',
                    'skin' => 'pie_chart',
                    'field' => 'poslowie_glosy.glos_id',
                    'dictionary' => array(
                        '1' => 'Za',
                        '2' => 'Przeciw',
                        '3' => 'Wstrzymanie',
                        '4' => 'Nieobecność',
                    ),
                ),
            ),
            'bunty' => array(
                'terms' => array(
                    'field' => 'poslowie_glosy.bunt',
                    'include' => array(
                        'pattern' => '(1)'
                    ),
                ),
                'visual' => array(
                    'label' => 'Bunty',
                    'skin' => 'list',
                    'field' => 'poslowie_glosy.bunt',
                    'dictionary' => array(
                        '1' => 'Pokaż głosy przeciwne niż większości w klubie posła',
                    ),
                ),
            ),
        ),
        'zbiorki_publiczne' => array(
            'stan' => array(
                'terms' => array(
                    'field' => 'zbiorki_publiczne.stan_zbiorki',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'visual' => array(
                    'label' => 'Stan zbiórki',
                    'skin' => 'list',
                    'field' => 'zbiorki_publiczne.stan_zbiorki',
                    'dictionary' => array(
                        'Realizowana' => 'Realizowane',
                        'Zakończona' => 'Zakończone',
                        'Planowana' => 'Planowane',
                    ),
                    'all' => 'Wszystkie zbiórki',
                ),
            ),
            'status' => array(
                'terms' => array(
                    'field' => 'zbiorki_publiczne.spr_przeprowadzenia_status',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'visual' => array(
                    'label' => 'Stan zbiórki',
                    'skin' => 'list',
                    'field' => 'zbiorki_publiczne.spr_przeprowadzenia_status',
                    'dictionary' => array(
                    ),
                    'all' => 'Wszystkie statusy',
                ),
            ),  
            'cel_religijny' => array(
                'terms' => array(
                    'field' => 'zbiorki_publiczne.dane_cel_religijny',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'visual' => array(
                    'label' => 'Cel religijny',
                    'skin' => 'list',
                    'field' => 'zbiorki_publiczne.dane_cel_religijny',
                    'dictionary' => array(
	                    'tak' => 'Cele religijne',
	                    'nie' => 'Cele niereligijne',
                    ),
                    'all' => 'Wszystkie cele',
                ),
            ),            
        ),
        'zamowienia_publiczne' => array(
            'wartosc_cena' => array(
                'sum' => array(
                    'field' => 'data.zamowienia_publiczne.wartosc_cena',
                ),
                'visual' => array(
                    'label' => 'Wartość zamówień',
                    'skin' => 'numeric',
                    'field' => 'zamowienia_publiczne.wartosc_cena',
                    'currency' => 'pln'
                ),
            ),
            'tryb_id' => array(
                'terms' => array(
                    'field' => 'zamowienia_publiczne.tryb_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.zamowienia_publiczne_tryby.nazwa',
                        ),
                    ),
                    'wartosc_cena' => array(
                        'sum' => array(
                            'field' => 'zamowienia_publiczne.wartosc_cena',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Tryby zamówień',
                    'skin' => 'zamowienia_publiczne/pie_chart',
                    'field' => 'zamowienia_publiczne.tryb_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba zamówień publicznych w czasie',
                    'skin' => 'date_histogram',
                    'field' => '_date',
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'krs_osoby' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'krs_osoby.plec',
                    'include' => array(
                        'pattern' => '(K|M)'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krs_osoby.plec',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Płeć',
                    'all' => 'Mężczyźni i kobiety',
                    'skin' => 'pie_chart',
                    'field' => 'krs_osoby.plec',
                    'dictionary' => array(
                        'K' => 'Kobiety',
                        'M' => 'Mężczyźni',
                    ),
                )
            )
        ),
        'krs_podmioty' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'krs_podmioty.forma_prawna_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                    'size' => 10,
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.krs_podmioty.forma_prawna_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Formy prawne organizacji',
                    'all' => 'Wszystkie formy prawne',
                    'skin' => 'list',
                    'field' => 'krs_podmioty.forma_prawna_id',
                ),
            ),
            'kapitalizacja' => array(
                'range' => array(
                    'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
                    'ranges' => array(
                        array('from' => 1, 'to' => 10000),
                        array('from' => 10000, 'to' => 100000),
                        array('from' => 100000, 'to' => 1000000),
                        array('from' => 1000000, 'to' => 10000000),
                        array('from' => 10000000),
                    ),
                ),
                'visual' => array(
                    'label' => 'Kapitalizacja spółek',
                    'all' => 'Dowolny kapitał zakładowy',
                    'skin' => 'krs/kapitalizacja',
                    'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
                ),
            ),
            /*
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'week',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba rejestracji nowych organizacji w czasie',
                    'skin' => 'highstockPicker',
                    'field' => '_date',
                    'all' => 'Zarejestrowane kiedykolwiek',
                ),
            ),
            */
        ),
        'dotacje_ue' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba udzielonych dotacji w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Udzielone kiedykolwiek',
                ),
            ),
        ),
        'sejm_druki' => array(
            'kadencja' => array(
                'terms' => array(
                    'field' => 'sejm_druki.kadencja',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
	                'all' => 'Wszystkie kadencje',
                    'label' => 'Kadencja',
                    'skin' => 'list',
                    'field' => 'sejm_druki.kadencja',
                    'dictionary' => array(
                        '7' => 'Kadencja 7',
                        '8' => 'Kadencja 8',
                    ),
                ),
            ),
            'typ_id' => array(
                'terms' => array(
                    'field' => 'sejm_druki.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
	                'all' => 'Wszystkie typy druków',
                    'label' => 'Typy druków',
                    'skin' => 'list',
                    'field' => 'sejm_druki.typ_id',
                    'dictionary' => array(
                        '1' => 'Projekty ustaw',
                        '2' => 'Projekty uchwał',
                        '3' => 'Wnioski',
                        '5' => 'Powołania na stanowiska',
                        '6' => 'Zawiadomienia o ratyfikacji umów',
                        '7' => 'Sprawozdania komisji',
                        '8' => 'Stanowiska Senatu',
                        '9' => 'Dodatkowe sprawozdania komisji',
                        '10' => 'Autopoprawki',
                        '11' => 'Sprawozdania kontrolne',
                        '12' => 'Inne',
                    ),
                ),
            ),
        ),
        'prawo_projekty' => array(
            /*
            'faza_id' => array(
                'terms' => array(
                    'field' => 'prawo_projekty.faza_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Statusy projektów',
                    'skin' => 'columns_vertical',
                    'field' => 'prawo_projekty.faza_id',
                    'dictionary' => array(
                        '2' => 'W trakcie prac',
                        '3' => 'Przyjęte',
                        '4' => 'Odrzucone',
                    ),
                ),
            ),
            */
            
            'typ_id' => array(
                'terms' => array(
                    'field' => 'prawo_projekty.typ_id',
                    'exclude' => array(
                        'pattern' => '(0|8)'
                    ),
                ),
                'visual' => array(
                    'all' => 'Wszystkie typy projektów',
                    'label' => 'Typy projektów',
                    'skin' => 'list',
                    'field' => 'prawo_projekty.typ_id',
                    'dictionary' => array(
                        '1' => 'Projekty ustaw',
                        '2' => 'Projekty uchwał',
                        '5' => 'Powołania odwołania',
                        '6' => 'Umowy międzynarodowe',
                        '11' => 'Sprawozdania kontrolne',
                        '12' => 'Inne projekty',
                        '100' => 'Zmiany w składach komisji sejmowych',
                        '103' => 'Wniosko o referenda',
                    ),
                ),
            ),
            'autor_typ_id' => array(
                'terms' => array(
                    'field' => 'prawo_projekty.autor_typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'all' => 'Wszyscy autorzy',
                    'label' => 'Autorzy projektów',
                    'skin' => 'list',
                    'field' => 'prawo_projekty.autor_typ_id',
                    'dictionary' => array(
                        '1' => 'Projekty rządowe',
                        '2' => 'Projekty obywatelskie',
                        '3' => 'Projekty komisyjne',
                        '4' => 'Projekty senackie',
                        '5' => 'Projekty poselskie',
                        '6' => 'Projekty prezydenckie',
                        '7' => 'Projekty prezydialne',
                    ),
                ),
            ),
            'klub_id' => array(
                'terms' => array(
                    'field' => 'prawo_projekty.kluby_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'all' => 'Wszystkie kluby',
                    'label' => 'Klub poselski',
                    'skin' => 'list',
                    'field' => 'prawo_projekty.kluby_id',
                    'dictionary' => array(
                        '1' => 'Platforma Obywatelska',
                        '2' => 'Prawo i Sprawiedliwość',
                        '3' => 'Polskie Stronnictwo Ludowe',
                        '4' => 'Sojusz Lewicy Demokratycznej',
                        '5' => 'Ruch Palikota',
                        '6' => 'Solidarna Polska',
                        '7' => 'Posłowie niezrzeszeni',
                        '8' => 'Inicjatywa Dialogu',
                        '9' => 'Sprawiedliwa Polska',
                        '10' => 'Bezpieczeństwo i Gospodarka',
                        '11' => 'Zjednoczona Prawica',
                        '12' => 'Biało-Czerwoni',
                        '13' => 'Kukiz15',
                        '14' => 'Nowoczesna',
                    ),
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba projektów w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                    'all' => 'Złożone kiedykolwiek',
                ),
            ),
            'kadencja' => array(
                'terms' => array(
                    'field' => 'prawo_projekty.kadencja',
                    'exclude' => array('0'),
                ),
                'visual' => array(
	                'all' => 'Złożone we wszystkich kadencjach',
                    'label' => 'Kadencja',
                    'skin' => 'list',
                    'field' => 'prawo_projekty.kadencja',
                    'dictionary' => array(
                        '7' => 'Kadencja 7',
                        '8' => 'Kadencja 8',
                    ),
                ),
            ),
        ),
    );

	private function processAggs( $aggs = array() )
	{
				
		foreach( $aggs as $key => $value) {
            if (is_array($value)) {

                foreach ($value as $keyM => $valueM) {
                    if ($keyM === 'visual') {

						if( !isset($valueM['target']) )
							$valueM['target'] = 'filters';
						
						if( isset($valueM['dict']) ) {
							
							require_once(APPLIBS . '/DataobjectDictionary.php');
						    if( !isset($dictionary) )
							    $dictionary = new MP\Lib\DataobjectDictionary();
							    							
							$valueM['dictionary'] = $dictionary->dictionary($valueM['dict'], 'plural');
							
						}
												
                        $this->aggs_visuals_map[$key] = $valueM;
                        unset($aggs[$key][$keyM]);

                    }
                }
            }
        }

		return $aggs;

	}

	private function prepareSort($sort = array(), $query = array())
    {
        if(isset($query['q'])) {
            $sort = $sort + array(
                'score' => array(
                    'label' => 'Trafność',
                    'options' => array(
                        'desc' => 'najtrafniejsze'
                    )
                )
            ) ;
        }

		return $sort;
	}

    public function __construct($collection, $settings)
    {
		
		if (
            (
                !isset($settings['objectOptions']) ||
                (empty($settings['objectOptions']))
            )
        )
            $settings['objectOptions'] = array();
		
        if (
            (
                !isset($settings['aggs']) ||
                (empty($settings['aggs']))
            )
        )
            $settings['aggs'] = array();

        if (
            (
                !isset($settings['sort']) ||
                (empty($settings['sort']))
            )
        )
            $settings['sort'] = array();
            
        if (
            (
                !isset($settings['phrases']) ||
                (empty($settings['phrases']))
            )
        )
            $settings['phrases'] = array();

        if(
	        isset($settings['aggsPreset']) &&
            array_key_exists($settings['aggsPreset'], $this->aggs_presets) 
        ) {
	        
        	$settings['aggs'] = array_merge($this->aggs_presets[$settings['aggsPreset']], $settings['aggs']);
			
			if( isset($settings['aggsPresetExclude']) ) {
				
				if( !is_array($settings['aggsPresetExclude']) )
					$settings['aggsPresetExclude'] = array( $settings['aggsPresetExclude'] );
					
				foreach( $settings['aggsPresetExclude'] as $e )
					unset( $settings['aggs'][$e] );
				
			}
						
        }
        
        if(
	        isset($settings['sortPreset']) &&
            array_key_exists($settings['sortPreset'], $this->sort_presets)
        )
        	$settings['sort'] = array_merge($this->sort_presets[$settings['sortPreset']], $settings['sort']);
        	
        if(
	        isset($settings['phrasesPreset']) &&
            array_key_exists($settings['phrasesPreset'], $this->phrases_presets)
        )
        	$settings['phrases'] = array_merge($this->phrases_presets[$settings['phrasesPreset']], $settings['phrases']);

        if( isset($settings['aggs']) )
        	$settings['aggs'] = $this->processAggs( $settings['aggs'] );
        	
        if( isset($settings['browserTitle']) )
        	$settings['browserTitle'] = $settings['browserTitle'];
        	
        if( isset($settings['browserTitleElement']) )
        	$settings['browserTitleElement'] = $settings['browserTitleElement'];
				
        if(
	        isset($settings['cover']) &&
	        isset($settings['cover']['aggs'])
        ) {
        	$settings['cover']['aggs'] = $this->processAggs( $settings['cover']['aggs'] );
        }
        
    	$settings['observe'] = isset($settings['observe']) ? $settings['observe'] : false;
		
		


        $this->settings = $settings;

        if (isset($settings['cover']))
            $this->cover = $settings['cover'];

        if (isset($settings['chapters']))
            $this->chapters = $settings['chapters'];

        if (isset($settings['searchTitle']))
            $this->searchTitle = $settings['searchTitle'];
            
        if (isset($settings['browserTitle']))
            $this->browserTitle = $settings['browserTitle'];
		
		if (isset($settings['browserTitleElement']))
            $this->browserTitleElement = $settings['browserTitleElement'];
			
        if (isset($settings['searchTag']))
            $this->searchTag = $settings['searchTag'];

        if (isset($settings['searchAction']))
            $this->searchAction = $settings['searchAction'];

        if (isset($settings['autocompletion']))
            $this->autocompletion = $settings['autocompletion'];

        if (isset($settings['aggs-mode']))
            $this->aggsMode = $settings['aggs-mode'];

        if (isset($settings['searcher']))
            $this->searcher = $settings['searcher'];

        if (isset($settings['routes']))
            $this->routes = $settings['routes'];

        if (isset($settings['dataset']))
            $this->dataset = $settings['dataset'];
            
		if (isset($settings['_type']))
            $this->type = $settings['_type'];
            
    }

    public function beforeRender($controller)
    {
		
		if( 
			!isset($controller->request->query['q']) &&
			!@isset($controller->request->query['conditions']['q']) && 
			isset($this->settings['default_conditions'])
		) {
            foreach( $this->settings['default_conditions'] as $key => $value ) {
	            if(
		            isset($controller->request->query['conditions'][ $key ]) &&
		            ( $controller->request->query['conditions'][ $key ]=='*' )
	            ) {
		            unset($controller->request->query['conditions'][ $key ]);
	            } elseif( !isset($controller->request->query['conditions'][ $key ]) ) {
	            	$controller->request->query['conditions'][ $key ] = $value;
	            }
            }
        }
		
		if( ( isset($controller->request->query['q']) || @isset($controller->request->query['conditions']['q']) ) && isset($this->settings['perApps']) && $this->settings['perApps'] ) {
					        
	        $aggs = array();
	        $aggs['apps'] = array(
		        'terms' => array(
			        'size' => 10,
			        'script' => array(
				        'lang' => 'groovy',
		            	'id' => 'app',
			        ),
			        'order' => array(
				        'score' => 'desc',
			        ),
		        ),
		        'aggs' => array(
			        'top' => array(
		            	'top_hits' => array(
			            	'size' => 3,
			            	'_source' => array('data', 'static', 'slug'),
			            	'fielddata_fields' => array('dataset', 'id'),
		            	),
	            	),
	            	'score' => array(
		            	'max' => array(
			            	'script' => array(
				            	'lang' => 'groovy',
				            	'id' => 'score',
			            	),			            	
		            	),
	            	),
		        ),
	        );

	        if( isset($this->settings['aggs']) )
		        $this->settings['aggs'] = array_merge($this->settings['aggs'], $aggs);
		    else
		    	$this->settings['aggs'] = $aggs;
				
	        $this->aggsMode = 'apps';



		} elseif( ( isset($controller->request->query['q']) || @isset($controller->request->query['conditions']['q']) ) && isset($this->settings['perDatasets']) && $this->settings['perDatasets'] ) {
					        
	        $aggs = array();
	        $aggs['datasets'] = array(
		        'terms' => array(
			        'size' => 10,
			        'field' => 'dataset',
			        'order' => array(
				        'score' => 'desc',
			        ),
		        ),
		        'aggs' => array(
			        'top' => array(
		            	'top_hits' => array(
			            	'size' => 3,
			            	'_source' => array('data', 'static', 'slug'),
			            	'fielddata_fields' => array('dataset', 'id'),
		            	),
	            	),
	            	'score' => array(
		            	'max' => array(
			            	'script' => array(
				            	'lang' => 'groovy',
				            	'id' => 'score',
			            	),			            	
		            	),
	            	),
		        ),
	        );
						
	        $this->cover = array(
		        'view' => array(
			        'plugin' => 'Start',
			        'element' => 'search-datasets',
		        ),
		        'aggs' => $aggs,
		        'force' => true,
	        );
	        
	        $this->browserTitle = 'Wyniki wyszukiwania:';
	        $this->aggsMode = 'datasets';

		}

        $controller->helpers[] = 'Dane.Dataobject';

        if (is_null($controller->Paginator)) {
            $controller->Paginator = $controller->Components->load('Paginator');
        }

        if (isset($controller->request->query['q'])) {
            $controller->request->query['conditions']['q'] = $controller->request->query['q'];
        }

        $this->queryData = $controller->request->query;

        if (!property_exists($controller, 'Dataobject'))
            $controller->Dataobject = ClassRegistry::init('Dane.Dataobject');

        if (
            (!$this->cover) ||
            (
                $this->cover &&
                (!isset($this->cover['force']) || !$this->cover['force']) &&
                isset($this->queryData['conditions']) &&
                !empty($this->queryData['conditions'])
            )
        ) {
			
            $controller->Paginator->settings = $this->getSettings();

			if( isset($this->settings['default_order']) )
            	$controller->Paginator->settings['order'] = $this->settings['default_order'];
                        
            $hits = $controller->Paginator->paginate('Dataobject');
            if( $hits && $this->settings['objectOptions'] ) {
	            foreach( $hits as &$hit ) {
		            $hit->setOptions($this->settings['objectOptions']);
	            }	         
            }
            
            $this->settings['sort'] = $this->prepareSort($this->settings['sort'], $this->queryData);
            
            $dataBrowser = array(
                'hits' => $hits,
                'took' => $controller->Dataobject->getPerformance(),
                'cancel_url' => $controller->here,
                'api_call' => $controller->Dataobject->getDataSource()->public_api_call,
                'renderFile' => isset($this->settings['renderFile']) ? 'DataBrowser/templates/' . $this->settings['renderFile'] : 'default',
                'cover' => $this->cover,
                'chapters' => $this->chapters,
                'searchTitle' => $this->searchTitle,
                'browserTitle' => $this->browserTitle,
                'browserTitleElement' => $this->browserTitleElement,
                'searchTag' => $this->searchTag,
                'searchAction' => $this->searchAction,
                'searcher' => $this->searcher,
                'autocompletion' => $this->autocompletion,
                'mode' => 'data',
                'dataset' => $this->dataset,
                'aggs_visuals_map' => $this->prepareRequests($this->aggs_visuals_map, $controller),
                'sort' => $this->settings['sort'],
                'phrases' => isset($this->settings['phrases']) ? $this->settings['phrases'] : false,
                'noResultsElement' => isset($this->settings['noResultsElement']) ? $this->settings['noResultsElement'] : 'Dane.DataBrowser/noResults',
                'observe' => $this->settings['observe'],
            );
            
            if( isset($this->settings['beforeBrowserElement']) )
            	$dataBrowser['beforeBrowserElement'] = $this->settings['beforeBrowserElement'];
            	
            if( isset($this->settings['beforeBrowserElements']) )
            	$dataBrowser['beforeBrowserElements'] = $this->settings['beforeBrowserElements'];

            if( isset($this->settings['afterBrowserElement']) )
            	$dataBrowser['afterBrowserElement'] = $this->settings['afterBrowserElement'];


			$app_menu = array();
			$app_menu_counters = array();
			$dataBrowser['aggs'] = $controller->Dataobject->getAggs();
						            
            if( $dataBrowser['aggs'] ) {
	            	            
	            foreach( $dataBrowser['aggs'] as $k => $v ) {
		            
		            if( 
		            	( strpos($k, 'app_')===0 ) && 
		            	( $v['doc_count'] ) && 
		            	( $app_id = substr($k, 4) ) && 
		            	( $app = $controller->getApplication($app_id) ) 
	            	) {
												
		                $app_menu[] = array(
		                    'id' => $app['id'],
		                    'href' => $app['href'],
		                    'title' => $app['name'],
		                );
		                
		                $app_menu_counters[] = $v['doc_count'];
			            
		            } elseif( 
		            	( $k == 'dataset' ) && 
		            	( !empty($v['buckets']) )
	            	) {
			            foreach( $v['buckets'] as $i => $b ) {
				            
				            $d = $controller->getDataset($b['key']);
				            $b = array_merge($b, $d['dataset_name']);
				            $b['app_id'] = $d['app_id'];
				            
				            $dataBrowser['aggs'][ $k ]['buckets'][ $i ] = $b;
				            
			            }			            
		            }
		            
	            }
            }
            
            

            foreach( $this->routes as $key => $value ) {

	            $parts = explode('/', $key);
	            if(
		            isset( $dataBrowser['aggs'][$parts[0]] ) &&
		            isset( $dataBrowser['aggs'][$parts[0]][$parts[1]] )
	            ) {

		            $dataBrowser['aggs'][ $value ] = $dataBrowser['aggs'][$parts[0]][$parts[1]];
		            unset( $dataBrowser['aggs'][$parts[0]][$parts[1]] );

					if( isset($dataBrowser['aggs'][$parts[0]]['doc_count']) ) {
			            $dataBrowser['aggs'][ $value ]['doc_count'] = $dataBrowser['aggs'][$parts[0]]['doc_count'];
			            unset( $dataBrowser['aggs'][$parts[0]]['doc_count'] );
			        }

	            }

            }
            
            if( $app_menu ) {
	            
	            $_app_menu = array();
	            arsort( $app_menu_counters );
	            foreach( $app_menu_counters as $k => $v )
	            	$_app_menu[] = $app_menu[ $k ];
	            
	            unset( $app_menu );
            	$controller->app_menu[0] = $_app_menu;
            	
            }



            $controller->set('dataBrowser', $dataBrowser);


            if (isset($controller->request->query['conditions']['q']) && $controller->request->query['conditions']['q']) {
                $controller->title = $controller->request->query['conditions']['q'] . ' - Szukaj w danych publicznych';
            }


        } else {

            if ($this->cover) {

                $settings = $this->getSettings();
                                              
                $params = array(
                    'limit' => 0,
                    'conditions' => $settings['conditions'],
                    'order' => $settings['order'],
                    'aggs' => array(),
                );
                
				if (isset($settings['aggs']))
                    $params['aggs'] = array_merge($params['aggs'], $settings['aggs']);

                if (isset($this->cover['aggs']))
                    $params['aggs'] = array_merge($params['aggs'], $this->cover['aggs']);
                                                    
                if (isset($this->cover['conditions']))
                    $params['conditions'] = array_merge($params['conditions'], $this->cover['conditions']);
				
								
				if( empty($params['aggs']) ) {
					
					$dataBrowser = array(
	                    'aggs' => array(),
	                    'took' => false,
	                );
					
				} else {
				
					if( 
						isset( $this->cover['cache'] ) && 
						!isset($controller->request->query['nocache'])
					) {
									
						$cache_id = 'Cover-' . $controller->request->params['plugin'] . '-' . $controller->request->params['controller'] . '-' . $controller->request->params['action'] . '-';
						
						if( isset($controller->request->params['id']) )
							$cache_id .= $controller->request->params['id'] . '-';
							
						$cache_id .= md5( serialize( $params ) );
																
						$aggs = Cache::read($cache_id, 'short');
															
				        if( $aggs===false ) {
					        
					        $controller->Dataobject->find('all', $params);
					        $aggs = $controller->Dataobject->getAggs();
				            Cache::write($cache_id, $aggs, 'short');
				            
				        }			
						
						$dataBrowser = array(
		                    'aggs' => $aggs,
		                    'took' => false,
		                    'count' => $controller->Dataobject->paginateCount(),
		                );
						
					} else {
						
						$controller->Dataobject->find('all', $params);
						$dataBrowser = array(
		                    'aggs' => $controller->Dataobject->getAggs(),
		                    'took' => $controller->Dataobject->getPerformance(),
		                    'count' => $controller->Dataobject->paginateCount(),
		                );
		                		                
		                if( isset( $this->cover['cache'] ) ) {
			                
			                $cache_id = 'Cover-' . $controller->request->params['plugin'] . '-' . $controller->request->params['controller'] . '-' . $controller->request->params['action'] . '-' . md5( serialize( $params ) );
			                Cache::write($cache_id, $dataBrowser['aggs'], 'short');
			                
		                }
						
					}
				
				}
								
				$dataBrowser = array_merge($dataBrowser, array(
					'sort' => $this->settings['sort'],
                    'cover' => $this->cover,
                    'cancel_url' => false,
                    'chapters' => $this->chapters,
                    'searchTitle' => $this->searchTitle,
                    'browserTitle' => $this->browserTitle,
	                'browserTitleElement' => $this->browserTitleElement,
                    'searchTag' => $this->searchTag,
                    'searchAction' => $this->searchAction,
                    'searcher' => $this->searcher,
                    'autocompletion' => $this->autocompletion,
                    'mode' => 'cover',
                    'dataset' => $this->dataset,
	                'aggs_visuals_map' => $this->prepareRequests($this->aggs_visuals_map, $controller),
	                'observe' => $this->settings['observe'],
	                'appObserve' => isset( $this->settings['appObserve'] ) ?  $this->settings['appObserve'] : false,
				));
				
				if( $controller->object ) {
					$dataBrowser = array_merge($dataBrowser, array(
						'data' => $controller->object->getData(),
						'layers' => $controller->object->getLayers(),
						'title' => $controller->object->getTitle(),
						'url' => $controller->object->getUrl(),
					));
				}
				                
	            $this->settings['sort'] = $this->prepareSort($this->settings['sort'], $this->queryData);
	          	           	            
                foreach( $this->routes as $key => $value ) {

		            $parts = explode('/', $key);
		            if(
			            isset( $dataBrowser['aggs'][$parts[0]] ) &&
			            isset( $dataBrowser['aggs'][$parts[0]][$parts[1]] )
		            ) {

			            $dataBrowser['aggs'][ $value ] = $dataBrowser['aggs'][$parts[0]][$parts[1]];
			            unset( $dataBrowser['aggs'][$parts[0]][$parts[1]] );

						if( isset($dataBrowser['aggs'][$parts[0]]['doc_count']) ) {
				            $dataBrowser['aggs'][ $value ]['doc_count'] = $dataBrowser['aggs'][$parts[0]]['doc_count'];
				            unset( $dataBrowser['aggs'][$parts[0]]['doc_count'] );
				        }

		            }

	            }

                $controller->set('dataBrowser', $dataBrowser);

            }

        }

        if( @$controller->request->params['ext']=='json' ) {
						
	        foreach( array('cancel_url', 'api_call', 'renderFile', 'cover', 'chapters', 'browserTitle', 'browserTitleElement', 'searchTitle', 'searchTag', 'searchAction', 'searcher', 'autocompletion', 'mode', 'aggs_visuals_map', 'apps') as $var )
	        	if( isset($controller->viewVars['dataBrowser'][ $var ]) )
			        unset( $controller->viewVars['dataBrowser'][ $var ] );

	        $controller->set('_serialize', 'dataBrowser');

	    }

    }

    private function getSettings()
    {

        $conditions = $this->getSettingsForField('conditions');

        $output = array(
            'paramType' => 'querystring',
            'conditions' => $conditions,
            'aggs' => $this->getSettingsForField('aggs'),
            'order' => $this->getSettingsForField('order'),
            'limit' => isset($this->settings['limit']) ? $this->settings['limit'] : 30,
            '_type' => $this->type,
        );
        
		if( isset($this->settings['feed']) )
			$output['feed'] = $this->settings['feed'];


        if (isset($conditions['q']))
            $output['highlight'] = true;


		if( $output['conditions'] ) {
			foreach( $output['conditions'] as $field => $value ) {
				foreach( $this->aggs_visuals_map as $key => $map) {
					if(
						($map['target']=='filters') &&
						isset($map['field']) &&
						( $map['field']==$field )
					) {

						$output['aggs'][$key]['scope'] = 'filters_exclude(' . $field . ')';
						break;
					}
				}
			}
		}

        return $output;

    }

    private function getSettingsForField($field)
    {
		
        $params = isset($this->queryData[$field]) ? $this->queryData[$field] : array();
		
        if (isset($this->settings[$field])) {
            if (is_array($this->settings[$field]))
                $params = array_merge($params, $this->settings[$field]);
            else
                $params = $this->settings[$field];
        }
		
        return $params;

    }

    private function getCancelSearchUrl($controller)
    {
        if (!isset($controller->request->query) || count($controller->request->query) === 0)
            return $controller->here;

        $query = $controller->request->query;

        if (isset($query['q']))
            unset($query['q']);

        if (isset($query['page']))
            unset($query['page']);

        if (isset($query['conditions']['q']))
            unset($query['conditions']['q']);

        if (
            count(@array_count_values($query)) ||
            (
                isset($query['conditions']) &&
                count($query['conditions'])
            )
        )
            $query = '?' . http_build_query($query);
        else
            $query = '';

        return $controller->here . $query;
    }

    private function prepareRequests($maps, $controller)
    {
        $query = $controller->request->query;

        foreach ($maps as $i => $map) {

            // Anulowanie np. wybranego typu
            $cancelQuery = $query;
			
			// debug($map);
			// debug($cancelQuery);
			
			
            if (isset($map['field']) && isset($cancelQuery['conditions'][$map['field']]))
                unset($cancelQuery['conditions'][$map['field']]);

            if (isset($cancelQuery['page']))
                unset($cancelQuery['page']);
            if (isset($cancelQuery['conditions']['q']))
                unset($cancelQuery['conditions']['q']);
            
            $_cancelQuery = $cancelQuery;
			
			if( isset($this->settings['default_conditions']) )
	            if( array_key_exists($map['field'], $this->settings['default_conditions']) )
	            	$cancelQuery['conditions'][ $map['field'] ] = '*';
            
            
            $maps[$i]['cancelRequest'] = $controller->here;
            if( !empty($cancelQuery) && !empty($cancelQuery['conditions']) )
            	$maps[$i]['cancelRequest'] .= '?' . http_build_query($cancelQuery);

            // Wybieranie np. danego typu
            // Nie znamy jeszcze id dlatego na końcu zostawiamy `=` np.
            // http://.../?..&conditions[type.id]=
            $chooseQuery = $query;

            if (isset($_cancelQuery['page']))
                unset($_cancelQuery['page']);
			
			if( isset($map['field']) )
				$_cancelQuery['conditions'][ $map['field'] ] = '';
						
            $maps[$i]['chooseRequest'] = $controller->here . '?' . http_build_query($_cancelQuery);

            if( isset($maps[$i]['forceKey']) )
            	$maps[ $maps[$i]['forceKey'] ] = $maps[$i];
        }

        return $maps;
    }
    
    public function dict($dict, $id, $mode = 'single') {
	    	    	    
	    require_once(APPLIBS . '/DataobjectDictionary.php');
	    $dictionary = new MP\Lib\DataobjectDictionary();
	    
	    return $dictionary->label($dict, $id, $mode);
	    	    
    }

}
