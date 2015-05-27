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

    public $domainMode = 'MP';
    public $appSelected = false;
    public $breadcrumbs = array();
    public $menu = array();
    public $menu_selected = '_default';

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
    public $User = false;
    public $meta = array();
    public $pkMenu = array();

    /**
     * Obiekt określający układ oraz styl dla poszczegółnych stron
     *  header => array(
     *      element => ‘app’ , 'dataset', 'dataobject', 'pk', false
     *  ),
     *  body => array(
     *      theme => ‘default’, 'simple', 'wallpaper'
     *  ),
     *  footer => array(
     *      element => ‘default’, 'minimal;
     *  )
     */
    public $_layout = array(
        'header' => array(
            'element' => 'app',
        ),
        'body' => array(
            'theme' => 'default',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );

    private $datasets = array(
        'krs' => array(
            'krs_podmioty' => 'Organizacje',
            'krs_osoby' => 'Osoby',
        ),
        'bdl' => array(
            'bdl_wskazniki' => 'Wskaźniki'
        ),
        'prawo' => array(
            'prawo' => 'Prawo powszechne',
            'prawo_lokalne' => 'Prawo lokalne',
            'prawo_urzedowe' => 'Prawo urzędowe',
            'prawo_hasla' => 'Tematy w prawie',
        ),
        'orzecznictwo' => array(
            'sa_orzeczenia' => 'Orzeczenia sądów administracyjnych',
            'sp_orzeczenia' => 'Orzeczenia sądów powszechnych',
            'sn_orzeczenia' => 'Orzeczenia Sądu Najwyższego',
        ),
        'zamowienia_publiczne' => array(
            'zamowienia_publiczne' => 'Zamówienia publiczne',
        ),
        'moja_gmina' => array(
            'gminy' => 'Gminy',
            'powiaty' => 'Powiaty',
            'wojewodztwa' => 'Województwa',
            'miejscowosci' => 'Miejscowosci',
        ),
        'media' => array(
            'twitter' => 'Tweety',
            'twitter_accounts' => 'Konta na Twitterze',
        ),
        'sejmometr' => array(
            'poslowie' => 'Posłowie',
            'sejm_dezyderaty' => 'Dezyderaty komisji',
            'sejm_druki' => 'Druki sejmowe',
            'sejm_glosowania' => 'Głosowania',
            'sejm_interpelacje' => 'Interpelacje',
            'sejm_kluby' => 'Kluby sejmowe',
            'sejm_komisje' => 'Komisje sejmowe',
            'sejm_komunikaty' => 'Komunikaty Kancelarii Sejmu',
            'sejm_posiedzenia' => 'Posiedzenia Sejmu',
            'sejm_posiedzenia_punkty' => 'Punkty porządku dziennego',
            'sejm_wystapienia' => 'Wystąpienia podczas posiedzeń Sejmu',
            'sejm_komisje_opinie' => 'Opinie komisji sejmowych',
            'sejm_komisje_uchwaly' => 'Uchwały komisji sejmowych',
            'poslowie_oswiadczenia_majatkowe' => 'Oświadczenia majątkowe posłów',
            'poslowie_rejestr_korzysci' => 'Rejestr korzyści posłów',
            'poslowie_wspolpracownicy' => 'Współpracownicy posłów',
        ),
        'kto_tu_rzadzi' => array(
            'instytucje' => 'Instytucje',
        ),
    );
    private $applications = array(
        'krs' => array(
            'name' => 'Krajowy Rejestr Sądowy',
            'href' => '/krs',
            'tag' => 1,
            'icon' => '&#xe605;',
        ),
        'prawo' => array(
            'name' => 'Prawo',
            'href' => '/prawo',
            'tag' => 1,
            'icon' => '&#xe60d;',
        ),
        'orzecznictwo' => array(
            'name' => 'Orzecznictwo',
            'href' => '/orzecznictwo',
            'tag' => 1,
            'icon' => '&#xe60d;',
        ),
        'bdl' => array(
            'name' => 'Bank Danych Lokalnych',
            'href' => '/bdl',
            'tag' => 1,
            'icon' => '',
        ),
        'media' => array(
            'name' => 'Media',
            'href' => '/media',
            'tag' => 1,
            'icon' => '&#xe608;',
        ),
        'zamowienia_publiczne' => array(
            'name' => 'Zamówienia publiczne',
            'href' => '/zamowienia_publiczne',
            'tag' => 1,
            'icon' => '&#xe613;',
        ),
        'kto_tu_rzadzi' => array(
            'name' => 'Kto tu rządzi?',
            'href' => '/kto_tu_rzadzi',
            'src' => '/KtoTuRzadzi/icon/kto_tu_rzadzi.svg',
            'tag' => 1,
            'icon' => '&#xe609;',
        ),
        'moja_gmina' => array(
            'name' => 'Moja Gmina',
            'href' => '/moja_gmina',
            'tag' => 1,
            'icon' => '&#xe605;',
        ),
        'sejmometr' => array(
            'name' => 'Sejmometr',
            'href' => '/sejmometr',
            'tag' => 1,
            'icon' => '&#xe610;',
        ),
        /*
        'mapa_prawa' => array(
            'name' => 'Mapa prawa',
            'href' => '/mapa_prawa',
            'tag' => 1,
            'icon' => '&#xe607;',
        ),
        */
        /*
        'patenty' => array(
            'name' => 'Patenty',
            'href' => '/patenty',
            'src' => '/sejmometr/icon/sejmometr.svg',
            'tag' => 1,
        ),
        */
        'handel_zagraniczny' => array(
            'name' => 'Handel zagraniczny',
            'href' => '/handel_zagraniczny',
            'tag' => 1,
            'icon' => '&#xe603;',
        ),
        /*
        'koleje' => array(
            'name' => 'Koleje',
            'href' => '/koleje',
            'src' => '/HandelZagraniczny/icon/handel_zagraniczny.svg',
            'tag' => 1,
        ),
        */
        'kody_pocztowe' => array(
            'name' => 'Kody pocztowe',
            'href' => '/kody_pocztowe',
            'tag' => 1,
            'icon' => '&#xe604;',
        ),
        'dostep_do_informacji_publicznej' => array(
            'name' => 'Dostęp do Informacji Publicznej',
            'href' => '/dostep_do_informacji_publicznej',
            'tag' => 2,
            'icon' => '&#xe60e;',
        ),
        'wydatki_poslow' => array(
            'name' => 'Wydatki Posłów',
            'href' => '/wydatki_poslow',
            'tag' => 2,
            'icon' => '&#xe611;',
        ),
        'wyjazdy_poslow' => array(
            'name' => 'Wyjazdy Posłów',
            'href' => '/wyjazdy_poslow',
            'tag' => 2,
            'icon' => '&#xe612;',
        ),
        'finanse_gmin' => array(
            'name' => 'Finanse gmin',
            'href' => '/finanse_gmin',
            'tag' => 2,
            'icon' => '&#xe602;',
        ),
        'moje_dane' => array(
            'name' => 'Moje dane',
            'href' => '/moje-dane',
            'tag' => 3,
            'icon' => '&#xe60a;',
        ),
        'moje_pisma' => array(
            'name' => 'Moje pisma',
            'href' => '/moje-pisma',
            'tag' => 3,
            'icon' => '&#xe60b;',
        ),
    );

    public function beforeFilter()
    {
        $href_base = '/dane/gminy/903,krakow';

        if (defined('PORTAL_DOMAIN')) {
            $pieces = parse_url(Router::url($this->here, true));

            if (defined('PK_DOMAIN') && ($pieces['host'] == PK_DOMAIN)) {
                $this->domainMode = 'PK';

                // PREPARE MENU
                $href_base = '//' . PK_DOMAIN;

                // only certain actions are allowed in this domain
                // for other actions we are immediatly redirecting to PORTAL_DOMAIN

                if (stripos($_SERVER['REQUEST_URI'], '/dane/gminy/903') === 0) {

                    $url = substr($_SERVER['REQUEST_URI'], 15);
                    if ($url[0] == ',') {

                        $p = strpos($url, '/');
                        $url = ($p === false) ? '' : substr($url, $p);

                    }

                    $this->redirect('http://' . PK_DOMAIN . $url);
                    die();

                }

                if (preg_match('/^(.*?)\,([a-z0-9\-]+)$/', $this->here, $match)) {

                    $this->redirect('http://' . PK_DOMAIN . $match[1]);
                    die();
                }


                if (
                    ($this->request->params['controller'] == 'gminy') &&
                    in_array($this->request->params['action'], array(
                        'view',
                        'okregi_wyborcze',
                        'interpelacje',
                        'posiedzenia',
                        'debaty',
                        'punkty',
                        'szukaj',
                        'rada_uchwaly',
                        'druki',
                        'radni_powiazania',
                        'urzednicy_powiazania',
                        'radni',
                        'radni_6',
                        'radni6',
                        'uchwaly',
                        'radni_dzielnic',
                        'darczyncy',
                        'wskazniki',
                        'zamowienia',
                        'organizacje',
                        'biznes',
                        'ngo',
                        'spzoz',
                        'dotacje_ue',
                        'rady_gmin_wystapienia',
                        'map',
                        'zamowienia_publiczne',
                        'prawo_lokalne',
                        'urzednicy',
                        'oswiadczenia',
                        'jednostki',
                        'komisje',
                        'komisje_posiedzenia',
                        'sklad',
                        'dzielnice',
                        'zarzadzenia',
                        'zarzadzenie',
                        'urzad',
                        'rada',
                        'krs',
                        'komisje',
                        'rada_posiedzenia',
                        'rada_uchwaly',
                        'punkty',
                        'porzadek',
                        'podsumowanie',
                        'stenogram',
                        'informacja',
                        'glosowania',
                        'protokol',
                        'finanse',
                        'wpf'
                    ))
                ) {

                } elseif (
                ($this->request->params['controller'] == 'krs_podmioty')
                ) {

                } elseif (
                ($this->request->params['controller'] == 'Powiadomienia')
                ) {

                } elseif (
                ($this->request->params['controller'] == 'Pisma')
                ) {

                } elseif (
                ($this->request->params['controller'] == 'radni_dzielnic')
                ) {

                } elseif (
                ($this->request->params['controller'] == 'Subscriptions')
                ) {

                } elseif (stripos($_SERVER['REQUEST_URI'], '/cross-domain-') === 0
                    or stripos($_SERVER['REQUEST_URI'], '/login') === 0
                    or stripos($_SERVER['REQUEST_URI'], '/logout') === 0
                ) {

                } else {

                    $url = $_SERVER['REQUEST_URI'];
                    if ($url[0] == ',') {

                        $p = strpos($url, '/');
                        $url = ($p === false) ? '' : substr($url, $p);

                    }

                    $this->redirect('http://' . PORTAL_DOMAIN . $url);
                    die();

                }


            } elseif ($pieces['host'] != PORTAL_DOMAIN) {
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $this->redirect($protocol . PORTAL_DOMAIN . $this->here, 301);
                die();

            }

            $pkMenu = array(
                'base' => $href_base,
                'selected' => false,
                'items' => array(
                    array(
                        'label' => 'Aktualności',
                        'href' => $href_base,
                    ),
                )
            );
            $pkMenu['items'][] = array(
                'id' => 'rada',
                'label' => 'Rada Miasta',
                'href' => $href_base . '/rada',
            );

            $pkMenu['items'][] = array(
                'id' => 'urzad',
                'label' => 'Urząd Miasta',
                'href' => $href_base . '/urzad',
            );
            $pkMenu['items'][] = array(
                'id' => 'dzielnice',
                'label' => 'Dzielnice',
                'href' => $href_base . '/dzielnice',
            );
            $pkMenu['items'][] = array(
                'id' => 'zamowienia',
                'label' => 'Zamówienia publiczne',
                'href' => $href_base . '/zamowienia',
            );
            $pkMenu['items'][] = array(
                'id' => 'organizacje',
                'label' => 'Organizacje',
                'href' => $href_base . '/organizacje',
            );
            $pkMenu['items'][] = array(
                'id' => 'finanse',
                'href' => $href_base . '/finanse',
                'label' => 'Finanse',
                'icon' => '',
            );
            /*
            $pkMenu['items'][] = array(
                'id' => 'powiadomienia',
                'label' => 'Powiadomienia',
                'class' => 'always-visible pull-right',
                'dropdown' => array(
                    'items' => array(
                        array(
                            'id' => 'obserwuje_powiadomienia',
                            'label' => 'Dane',
                            'href' => $href_base . '/moje-dane',
                        ),
                        array(
                            'id' => 'jak_to_dziala',
                            'label' => 'Jak to działa?',
                            'href' => $href_base . '/moje-dane/jak_to_dziala',
                        )
                    )
                )
            );
            $pkMenu['items'][] = array(
                'id' => 'pisma',
                'label' => 'Pisma',
                'class' => 'always-visible pull-right',
                'dropdown' => array(
                    'items' => array(
                        array(
                            'id' => 'nowe_pismo',
                            'label' => 'Nowe pismo',
                            'href' => $href_base . '/moje-pisma/nowe',
                        ),
                        array(
                            'id' => 'moje_pisma',
                            'label' => 'Moje pisma',
                            'href' => $href_base . '/moje-pisma',
                        )
                    )
                )
            );
            */
            $this->set('pkMenu', $pkMenu);
        }

        $this->response->header('Access-Control-Allow-Origin', $this->request->header('Origin'));
        $this->response->header('Access-Control-Allow-Credentials', true);

        # assigning translations for javascript use
        if ($this->params->plugin) {
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

        // debug($this->getApplications()); die();

        $this->set('statusbarCrumbs', $this->statusbarCrumbs);
        $this->set('statusbarMode', $this->statusbarMode);
        $this->set('_APPLICATIONS', $this->getApplications());
        $this->set('_APPLICATION', $this->getApplication());
        $this->set('domainMode', $this->domainMode);
        $this->set('appSelected', $this->appSelected);

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

            return $this->applications[$id];

        } else return false;

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
        $layout = $this->setLayout();
        $menu = $this->getMenu();

        if ($this->menu_selected == '_default')
            $this->menu_selected = $this->request->params['action'];

        $menu['selected'] = $this->menu_selected;

        $this->set('_layout', $layout);
        $this->set('_breadcrumbs', $this->breadcrumbs);
        $this->set('_applications', $this->applications);
        $this->set('_menu', $menu);

        $redirect = false;

        if ($this->Session->read('Auth.User.id') && $this->Session->read('Pisma.transfer_anonymous')) {

            $this->loadModel('Pisma.Pismo');
            $this->Pismo->transfer_anonymous($this->Session->read('previous_id'));
            $this->Session->delete('Pisma.transfer_anonymous');

            $redirect = true;

        }

        if ($this->Session->read('Auth.User.id') && $this->Session->read('Powiadomienia.transfer_anonymous')) {

            $this->loadModel('Dane.Subscription');
            $this->Subscription->transfer_anonymous($this->Session->read('previous_id'));
            $this->Session->delete('Powiadomienia.transfer_anonymous');

            $redirect = true;

        }

        if ($redirect)
            return $this->redirect($this->request->here);
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

            $this->addBreadcrumb(array(
                'label' => $app['name'],
                'icon' => '<i class="glyphicon" data-icon-applications="' . $app['icon'] . '"></i>',
                'href' => $app['href'],
            ));
        }
    }

    public function addBreadcrumb($params)
    {
        $this->breadcrumbs[] = $params;
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
}