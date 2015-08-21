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
    private $autocompletion = false;
    private $aggsMode = false;
    private $searcher = true;
    private $routes = array();
    public $dataset = false;

    private $aggs_presets = array(
        'gminy' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'gminy.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy gmin',
                    'skin' => 'pie_chart',
                    'field' => 'gminy.typ_id',
                    'dictionary' => array(
                        '1' => 'Gmina miejska',
                        '2' => 'Gmina wiejska',
                        '3' => 'Gmina miejsko-wiejska',
                        '4' => 'Miasto stołeczne',
                    ),
                ),
            ),
        ),
        'powiaty' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'powiaty.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy powiatów',
                    'skin' => 'pie_chart',
                    'field' => 'powiaty.typ_id',
                    'dictionary' => array(
                        '1' => 'Powiat',
                        '2' => 'Miasto na prawach powiatu',
                        '3' => 'Miasto stołeczne',
                    ),
                ),
            ),
            'wojewodztwo_id' => array(
                'terms' => array(
                    'field' => 'powiaty.wojewodztwo_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Województwo',
                    'skin' => 'geo_pl',
                    'params' => array(
                        'unit' => 'wojewodztwa',
                    ),
                    'field' => 'powiaty.wojewodztwo_id',
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
                    'label' => 'Typy kont',
                    'skin' => 'pie_chart',
                    'field' => 'twitter_accounts.typ_id',
                    'dictionary' => array(
                        '1' => 'Posłowie',
                        '2' => 'Komentatorzy',
                        '3' => 'Urzędy',
                        '4' => 'Rząd',
                        '5' => 'Rzecznik prasowy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partia polityczna',
                        '9' => 'NGO',
                    ),
                ),
            ),
        ),
        'twitter' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'twitter_accounts.typ_id',
                    'exclude' => array(
                        'pattern' => '(0|)'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy kont',
                    'skin' => 'pie_chart',
                    'field' => 'twitter_accounts.typ_id',
                    'dictionary' => array(
                        '1' => 'Posłowie',
                        '2' => 'Komentatorzy',
                        '3' => 'Urzędy',
                        '4' => 'Rząd',
                        '5' => 'Rzecznik prasowy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partia polityczna',
                        '9' => 'NGO',
                    ),
                ),
            ),
            /*
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
            */
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
                    'all' => 'Kiedykolwiek',
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
        'prawo_projekty' => array(
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
            'typ_id' => array(
                'terms' => array(
                    'field' => 'prawo_projekty.typ_id',
                    'exclude' => array(
                        'pattern' => '(0|8)'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy projektów',
                    'skin' => 'pie_chart',
                    'field' => 'prawo_projekty.typ_id',
                    'dictionary' => array(
                        '1' => 'Projekty ustaw',
                        '2' => 'Projekty uchwał',
                        '3' => 'Wota zaufania',
                        '5' => 'Powołania odwołania',
                        '6' => 'Umowy międzynarodowe',
                        '11' => 'Sprawozdania kontrolne',
                        '12' => 'Inne projekty',
                        '100' => 'Zmiany w składach komisji sejmowych',
                        '103' => 'Wniosko o referenda',
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
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'krakow_rada_uchwaly' => array(

            /*'kadencja_id' => array(
                'terms' => array(
                    'field' => 'krakow_rada_uchwaly.kadencja_id',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Kadencje',
                    'skin' => 'list',
                    'field' => 'krakow_rada_uchwaly.kadencja_id',
                    'dictionary' => array(
                        '1' => 'I',
                        '2' => 'II',
                        '3' => 'III',
                        '4' => 'IV',
                        '5' => 'V',
                        '6' => 'VI',
                        '7' => 'VII',
                        '8' => 'VIII',
                        '9' => 'IX',
                    ),
                ),
            ),*/

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
                    'skin' => 'list',
                    'field' => 'krakow_komisje.kadencja_id',
                    'dictionary' => array(
                        '6' => 'VI',
                        '7' => 'VII',
                        '8' => 'VIII',
                        '9' => 'IX',
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
                    'skin' => 'list',
                    'field' => 'krakow_pomoc_publiczna.rok'
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
                ),
            ),
        ),
        'rady_gmin_interpelacje' => array(
            /*'kadencja' => array(
                'terms' => array(
                    'field' => 'rady_gmin_interpelacje.kadencja_id',
                    'order' => array(
                        '_term' => 'desc',
                    ),
                ),
                'visual' => array(
                    'label' => 'Kadencje',
                    'skin' => 'list',
                    'field' => 'rady_gmin_interpelacje.kadencja_id',
                    'dictionary' => array(
                        '1' => 'I',
                        '2' => 'II',
                        '3' => 'III',
                        '4' => 'IV',
                        '5' => 'V',
                        '6' => 'VI',
                        '7' => 'VII',
                        '8' => 'VIII',
                        '9' => 'IX',
                    ),
                ),
            ),*/
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
                    'all' => 'Wszyscy autorzy',
                    'skin' => 'columns_horizontal',
                    'field' => 'radni_gmin.id'
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
                    'exclude' => array(
                        'pattern' => '0'
                    ),
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
                    'skin' => 'pie_chart',
                    'field' => 'prawo.typ_id'
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
                    'skin' => 'columns_horizontal',
                    'field' => 'prawo.autor_id'
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
                    'label' => 'Kluby parlamentarne',
                    'skin' => 'pie_chart',
                    'field' => 'poslowie.klub_id'
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
                    'label' => 'Zawody posłów',
                    'skin' => 'columns_horizontal',
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
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'poslowie.plec',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Płeć',
                    'skin' => 'pie_chart',
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
        'zamowienia_publiczne' => array(
            'wartosc_cena' => array(
                'sum' => array(
                    'field' => 'zamowienia_publiczne.wartosc_cena',
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
                    'skin' => 'pie_chart',
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
                    'all' => 'Wszystkie zakresy kapitalizacji',
                    'skin' => 'krs/kapitalizacja',
                    'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
                ),
            ),
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
                    'all' => 'Kiedykolwiek',
                ),
            ),
        ),
        'sejm_druki' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'sejm_druki.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'sejm_druki_typy.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
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
    );

	private function processAggs( $aggs = array() )
	{

		foreach( $aggs as $key => $value) {
            if (is_array($value)) {
	            	                    
                foreach ($value as $keyM => $valueM) {
                    if ($keyM === 'visual') {
						
						if( !isset($valueM['target']) )
							$valueM['target'] = 'filters';
						
                        $this->aggs_visuals_map[$key] = $valueM;
                        unset($aggs[$key][$keyM]);

                    }
                }
            }
        }
        
		return $aggs;

	}

    public function __construct($collection, $settings)
    {

        if (
            (
                !isset($settings['aggs']) ||
                (empty($settings['aggs']))
            )
        )
            $settings['aggs'] = array();

        if(
	        isset($settings['aggsPreset']) &&
            array_key_exists($settings['aggsPreset'], $this->aggs_presets)
        )
        	$settings['aggs'] = array_merge($this->aggs_presets[$settings['aggsPreset']], $settings['aggs']);



        if( isset($settings['aggs']) )
        	$settings['aggs'] = $this->processAggs( $settings['aggs'] );

        if(
	        isset($settings['cover']) &&
	        isset($settings['cover']['aggs'])
        ) {
        	$settings['cover']['aggs'] = $this->processAggs( $settings['cover']['aggs'] );
        }
		
		

        $this->settings = $settings;

        if (isset($settings['cover']))
            $this->cover = $settings['cover'];

        if (isset($settings['chapters']))
            $this->chapters = $settings['chapters'];

        if (isset($settings['searchTitle']))
            $this->searchTitle = $settings['searchTitle'];

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

    }

    public function beforeRender($controller)
    {

		if( isset($this->settings['apps']) && $this->settings['apps'] ) {

			$apps = $controller->getDatasets();
	        $aggs = array();
	        foreach ($apps as $app_id => $datasets) {
	            $aggs['app_' . $app_id] = array(
	                'filter' => array(
	                    'terms' => array(
	                        'dataset' => array_keys($datasets),
	                    ),
	                ),
	                'scope' => 'query_main',
	            );
	        }

	        if( isset($this->settings['aggs']) )
		        $this->settings['aggs'] = array_merge($this->settings['aggs'], $aggs);
		    else
		    	$this->settings['aggs'] = $aggs;

	        $this->aggsMode = 'apps';

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

        // debug($this->getSettings()); die();

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

            // debug($this->getSettings());

            // $controller->Paginator->settings['order'] = 'score desc';
            // debug($controller->Paginator->settings); die();
            $hits = $controller->Paginator->paginate('Dataobject');

            $dataBrowser = array(
                'hits' => $hits,
                'took' => $controller->Dataobject->getPerformance(),
                'cancel_url' => $this->getCancelSearchUrl($controller),
                'api_call' => $controller->Dataobject->getDataSource()->public_api_call,
                'renderFile' => isset($this->settings['renderFile']) ? 'DataBrowser/templates/' . $this->settings['renderFile'] : 'default',
                'cover' => $this->cover,
                'chapters' => $this->chapters,
                'searchTitle' => $this->searchTitle,
                'searcher' => $this->searcher,
                'autocompletion' => $this->autocompletion,
                'mode' => 'data',
                'dataset' => $this->dataset,
                'aggs_visuals_map' => $this->prepareRequests($this->aggs_visuals_map, $controller),
            );



			$app_menu = array();
            $dataBrowser['aggs'] = $controller->Dataobject->getAggs();
            $dataBrowser['apps'] = $controller->Dataobject->getApps();


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


            foreach ($dataBrowser['apps'] as $app_id => $app_data) {

                $app = $controller->getApplication($app_id);
                $app_menu[] = array(
                    'id' => $app['id'],
                    'href' => $app['href'],
                    'title' => $app['name'],
                );

            }

            if( $app_menu )
            	$controller->app_menu[0] = $app_menu;


			/*
            if (
                isset($controller->Paginator->settings['conditions']) &&
                isset($controller->Paginator->settings['conditions']['dataset']) &&
                is_array($controller->Paginator->settings['conditions']['dataset']) &&
                (count($controller->Paginator->settings['conditions']['dataset']) > 1) &&
                isset($dataBrowser['aggs']['dataset']) &&
                isset($dataBrowser['aggs']['dataset']['buckets']) &&
                (count($dataBrowser['aggs']['dataset']['buckets']) === 1) &&
                ($dataBrowser['aggs']['dataset']['buckets'][0]['doc_count'])
            ) {

                $params = array();
                $conditions = $controller->Paginator->settings['conditions'];
                if (isset($conditions['dataset']))
                    unset($conditions['dataset']);

                if (isset($conditions['q'])) {
                    $params['q'] = $conditions['q'];
                    unset($conditions['q']);
                }

                $params['conditions'] = $conditions;

                $url = '/dane/' . $dataBrowser['aggs']['dataset']['buckets'][0]['key'];
                $url .= '?' . http_build_query($params);

                return $controller->redirect($url);

            }
            */


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
                );

                if (isset($this->cover['aggs']))
                    $params['aggs'] = $this->cover['aggs'];

                if (isset($this->cover['conditions'])) {

                    $params['conditions'] = array_merge($params['conditions'], $this->cover['conditions']);

                }

                $controller->Dataobject->find('all', $params);

				$dataBrowser = array(
                    'aggs' => $controller->Dataobject->getAggs(),
                    'cover' => $this->cover,
                    'cancel_url' => false,
                    'chapters' => $this->chapters,
                    'searchTitle' => $this->searchTitle,
                    'searcher' => $this->searcher,
                    'autocompletion' => $this->autocompletion,
                    'mode' => 'cover',
                    'dataset' => $this->dataset,
	                'aggs_visuals_map' => $this->prepareRequests($this->aggs_visuals_map, $controller),
                );
								
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
        );

        if (isset($conditions['q']))
            $output['highlight'] = true;

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

            if (isset($map['field']) && isset($cancelQuery['conditions'][$map['field']]))
                unset($cancelQuery['conditions'][$map['field']]);

            if (isset($cancelQuery['page']))
                unset($cancelQuery['page']);
            if (isset($cancelQuery['conditions']['q']))
                unset($cancelQuery['conditions']['q']);
            $maps[$i]['cancelRequest'] = $controller->here . '?' . http_build_query($cancelQuery);

            // Wybieranie np. danego typu
            // Nie znamy jeszcze id dlatego na końcu zostawiamy `=` np.
            // http://.../?..&conditions[type.id]=
            $chooseQuery = $query;

            if (isset($cancelQuery['page']))
                unset($cancelQuery['page']);

            $r = $controller->here . '?' . http_build_query($cancelQuery);
            if (isset($map['field']))
                $r .= '&conditions[' . $map['field'] . ']=';

            $maps[$i]['chooseRequest'] = $r;

            if( isset($maps[$i]['forceKey']) )
            	$maps[ $maps[$i]['forceKey'] ] = $maps[$i];
        }

        return $maps;
    }

}
