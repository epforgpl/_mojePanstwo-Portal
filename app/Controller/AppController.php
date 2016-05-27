<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('HttpSocket', 'Network/Http');
APP::import('Vendor', 'functions');
App::uses('I18n', 'I18n');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    private static $activeModals = array(
        'ngo1'
    );
    
    private $_languages = array('pol', 'eng');
    public $lang = 'pol';
    
    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'paszport',
                'action' => 'login',
                'plugin' => 'paszport'
            ),
            'loginRedirect' => '/', # After plain login redirect to main page
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email', 'password' => 'password'),
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'sha256'
                    ),
                    'userModel' => 'Paszport.User',
//                    'contain' => array('Language', 'Group', 'UserExpand'),
                )
            )
//			,'authenticate' => array(
//				'Paszport'
//			)
        ),
    );
    public $protocol = 'https://';
    public $port = false;
    public $domainMode = 'MP';
    public $appSelected = false;
    public $breadcrumbs = array();
    public $menu = array();
    public $menu_selected = '_default';
    public $chapter_selected = false;
    public $observeOptions = false;
    public $app_menu = array(array(), array());
    public $helpers = array(
        'Html',
        'Form',
        'Paginator',
        'MPaginator',
        'Time',
        'Less.Less',
//        'Minify.Minify',
        'Application',
        'Combinator.Combinator',
    );
    public $statusbarCrumbs = array();
    public $statusbarMode = false;
    public $meta = array();
    public $_layout = array(
        'header' => array(
            'element' => 'main',
        ),
        'body' => array(
            'theme' => 'default',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );
    public $datasets = array(
        'krs' => array(
            'krs_podmioty' => array(
                'label' => 'Organizacje',
                'browserTitle' => 'Organizacje w Krajowym Rejestrze Sądowym',
                'searchTitle' => 'Szukaj organizacji...',
                'menu_id' => 'organizacje',
                'autocompletion' => array(
                    'dataset' => 'krs_podmioty',
                ),
            ),
            'krs_osoby' => array(
                'label' => 'Osoby',
                'browserTitle' => 'Osoby w Krajowym Rejestrze Sądowym',
                'searchTitle' => 'Szukaj osób...',
                'menu_id' => 'osoby',
            ),
            'msig' => array(
                'label' => 'Monitor Sądowy i Gospodarczy',
                'browserTitle' => 'Wydania Monitora Sądowego i Gospodarczego',
                'searchTitle' => 'Szukaj w Monitorze Sądowym i Gospodarczym',
                'menu_id' => 'msig',
            ),
        ),
        'srodowisko' => array(
            'srodowisko_stacje_pomiarowe' => array(
                'label' => 'Stacje pomiarowe',
                'menu_id' => '',
           ),
        ),
        'kultura' => array(
            'kultura_ankiety' => array(
                'label' => 'Pytania o kulturę',
                'menu_id' => '',
           ),
        ),
        'bdl' => array(
            'bdl_wskazniki' => array(
                'label' => 'Wskaźniki'
            ),
            'bdl_wskazniki_grupy' => array(
                'label' => 'Grupy wskaźników'
            ),
            'bdl_wskazniki_kategorie' => array(
                'label' => 'Kategorie wskaźników'
            ),
        ),
        'prawo' => array(
            'prawo' => array(
                'label' => 'Prawo powszechne',
                'searchTitle' => 'Szukaj w prawie powszechnym...',
                'menu_id' => 'powszechne',
                'autocompletion' => array(
                    'dataset' => 'prawo',
                ),
            ),
            'prawo_wojewodztwa' => array(
                'label' => 'Prawo lokalne',
                'searchTitle' => 'Szukaj w prawie lokalnym...',
                'menu_id' => 'lokalne',
            ),
            'prawo_urzedowe' => array(
                'label' => 'Prawo urzędowe',
                'searchTitle' => 'Szukaj w prawie urzędowym...',
                'menu_id' => 'urzedowe',
            ),
            'prawo_hasla' => array(
                'label' => 'Tematy w prawie',
                'searchTitle' => 'Szukaj w tematach...',
                'menu_id' => 'tematy',
                'autocompletion' => array(
                    'dataset' => 'prawo_hasla',
                ),
            ),
        ),
        'orzecznictwo' => array(
            'sa_orzeczenia' => array(
                'label' => 'Orzeczenia sądów administracyjnych',
                'searchTitle' => 'Szukaj w orzeczeniach sądów administracyjnych...',
                'menu_id' => 'sa',
            ),
            'sp_orzeczenia' => array(
                'label' => 'Orzeczenia sądów powszechnych',
                'searchTitle' => 'Szukaj w orzeczeniach sądów powszechnych...',
                'menu_id' => 'sp',
            ),
            'sn_orzeczenia' => array(
                'label' => 'Orzeczenia Sądu Najwyższego',
                'searchTitle' => 'Szukaj w orzeczeniach Sądu Najwyższego...',
                'menu_id' => 'sn',
            ),
        ),
        'ngo' => array(
            'ngo_tematy' => array(
                'label' => 'Tematy',
                'menu_id' => 'tematy',
            ),
            'ngo_konkursy' => array(
                'label' => 'Konkursy',
                'menu_id' => 'konkursy',
            ),
            'dzialania' => array(
                'label' => 'Działania',
                'menu_id' => 'dzialania',
            ),
            'pisma' => array(
                'label' => 'Pisma',
                'menu_id' => 'pisma',
            ),
            'zbiorki_publiczne' => array(
                'label' => 'Zbiórki publiczne',
                'menu_id' => 'zbiorki',
            ),
            'sprawozdania_opp' => array(
                'label' => 'Sprawozdania Organizacji Pożytku Publicznego',
                'menu_id' => 'sprawozdania_opp',
            ),
        ),
        'zamowienia_publiczne' => array(
            'zamowienia_publiczne' => array(
                'label' => 'Zamówienia publiczne',
            ),
            'zamowienia_publiczne_zamawiajacy' => array(
                'label' => 'Zamawiający',
                'menu_id' => 'zamawiajacy',
            ),
            'zamowienia_publiczne_wykonawcy' => array(
                'label' => 'Wykonawcy',
                'menu_id' => 'wykonawcy',
            ),
        ),
        /*
        'moja_gmina' => array(
            'gminy' => array(
            	'label' => 'Gminy',
            	'menu_id' => 'gminy',
            	'autocompletion' => array(
					'dataset' => 'gminy',
				),
            ),
            'powiaty' => array(
            	'label' => 'Powiaty',
            	'menu_id' => 'powiaty',
            ),
            'wojewodztwa' => array(
            	'label' => 'Województwa',
            	'menu_id' => 'wojewodztwa',
            ),
            'miejscowosci' => array(
            	'label' => 'Miejscowości',
            	'menu_id' => 'miejscowosci',
            ),
        ),
        */
        'media' => array(
            'twitter_accounts' => array(
                'label' => 'Obserwowane konta Twitter',
                'searchTitle' => 'Szukaj w kontach Twitter...',
                'menu_id' => 'twitter_konta',
                'default_order' => 'twitter_accounts.liczba_obserwujacych desc',
                'default_conditions' => array(
                    'twitter_accounts.liczba_tweetow>' => 0,
                ),
            ),
            'twitter' => array(
                'label' => 'Tweety',
                'searchTitle' => 'Szukaj w tweetach...',
                'menu_id' => 'tweety',
            ),
            'fb_accounts' => array(
                'label' => 'Obserwowane konta Facebook',
                'searchTitle' => 'Szukaj w kontach Facebook...',
                'menu_id' => 'fb_accounts',
                'default_order' => 'fb_accounts.likes desc',
            ),
            'fb_posts' => array(
                'label' => 'Posty',
                'searchTitle' => 'Szukaj w postach...',
                'menu_id' => 'posts',
            ),
        ),
        'sejmometr' => array(
            'poslowie' => array(
                'label' => 'Posłowie',
                'menu_id' => 'poslowie',
                'autocompletion' => array(
                    'dataset' => 'poslowie',
                ),
            ),
            'prawo_projekty' => array(
                'label' => 'Projekty aktów prawnych',
                'menu_id' => 'prawo_projekty',
            ),
            'sejm_dezyderaty' => array(
                'label' => 'Dezyderaty komisji',
                'menu_id' => 'dezyderaty',
            ),
            'sejm_druki' => array(
                'label' => 'Druki sejmowe',
                'menu_id' => 'druki',
            ),
            'sejm_glosowania' => array(
                'label' => 'Głosowania',
                'menu_id' => 'glosowania',
            ),
            'sejm_interpelacje' => array(
                'label' => 'Interpelacje',
                'menu_id' => 'interpelacje',
            ),
            'sejm_kluby' => array(
                'label' => 'Kluby sejmowe',
                'menu_id' => 'kluby',
            ),
            'sejm_komisje' => array(
                'label' => 'Komisje sejmowe',
                'menu_id' => 'komisje',
            ),
            'sejm_komunikaty' => array(
                'label' => 'Komunikaty Kancelarii Sejmu',
                'menu_id' => 'komunikaty',
            ),
            'sejm_posiedzenia' => array(
                'label' => 'Posiedzenia Sejmu',
                'menu_id' => 'posiedzenia',
            ),
            'sejm_posiedzenia_punkty' => array(
                'label' => 'Punkty porządku dziennego',
                'menu_id' => 'punkty',
            ),
            'sejm_wystapienia' => array(
                'label' => 'Wystąpienia podczas posiedzeń Sejmu',
                'menu_id' => 'wystapienia',
            ),
            'sejm_komisje_opinie' => array(
                'label' => 'Opinie komisji sejmowych',
                'menu_id' => 'komisje_opinie',
            ),
            'sejm_komisje_uchwaly' => array(
                'label' => 'Uchwały komisji sejmowych',
                'menu_id' => 'komisje_uchwaly',
            ),
            'poslowie_oswiadczenia_majatkowe' => array(
                'label' => 'Oświadczenia majątkowe posłów',
                'menu_id' => 'poslowie_oswiadczenia',
            ),
            'poslowie_rejestr_korzysci' => array(
                'label' => 'Rejestr korzyści posłów',
                'menu_id' => 'poslowie_korzysci',
            ),
            'poslowie_wspolpracownicy' => array(
                'label' => 'Współpracownicy posłów',
                'menu_id' => 'poslowie_wspolpracownicy',
            ),
        ),
        'kto_tu_rzadzi' => array(
            'instytucje' => array(
                'label' => 'Instytucje',
                'menu_id' => 'instytucje',
                'order' => 'weight desc',
                'autocompletion' => array(
                    'dataset' => 'instytucje',
                ),
            ),
        ),
    );
    public $applications = array(
        'krs' => array(
            'name_pol' => 'Krajowy Rejestr Sądowy',
            'subname_pol' => 'Przeglądaj firmy i organizacje pozarządowe zarejestrowane w KRS',
            'desc_pol' => 'Poznaj misje firm i organizacji pozarządowych, sposób ich reprezentacji oraz sprawdzaj powiązania osób z Zarządu i Rady z innymi organizacjami i firmami. Pobierz również za darmo odpis z KRS.',
            'name_eng' => 'National Business Register (KRS)',
            'subname_eng' => 'GET DETAILS ABOUT BUSINESSES AND NON-GOVERNMENTAL ORGANIZATIONS REGISTERED IN KRS',
            'desc_eng' => 'Learn about the mission and representation of businesses and non-governmental organizations, and check connections between management and supervisory board members of other organizations and businesses. Download excerpts from National Court Register (KRS) free of charge.',
            'href' => '/krs',
            'tag' => 1,
            'icon' => '&#xe605;',
        ),
        'ngo' => array(
            'name_pol' => 'NGO',
            'subname_pol' => 'Znajdź oraz zarządzaj kontem swojej organizacji i docieraj do wspierających',
            'desc_pol' => 'Pokaż, że jesteś specjalistą w swojej branży. Dodawaj działania swojej organizacji, pokaż jej aktywność w social media oraz pochwal się wysłanymi pismami w sprawach ważnych dla osób wspierających Twoją organizację.',
            'name_eng' => 'NGO',
            'subname_eng' => 'FIND AND MANAGE YOUR ORGANIZATION’S ACCOUNT, AND REACH OUT TO YOUR SUPPORTERS',
            'desc_eng' => 'Show that you are a specialist in your industry. Add your organization’s activities, share its social media activity, and display the posted letters on matters that your organization’s supporters find important.',
            'href' => '/ngo',
            'tag' => 1,
            'icon' => '&#xe614;',
            'path' => 'Ngo'
        ),
        'podatki' => array(
            'name_pol' => 'Jak są wydawane moje podatki?',
            'subname_pol' => 'Sprawdź, ile podatków płacisz oraz na co są wydawane',
            'desc_pol' => 'Wpisz wysokość swoich dochodów i dowiedz się, na co konkretnie idą Twoje podatki. Dodatkowo możesz ustalić własne preferencje ich wydatkowania i przesłać je do dalszej analizy.',
            'name_eng' => 'HOW ARE MY TAXES SPENT?',
            'subname_eng' => 'Check how much taxes do you pay and what are they being spent for',
            'desc_eng' => 'Type in what your income is to learn how the income tax you paid is used by the state administration. Additionally, you can set your own preferences regarding income tax spending and refer them for further analysis.',
            'href' => '/podatki',
            'tag' => 1,
            'icon' => '&#xe901;',
        ),
        'srodowisko' => array(
            'name_pol' => 'Środowisko',
            'subname_pol' => 'Dane o jakości powietrza w Polsce',
            'desc_pol' => 'Poznaj dane o jakości powietrza w Polsce. Sprawdzaj indeks jakości powietrza i stężenia niebezpiecznych gazów w atmosferze.',
            'name_eng' => 'ENVIRONMENT',
            'subname_eng' => 'AIR QUALITY IN POLAND',
            'desc_eng' => 'Get information about air quality in Poland. Check the air quality index and greenhouse gas index.',
            'href' => '/srodowisko',
            'tag' => 1,
            'icon' => '&#xe605;',
        ),
        'kultura' => array(
            'name_pol' => 'Kultura',
            'subname_pol' => 'Badanie postrzegania kultury w Polsce',
            'desc_pol' => 'Poznaj dane o jakości powietrza w Polsce. Sprawdzaj indeks jakości powietrza i stężenia niebezpiecznych gazów w atmosferze.',
            'name_eng' => 'CULTURE',
            'subname_eng' => 'LEARN ABOUT CULTURE CONSUMPTION ',
            'desc_eng' => 'Check culture consumption in Poland: how often people go to the cinema and the theatre, how many books they read, and how often they use the Internet.',
            'href' => '/kultura',
            'tag' => 1,
            'icon' => '&#xe900;',
        ),
        'prawo' => array(
            'name_pol' => 'Prawo',
            'subname_pol' => 'Przeglądaj ujednolicone teksty polskiego prawa',
            'desc_pol' => 'Sprawdzaj za darmo wszystkie akty prawne w interesujących Cię tematach. Znajdziesz je wpisując w wyszukiwarkę nazwę lub słowo kluczowe, które zawiera.',
            'name_eng' => 'Law',
            'subname_eng' => 'VIEW CONSOLIDATED TEXTS OF POLISH LAWS',
            'desc_eng' => 'Get free access to all acts of law. You will find the act of your choice by typing in its name or a key word it contains.',
            'href' => '/prawo',
            'tag' => 1,
            'icon' => '&#xe60d;',
        ),
        'bdl' => array(
            'name_pol' => 'Bank Danych Lokalnych',
            'subname_pol' => 'Poznaj dane statystyczne w interesującym Cię obszarze',
            'desc_pol' => 'Przeglądaj dowolne dane statystyczne za wybrany okres czasu. Porównuj je na wykresach i mapach obszarowych Polski.',
            'name_eng' => 'LOCAL DATA BANK',
            'subname_eng' => 'LEARN STATISTICAL DATA IN A CHOSEN AREA',
            'desc_eng' => 'View statistical data for a chosen period. Use graphs and maps of Poland to compare the data.',
            'href' => '/bdl',
            'tag' => 1,
            'icon' => '&#xe615;',
        ),
        'kto_tu_rzadzi' => array(
            'name_pol' => 'Kto tu rządzi?',
            'subname_pol' => 'Dowiedz się kto sprawuje władzę w Twojej okolicy',
            'desc_pol' => 'Prześledź działania wybranych instytucji państwowych. Zapoznaj się z tworzonymi przez nie raportami i analizami oraz wykorzystuj je w codziennej pracy.',
            'name_eng' => 'WHO HOLDS THE POWER HERE?',
            'subname_eng' => 'LEARN WHO IS IN POWER IN YOUR AREA',
            'desc_eng' => 'Follow the activity of chosen state institutions. Read their reports and analyses, and use them in your daily work.',
            'href' => '/kto_tu_rzadzi',
            'src' => '/KtoTuRzadzi/icon/kto_tu_rzadzi.svg',
            'tag' => 1,
            'icon' => '&#xe609;',
        ),
        'media' => array(
            'name_pol' => 'Media',
            'subname_pol' => 'Śledź aktywności sektora publicznego w mediach społecznościowych',
            'desc_pol' => 'Monitoruj treści tworzone przez polityków, komentatorów, miasta, urzędników oraz organizacje pozarządowe na Twitterze. Zobacz, o czym piszą i włącz się do dyskusji z nimi na wybrane przez siebie tematy.',
            'name_eng' => 'Media',
            'subname_eng' => 'FOLLOW THE PUBLIC SECTOR’S SOCIAL MEDIA ACTIVITY',
            'desc_eng' => 'Track tweets created by politicians, commentators, clerks, cities and non-governmental organizations. Learn what they write about and join the discussions on chosen topics.',
            'href' => '/media',
            'tag' => 1,
            'icon' => '&#xe608;',
        ),
        'dostep_do_informacji_publicznej' => array(
            'name_pol' => 'Dostęp do Informacji Publicznej',
            'subname_pol' => 'Twórz i wysyłaj wnioski o dostęp do informacji publicznej',
            'desc_pol' => 'Dowiedz się, w jakich przypadkach możesz wysłać wniosek o dostęp do informacji publicznej oraz jakie prawa Ci przysługują, jeśli urząd nie wypełni prawa w tym zakresie.',
            'name_eng' => 'ACCESS TO PUBLIC INFORMATION',
            'subname_eng' => 'CREATE AND FILE MOTIONS REQUESTING ACCESS TO PUBLIC INFORMATION',
            'desc_eng' => 'Find out when you can file a motion requesting access to public information and learn what rights you have if you are denied access thereof.',
            'href' => '/dostep_do_informacji_publicznej',
            'tag' => 1,
            'icon' => '&#xe60e;',
            'path' => 'RaportyDostepDoInformacjiPublicznej',
        ),
        'finanse' => array(
            'name_pol' => 'Finanse publiczne',
            'subname_pol' => 'Rozliczaj państwo oraz gminy z realizacji swoich budżetów',
            'desc_pol' => 'Porównaj rządy poszczególnych Premierów i zobacz, kiedy był największy deficyt, dochody oraz wydatki. Dodatkowo prześledź wydatki wybranej polskiej gminy i zobacz, na co wydatkowany jest jej budżet.',
            'name_eng' => 'PUBLIC FINANCES',
            'subname_eng' => 'MAKE STATE AMINISTRATION AND MUNICIPALITIES ACCOUNTABLE FOR IMPLEMENTING BUDGETS',
            'desc_eng' => 'Compare terms of particular Prime Ministers, and find out about the highest levels of deficit, income and spending. Additionally, track chosen Polish municipality’s expenditure, and learn how its budget is implemented.',
            'href' => '/finanse',
            'tag' => 1,
            'icon' => '&#xe602;',
        ),
        'zamowienia_publiczne' => array(
            'name_pol' => 'Zamówienia publiczne',
            'subname_pol' => 'Kontroluj wydawanie publicznych pieniędzy i sprawdzaj do kogo trafiają',
            'desc_pol' => 'Zbadaj największe zamówienia publiczne w instytucjach publicznych oraz to, na jakie działania zostały przeznaczone środki publiczne.',
            'name_eng' => 'PUBLIC PROCUREMENT',
            'subname_eng' => 'TRACK PUBLIC FUNDS SPENDING AND CHECK WHO OBTAINS THEM',
            'desc_eng' => 'Examine the biggest public procurement contracts in public institutions and learn where public funds are allocated.',
            'href' => '/zamowienia_publiczne',
            'tag' => 1,
            'icon' => '&#xe613;',
        ),
        'handel_zagraniczny' => array(
            'name_pol' => 'Handel zagraniczny',
            'subname_pol' => 'Dowiedz się więcej o polskim imporcie i eksporcie',
            'desc_pol' => 'Przeglądaj z kim Polska najczęściej wymieniała swoje towary. Do jakiego kraju eksportowano, a z jakiego importowano.',
            'name_eng' => 'FOREIGN TRADE',
            'subname_eng' => 'LEARN MORE ABOUT POLISH IMPORT AND EXPORT',
            'desc_eng' => 'Explore which countries are Poland’s trading partners: where Poland exports to and imports from the most.',
            'href' => '/handel_zagraniczny',
            'tag' => 1,
            'icon' => '&#xe617;',
        ),
        'mapa' => array(
            'name_pol' => 'Mapa',
            'subname_pol' => 'Śledź działania innych w swojej okolicy',
            'desc_pol' => 'Sprawdź, jakie działania podejmowane są w Twojej okolicy oraz jakie firmy i organizacje pozarządowe są zarejestrowane w wybranej lokalizacji.',
            'name_eng' => 'Map',
            'subname_eng' => 'TRACK OTHERS ACTIVITIES IN YOUR AREA',
            'desc_eng' => 'Check activity in your area and find out what businesses and non-governmental organizations are registered in a chosen location.',
            'href' => '/mapa',
            'tag' => 1,
            'icon' => '&#xe900;',
        ),
        'api' => array(
            'name_pol' => 'API',
            'name_eng' => 'API',
            'href' => '/api',
            'tag' => 4,
            'icon' => '&#xe902;',
        ),

        'dane' => array(
            'name_pol' => 'Dane publiczne',
            'name_eng' => 'Public data',
            'href' => '/dane',
            'tag' => 0,
            'icon' => '&#xe616;',
        ),

        /*
        'kody_pocztowe' => array(
            'name' => 'Kody pocztowe',
            'href' => '/kody_pocztowe',
            'tag' => 1,
            'icon' => '&#xe604;',
        ),
        */
        /*
        'koleje' => array(
            'name' => 'Koleje',
            'href' => '/koleje',
            'src' => '/HandelZagraniczny/icon/handel_zagraniczny.svg',
            'tag' => 1,
        ),
        */
        /*
        'mapa_prawa' => array(
            'name' => 'Mapa prawa',
            'href' => '/mapa_prawa',
            'tag' => 1,
            'icon' => '&#xe607;',
        ),
        */

        /*
        'moja_gmina' => array(
            'name' => 'Moja Gmina',
            'href' => '/moja_gmina',
            'tag' => 1,
            'icon' => '&#xe605;',
        ),
        */


        'paszport' => array(
            'name_pol' => 'Paszport',
            'name_eng' => 'Paszport',
            'href' => '/paszport',
            'tag' => 3,
            'icon' => '&#xe60c;',
        ),
        /*
        'patenty' => array(
            'name' => 'Patenty',
            'href' => '/patenty',
            'src' => '/sejmometr/icon/sejmometr.svg',
            'tag' => 1,
        ),
        */
        'pisma' => array(
            'name_pol' => 'Pisma',
            'name_eng' => 'Pisma',
            'href' => '/pisma',
            'tag' => 3,
            'icon' => '&#xe60b;',
        ),
        'orzecznictwo' => array(
            'name_pol' => 'Orzecznictwo',
            'subname_pol' => 'Przeglądaj potężną bazę wyroków sądów',
            'desc_pol' => 'Czytaj za darmo najnowsze orzeczenia Sądu Najwyższego, sądów powszechnych oraz sądów administracyjnych.',
            'name_eng' => 'RULINGS',
            'subname_eng' => 'BROWSE COURT RULINGS DATA BASE',
            'desc_eng' => 'Read the latest rulings of the Supreme Court, judicial and administrative tribunals, for free.',
            'href' => '/orzecznictwo',
            'tag' => 1,
            'icon' => '&#xe617;',
        ),
        'sejmometr' => array(
            'name_pol' => 'Sejmometr',
            'subname_pol' => 'Monitoruj pracę i działania Sejmu',
            'desc_pol' => 'Nadzoruj pracę swoich przedstawicieli w Sejmie: ich głosowania, interpelacje oraz wystąpienia publiczne. Śledź posiedzenia Sejmu oraz tworzone podczas nich ustawy.',
            'name_eng' => 'Sejmometr',
            'subname_eng' => 'TRACK SEJM ACTIVITY',
            'desc_eng' => 'Track your Sejm representatives’ activity: their votes, questions, and public speeches. Follow Sejm meetings and the law-making process.',
            'href' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej',
            'tag' => 1,
            'icon' => '&#xe610;',
        ),
        'pomoc' => array(
            'name_pol' => 'Pomoc',
            'name_eng' => 'Pomoc',
            'href' => '/pomoc',
            'tag' => 3,
            'icon' => '&#xe903;',
        ),
        'powiadomienia' => array(
            'name_pol' => 'Powiadomienia',
            'name_eng' => 'Notifications',
            'href' => '/powiadomienia',
            'tag' => 3,
            'icon' => '&#xe60a;',
		),
        'wydatki_poslow' => array(
            'name_pol' => 'Wydatki Posłów',
            'subname_pol' => 'Kontroluj zarobki i wydatki posłów',
            'desc_pol' => 'Obserwuj na co posłowie średnio wydają najwięcej pieniędzy oraz kto przoduje w wybranych kategoriach.',
            'name_eng' => 'LAWMAKERS’ SPENDING',
            'subname_eng' => 'MONITOR LAWMAKERS’ EARNINGS AND SPENDINGS',
            'desc_eng' => 'Follow what our lawmakers spend most money on, and find out a leader in a specific spending category.',
            'href' => '/wydatki_poslow',
            'tag' => 1,
            'icon' => '&#xe611;',
        ),
        'wyjazdy_poslow' => array(
            'name_pol' => 'Wyjazdy Posłów',
            'subname_pol' => 'Zobacz, gdzie na świecie reprezentują nas posłowie',
            'desc_pol' => 'Monitoruj wyjazdy zagraniczne posłów, w których uczestniczą w różnych spotkaniach, konferencjach, szkoleniach. Jako obywatele i działacze organizacji pozarządowych mamy prawo wiedzieć, gdzie osoby, które wybraliśmy nas reprezentują oraz w jakiej sprawie udają się w dane miejsce.',
            'name_eng' => 'LAWMAKERS’ TRIPS',
            'subname_eng' => 'FIND OUT WHERE OUR LAWMAKERS REPRESENT US IN THE WORLD',
            'desc_eng' => 'Track our lawmakers’ foreign trips during which they participate in meetings, conferences and trainings. As citizens and members of non-governmental organizations, we have a right to know where the persons we elected represent us and what the purposes of their trips are.',
            'href' => '/wyjazdy_poslow',
            'tag' => 1,
            'icon' => '&#xe612;',
        ),
    );

	public function __construct($request = null, $response = null)
    {

        if( defined("PORTAL_UNAVAILABLE") && PORTAL_UNAVAILABLE ) {

            header('Content-Type: text/html; charset=utf-8');
		    header('HTTP/1.1 503 Service Temporarily Unavailable');
			header('Status: 503 Service Temporarily Unavailable');

            print("<br/><br/><br/><br/><br/><center><p>Przenosimy portal mojePaństwo na nowe serwery.</p><p>Zapraszamy po godzine 12.</p><p><a target=\"_blank\" href=\"http://epf.org.pl\">Fundacja ePaństwo</a></p></center>"); die();

        } else {

            parent::__construct ($request, $response);

        }

    }

    public function beforeFilter()
    {

        $this->protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $this->port = ($_SERVER['SERVER_PORT'] == 80) ? false : ':' . $_SERVER['SERVER_PORT'];
		
		
		
		if( 
			$this->Session->read('Config.language') && 
			in_array($this->Session->read('Config.language'), $this->_languages)
		)
			$this->lang = $this->Session->read('Config.language');
		else
			$this->lang = 'pol';
			
		$this->set('_lang', $this->lang);
		Configure::write('Config.language', $this->lang);
		
		
		// switch languages
		
		if( 
			array_key_exists('lang', $this->request->query) && 
			in_array($this->request->query['lang'], $this->_languages)
		) {
			
			$query = $this->request->query;
			unset( $query['lang'] );
			$url = $this->request->here;
			if( !empty($query) )
				$url .= '?' . http_build_query($query);
			
			Configure::write("Config.language", $this->request->query['lang']);
			$this->Session->write('Config.language', Configure::read('Config.language'));
			
			return $this->redirect( $url );
			
		}
		
		
        if (defined('PORTAL_DOMAIN')) {
            $pieces = parse_url(Router::url($this->here, true));

            if (defined('PK_DOMAIN') && ($pieces['host'] == PK_DOMAIN)) {

                $this->domainMode = 'PK';

                // only certain actions are allowed in this domain
                // for other actions we are immediatly redirecting to PORTAL_DOMAIN

                if (stripos($_SERVER['REQUEST_URI'], '/dane/gminy/903') === 0) {

                    $url = substr($_SERVER['REQUEST_URI'], 15);
                    if ($url[0] == ',') {

                        $p = strpos($url, '/');
                        $url = ($p === false) ? '' : substr($url, $p);

                    }

                    $this->redirect($this->protocol . PK_DOMAIN . $this->port . $url);
                    die();

                }

                if (preg_match('/^(.*?)\,([a-z0-9\-]+)$/', $this->here, $match)) {

                    $this->redirect($this->protocol . PK_DOMAIN . $this->port . $match[1]);
                    die();
                }

                $_id = strtolower($this->request->params['plugin'] . '.' . $this->request->params['controller']);

                $cross_domain = (
                    stripos($_SERVER['REQUEST_URI'], '/cross-domain-') === 0 or
                    stripos($_SERVER['REQUEST_URI'], '/login') === 0 or
                    stripos($_SERVER['REQUEST_URI'], '/logout') === 0
                );

                if (
                    !in_array($_id, array(
                        'dane.gminy',
                        'dane.highstock_browser',
                        'powiadomienia.powiadomienia',
                        'subscriptions.subscriptions',
                        'pisma.pisma',
                        'pisma.szablony',
                        'zamowieniapubliczne.zamowieniapubliczne',
                        'finanse.gminy'
                    )) &&
                    !$cross_domain
                ) {


                    $url = $_SERVER['REQUEST_URI'];
                    if ($url[0] == ',') {
                        $p = strpos($url, '/');
                        $url = ($p === false) ? '' : substr($url, $p);
                    }
                    return $this->redirect($this->protocol . PORTAL_DOMAIN . $this->port . $url);

                }

            } elseif ($pieces['host'] != PORTAL_DOMAIN) {

                $this->redirect($this->protocol . PORTAL_DOMAIN . $this->port . $this->here, 301);
                die();

            }

        }

        $this->response->header('Access-Control-Allow-Origin', $this->request->header('Origin'));
        $this->response->header('Access-Control-Allow-Credentials', true);


        $redirect = false;

        if ($this->Session->read('Auth.User.id') && $this->Session->read('Pisma.transfer_anonymous')) {

            $this->loadModel('Pisma.Pismo');
            $this->Pismo->transfer_anonymous($this->Session->read('previous_id'));
            $this->Session->delete('Pisma.transfer_anonymous');

            $redirect = true;

        }

        if ($redirect)
            return $this->redirect($this->request->here);


        # assigning translations for javascript use
        if (@$this->params->plugin) {
            $path = ROOT . DS . APP_DIR . DS . 'Plugin' . DS . Inflector::camelize($this->params->plugin) . DS . 'Locale' . DS . Configure::read('Config.language') . DS . 'LC_MESSAGES' . DS . Inflector::underscore($this->params->plugin) . '.po';
        } else {
            $path = ROOT . DS . APP_DIR . DS . 'Locale' . DS . Configure::read('Config.language') . DS . 'LC_MESSAGES' . DS . 'default.po';
        }
        if (file_exists($path)) {
            $translations = I18n::loadPo($path);
            foreach ($translations as &$item) {
                $item = stripslashes($item);
                $item = preg_replace('/"/', '&quot;', $item);
            }
        } else {
            $translations = array();
        }
        $this->set('translation', $translations);

        parent::beforeFilter();
        $this->Auth->allow();

        $this->set('statusbarCrumbs', $this->statusbarCrumbs);
        $this->set('statusbarMode', $this->statusbarMode);
        $this->set('_APPLICATIONS', $this->getApplications());
        $this->set('_APPLICATION', $this->getApplication());
        $this->set('domainMode', $this->domainMode);

//		// remember path for redirect if necessary
//		if ( Router::url( null ) != '/null' ) { // hack for bug
//			$this->Session->write( 'Auth.loginRedirect', Router::url( null, true ) );
//		}

        // cross domain login
        $this->set('current_host', $_SERVER['HTTP_HOST']);
        if ($this->Session->check('crossdomain_login_token')) {
            $this->set('crossdomain_login_token', $this->Session->read('crossdomain_login_token'));
            $this->Session->delete('crossdomain_login_token');
        }
        if ($this->Session->check('crossdomain_logout')) {
            $this->set('crossdomain_logout', $this->Session->read('crossdomain_logout'));
            $this->Session->delete('crossdomain_logout');
        }

        $this->set('isAdmin', $this->hasUserRole('2'));

    }

    /**
     * Zwraca listę dostępnych aplikacji
     * @return array
     */
    public function getApplications($options = array())
    {
        return $this->applications;
    }

    /**
     * Zwraca aktualną aplikację
     * lub false jeśli nie żadna nie jest aktywna w danej chwili
     * @return array|bool
     */
    public function getApplication($id = false)
    {

        if ($id && array_key_exists($id, $this->applications)) {

            return array_merge($this->applications[$id], array(
                'id' => $id,
            ));

        } else return false;

    }

    public function hasUserRole($role)
    {

        $roles = $this->getUserRoles();
        if (@in_array('2', $roles))
            return true;
        else
            return @in_array($role, $roles);

    }

    public function getUserRoles()
    {

        if ($this->Auth->user()) {

            return @array_column($this->Auth->user('UserRole'), 'role_id');

        } else return array();

    }

    public function getDatasetByAlias($app_id = false, $alias = false)
    {
        if ($app_id && $alias && array_key_exists($app_id, $this->datasets)) {
            foreach ($this->datasets[$app_id] as $dataset_id => $dataset_name) {
                if (@$dataset_name['menu_id'] == $alias) {
                    return array(
                        'app_id' => $app_id,
                        'dataset_id' => $dataset_id,
                        'dataset_name' => $dataset_name,
                    );
                }
            }
        }
    }

    public function getDataset($id = false)
    {
        if ($id) {
            foreach ($this->datasets as $app_id => $datasets) {
                foreach ($datasets as $dataset_id => $dataset_name) {
                    if ($dataset_id == $id) {
                        return array(
                            'app_id' => $app_id,
                            'dataset_id' => $dataset_id,
                            'dataset_name' => $dataset_name,
                        );
                    }
                }
            }
        }
        return false;
    }

    public function beforeRender()
    {		
		
        if (@$this->request->params['ext'] != 'json') {

            $layout = $this->setLayout();
            $menu = $this->getMenu();

            if (!empty($menu)) {

                if ($this->menu_selected == '_default')
                    $this->menu_selected = $this->request->params['action'];

                $menu['selected'] = $this->menu_selected;

            }

            $this->set('_layout', $layout);
            $this->set('_breadcrumbs', $this->breadcrumbs);
            $this->set('_applications', $this->applications);
            $this->set('_menu', $menu);
            $this->set('_observeOptions', $this->observeOptions);
            $this->set('_domainMode', $this->domainMode);
            $this->set('_user', $this->Auth->user());
            $this->set('appSelected', $this->appSelected);

            $this->set('_modals', $this->loadModals());

            if( $this->name == 'CakeError' ) {
	            $this->set('title_for_layout', 'Błąd');
            }

        }

    }

    /**
     * Ustawia informację o układzie layoutu strony
     * @param array $layout
     * @return array
     */
    public function setLayout($layout = array())
    {
        if (!empty($layout) && is_array($layout))
            $this->_layout = array_merge($this->_layout, $layout);

        return $this->_layout;
    }

    /**
     * Zwraca listę elementów w menu
     * @return array
     */
    public function getMenu()
    {
        return $this->menu;
    }

    private function loadModals() {
        $modalsElements = array();

        if(!$this->Auth->user())
            return $modalsElements;

        $this->loadModel('Paszport.User');
        $modals = false;
        foreach(self::$activeModals as $modal) {
            $user_id = (int) $this->Session->read('Modal.' . $modal);
            if($this->Auth->user('id') != $user_id) {
                if(!$modals) {
                    $response = $this->User->getModals();
                    $modals = $response['modals'];
                }

                $this->Session->write('Modal.' . $modal, $this->Auth->user('id'));

                if(in_array($modal, $modals)) {
                    $this->User->addModal(array(
                        'modal' => $modal
                    ));

                    $modalsElements[] = $modal;
                    break;
                }
            }
        }

        return $modalsElements;
    }

    public function addStatusbarCrumb($item)
    {
        $this->statusbarCrumbs[] = $item;
        $this->set('statusbarCrumbs', $this->statusbarCrumbs);
    }

    public function setMetaDesc($val)
    {
        return $this->setMetaDescription($val);
    }

    public function setMetaDescription($val)
    {
        return $this->setMeta('description', $val);
    }

    public function setMeta($key, $val = null)
    {
        if (is_array($key)) {
            foreach ($key as $property => $content)
                $this->meta[$property] = $content;
            $this->set('_META', $this->meta);
            return true;
        }

        if (!$val)
            return false;

        $this->meta[$key] = $val;
        $this->set('_META', $this->meta);

        return $val;
    }

    public function prepareMetaTags()
    {
        $this->setMeta(array(
            'og:url' => Router::url($this->here, true),
            'og:type' => 'website',
            'og:description' => strip_tags(__('LC_MAINHEADER_TEXT')),
            'og:image' => FULL_BASE_URL . '/img/social/share_main.jpg',
            'fb:admins' => '616010705',
            'fb:app_id' => FACEBOOK_appId
        ));
    }

    public function addAppBreadcrumb($app_id = false)
    {
        if ($app = $this->getApplication($app_id)) {

            $this->set('_app', array(
	            'id' => $app['id'],
	            'name' => $app['name'],
	            'href' => $app['href'],
            ));

        }
    }

    public function addBreadcrumb($params)
    {
        $this->breadcrumbs[] = $params;
        $this->set('_breadcrumbs', $this->breadcrumbs);

    }

    public function getDatasets($app = false)
    {

        if ($app) {

            if (array_key_exists($app, $this->datasets))
                return $this->datasets[$app];
            else
                return false;

        } else return $this->datasets;

    }

    public function isSuperUser()
    {
        return $this->hasUserRole('2');
    }

    /**
     * Skrót do ustawiania zmiennych widoku, może być wywołana jednokrotnie podczas działania kontrolera
     *
     * Użyj ustawiając pojedynczą zmienną:
     *     $this->setSerialized('klucz', $zmienna);
     *
     * Lub podając tablicę zmiennych:
     *     $this->setSerialized(array('zmienna' => $zmienna));
     *     $this->setSerialized(compact($zmienna));
     *
     * @param $data
     * @param null $val
     */
    public function setSerialized($data, $val = null)
    {
        if (is_array($data)) {
            $this->set($data);
            $this->set('_serialize', array_keys($data));

        } else {
            // one value
            $this->set($data, $val);
            $this->set('_serialize', $data);
        }
    }
}
