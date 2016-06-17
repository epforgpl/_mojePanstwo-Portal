<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

$host = explode(':', $_SERVER['HTTP_HOST']);
$host = array_shift($host);

if ( $host == PK_DOMAIN ) { // HTTP_X_FORWARDED_HOST
	
	$pk_actions = array('view', 'okregi_wyborcze', 'interpelacje', 'posiedzenia', 'debaty', 'punkty', 'szukaj', 'rada_uchwaly', 'druki', 'radni_powiazania', 'urzednicy_powiazania', 'radni', 'radni_6', 'radni6', 'uchwaly', 'radni_dzielnic', 'darczyncy', 'wskazniki', 'zamowienia', 'zamowienia_rozstrzygniete', 'organizacje', 'biznes', 'ngo', 'spzoz', 'dotacje_ue', 'rady_gmin_wystapienia', 'map', 'zamowienia_publiczne', 'prawo_lokalne', 'urzednicy', 'oswiadczenia', 'jednostki', 'komisje', 'komisje_posiedzenia', 'sklad', 'dzielnice', 'zarzadzenia', 'zarzadzenie', 'urzad', 'rada', 'krs', 'komisje', 'rada_posiedzenia', 'rada_uchwaly', 'punkty', 'porzadek', 'podsumowanie', 'stenogram', 'informacja', 'glosowania', 'protokol', 'finanse', 'wpf', 'wpf_finanse', 'pomoc_publiczna', 'osoby', 'umowy', 'urzad_zamowienia', 'okregi', 'aktywnosci', 'glosuj', 'dzialania', 'komisje_opinie', 'wpf_mapa');
	$pk_actions_reg = '(' . implode('|', $pk_actions) . ')';
	
	Router::connect( '/', array( 'plugin' => 'Dane', 'controller' => 'gminy', 'action' => 'view', 'id' => 903 ) );
	Router::connect('/login', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));
	Router::connect('/logout', array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'logout'));
	
	Router::connect('/:action', array(
		'plugin' => 'Dane', 
		'controller' => 'gminy', 
		'id' => '903'
	), array(
		'action' => $pk_actions_reg,
		// 'subid' => '([0-9]+)',
		'pass' => array('id'),
	));
	
	Router::connect('/:action/:subid', array(
		'plugin' => 'Dane', 
		'controller' => 'gminy', 
		'id' => '903'
	), array(
		'action' => $pk_actions_reg,
		'subid' => '([0-9]+)',
		'pass' => array('id', 'sub_id'),
	));
	
	Router::connect('/:action/:subid/:subaction', array(
		'plugin' => 'Dane', 
		'controller' => 'gminy', 
		'id' => '903'
	), array(
		'action' => $pk_actions_reg,
		'subaction' => '([a-zA-Z\_]+)',
		'subid' => '([0-9]+)',
		'pass' => array('id', 'sub_id', 'subaction'),
	));
	
	Router::connect('/:action/:subid/:subaction/:subsubid', array(
		'plugin' => 'Dane', 
		'controller' => 'gminy', 
		'id' => '903'
	), array(
		'action' => $pk_actions_reg,
		'subaction' => '([a-zA-Z\_]+)',
		'subid' => '([0-9]+)',
		'subsubid' => '([0-9]+)',
		'pass' => array('id', 'sub_id', 'subaction', 'subsubid'),
	));
	

	/*
	Router::connect( '/dane/krs_podmioty/:id', array(
		'plugin'     => 'Dane',
		'controller' => 'krs_podmioty',
		'action'     => 'view'
	) );
	Router::connect( '/dane/krs_podmioty/:id/:action', array( 'plugin' => 'Dane', 'controller' => 'krs_podmioty' ) );
	Router::connect( '/dane/krs_podmioty/:id/:action/*', array( 'plugin' => 'Dane', 'controller' => 'krs_podmioty' ) );

	Router::connect( '/dane/krs_podmioty/:id,:slug', array(
		'plugin'     => 'Dane',
		'controller' => 'krs_podmioty',
		'action'     => 'view'
	) );
	Router::connect( '/dane/krs_podmioty/:id,:slug/:action', array( 'plugin' => 'Dane', 'controller' => 'krs_podmioty' ) );
	Router::connect( '/dane/krs_podmioty/:id,:slug/:action/*', array( 'plugin' => 'Dane', 'controller' => 'krs_podmioty' ) );
	
	
	
	
	Router::connect( '/:action', array( 'plugin' => 'Dane', 'controller' => 'gminy', 'id' => 903 ) );
	Router::connect( '/:action/*', array( 'plugin' => 'Dane', 'controller' => 'gminy', 'id' => 903 ) );
	*/
	
	


} else {
	
	$parse_url = @parse_url($_SERVER['REQUEST_URI']);
	$pathinfo = @pathinfo($parse_url['path']);
	$ext = @$pathinfo['extension'];
	
	if( 
		( $ext != 'json' ) && 
		( $_SERVER['REQUEST_METHOD']=='GET' ) && 
		preg_match('/^\/dane\/gminy\/903(\,krakow|\,krakow|\,|)(.*?)$/i', $_SERVER['REQUEST_URI'], $match)
	) {
				
		$url = URL_PROTOCOL . PK_DOMAIN . $match[2];
		header('Location: ' . $url, true, 302);
		exit();
		 	
	} else {
		
		Router::connect( '/', array('plugin' => 'Start', 'controller' => 'Start', 'action' => 'view' ) );
	
	}

}

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
Router::connect( '/pages/*', array( 'controller' => 'pages', 'action' => 'display' ) );

