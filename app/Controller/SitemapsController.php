<?php

class SitemapsController extends AppController {

	var $name = 'Sitemaps';
	var $uses = array( 'Post', 'Info' );
	var $helpers = array( 'Time' );
	var $components = array( 'RequestHandler' );

	function index() {

		$limit = 10000;

		$sitemapindex = array(
			'xmlns:'  => 'http://www.sitemaps.org/schemas/sitemap/0.9',
			'sitemap' => array(
				array(
					'loc'     => 'http://' . PORTAL_DOMAIN . '/sitemaps/general.xml',
					'lastmod' => atomTime(),
				),
			),
		);

		$this->layout = 'sitemap';

		$api      = mpapiComponent::getApi()->Dane();
		$datasets = $api->getDatasets();

		foreach ( $datasets['datasets'] as $item ) {

			$dataset = $item['Dataset'];
			$count   = $dataset['count'];
			$pages   = ceil( $count / $limit );

			for ( $p = 1; $p < $pages + 1; $p ++ ) {
				$sitemapindex['sitemap'][] = array(
					'loc'     => 'http://' . PORTAL_DOMAIN . '/sitemaps/' . $dataset['base_alias'] . '-' . $p . '.xml',
					'lastmod' => atomTime(),
				);
			}

		}

		// $this->view = 'sitemap';
		$this->set( 'data', $sitemapindex['sitemap'] );
		Configure::write( 'debug', 0 );

	}

	function dataset() {

		$dataset = $this->request->params['dataset'];
		$page    = $this->request->params['page'];

		$api = mpapiComponent::getApi()->Dane();
		$map = $api->getDatasetMap( $dataset, $page );		

		$urlset = array(
			'xmlns:' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
			'url'    => array(),
		);

		foreach ( $map as $item ) {
			
			$loc = 'http://' . PORTAL_DOMAIN . '/dane/' . $dataset . '/' . $item['id'];
			if( $item['slug'] )
				$loc .= ',' . $item['slug'];
			
			$urlset['url'][] = array(
				'loc'        => $loc,
				'changefreq' => 'daily',
				'priority'   => $item['weight'],
			);
			
		}

		$this->set( 'data', $urlset['url'] );
		Configure::write( 'debug', 0 );

	}

	function general() {


		$urlset = array(
			'xmlns:' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
			'url'    => array(),
		);

		foreach ( $this->Applications as $item ) {
			$urlset['url'][] = array(
				'loc'        => 'http://' . PORTAL_DOMAIN . '/' . $item['Application']['plugin'],
				'changefreq' => 'daily',
				'priority'   => 0.8,
			);
		}

		$this->set( 'data', $urlset['url'] );
		Configure::write( 'debug', 0 );

	}

}