Router::connect( '/docs/:id', array( 'controller' => 'docs', 'action' => 'view' ), array( 'id' => '[0-9]+' ) );
Router::connect( '/docs/:id/download', array(
	'controller' => 'docs',
	'action'     => 'download'
), array( 'id' => '[0-9]+' ) );
Router::connect( '/docs/:doc_id-:package_id', array(
	'controller' => 'docs',
	'action'     => 'viewPackage'
), array( 'doc_id' => '[0-9]+', 'package_id' => '[0-9]+' ) );

Router::connect( '/oportalu', array( 'controller' => 'pages', 'action' => 'display', 'about_us' ) );
Router::connect( '/regulamin', array( 'controller' => 'pages', 'action' => 'display', 'regulations' ) );
Router::connect( '/zglosblad', array( 'controller' => 'pages', 'action' => 'display', 'report_bug' ) );
Router::connect( '/kontakt', array( 'controller' => 'pages', 'action' => 'display', 'contact_us' ) );

Router::parseExtensions( 'rss', 'xml', 'json', 'html' );
Router::connect( '/sitemap', array( 'controller' => 'sitemaps', 'action' => 'index' ) );
Router::connect( '/sitemaps/:dataset-:page', array( 'controller' => 'sitemaps', 'action' => 'dataset' ) );




if(
	( $host != PK_DOMAIN ) && 
	(
		(preg_match('/^\/([a-zA-Z0-9\-\_]+)([\.json]*)$/i', $_SERVER['REQUEST_URI'], $match)) || 
		(preg_match('/^\/([a-zA-Z0-9\-\_]+)\/(.*?)([\.json]*)$/i', $_SERVER['REQUEST_URI'], $match)) 
	) && 
	!in_array($match[1], array('krs', 'ngo', 'podatki', 'mapa', 'prawo', 'bdl', 'kto_tu_rzadzi', 'media', 'srodowisko', 'dostep_do_informacji_publicznej', 'finanse', 'handel_zagraniczny', 'zamowienia_publiczne', 'handel_zagraniczny', 'api', 'dane', 'paszport', 'pisma', 'orzecznictwo', 'sejmometr', 'pomoc', 'powiadomienia', 'wydatki_poslow', 'wyjazdy_poslow', 'moje-pisma', 'moje-kolekcje', 'moje-powiadomienia', 'oportalu', 'regulamin', 'konto', 'login', 'logout', 'admin', 'kultura'))
) {
		
	App::uses('ConnectionManager', 'Model');
	$api = ConnectionManager::getDataSource('mpAPI');
	$object_slug = $api->request('dane/objectFromSlug/' . $match[1]);
	
	if( 
		$object_slug && 
		@$object_slug['dataset'] && 
		@$object_slug['object_id']
	) {
			
	
		$pass = array('controller', 'id');			
		
		Router::connect('/' . $match[1], array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	        'action' => 'post',
	        '[method]' => 'POST'
	    ), array(
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1], array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	        'action' => 'view',
	    ), array(
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/dzialania/nowe', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	        'action' => 'dzialania_nowe',
	    ), array(
	        'pass' => $pass,
	    ));
				
	    Router::connect('/' . $match[1] . '/:action', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/:action/:subid', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'subid' => '([a-zA-Z0-9]+)',
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/:action/:subid,', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'subid' => '([0-9]+)',
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/:action/:subid,:subslug', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'subid' => '([0-9]+)',
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/:action/:subid/:subaction', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'subaction' => '([a-zA-Z\_]+)',
	        'subid' => '([0-9]+)',
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/:action/:subid/:subaction/:subsubid', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'subaction' => '([a-zA-Z\_]+)',
	        'subid' => '([0-9]+)',
	        'subsubid' => '([0-9]+)',
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/:action/:subid/:subaction/:subsubid,', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'subaction' => '([a-zA-Z\_]+)',
	        'subid' => '([0-9]+)',
	        'subsubid' => '([0-9]+)',
	        'pass' => $pass,
	    ));
	
	    Router::connect('/' . $match[1] . '/:action/:subid/:subaction/:subsubid,:subsubslug', array(
	        'plugin' => 'Dane',
	        'controller' => $object_slug['dataset'],
			'id' => $object_slug['object_id'],
			'from_slug' => true,
	    ), array(
	        'action' => '([a-zA-Z\_]+)',
	        'subaction' => '([a-zA-Z\_]+)',
	        'subid' => '([0-9]+)',
	        'subsubid' => '([0-9]+)',
	        'pass' => $pass,
	    ));

		
	
	}
	
}


/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
