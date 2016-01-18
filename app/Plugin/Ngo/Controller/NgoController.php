<?php

App::uses('ApplicationsController', 'Controller');

class NgoController extends ApplicationsController
{

    public $settings = array(
        'id' => 'ngo',
        'title' => 'NGO',
        'shortTitle' => 'NGO',
        'subtitle' => 'Organizacje pozarządowe w Polsce',
        'headerImg' => 'ngo',
    );
    
    public $menu = array(
		'dzialania' => array(
			'menu_id' => 'dzialania',
			'label' => 'Działania',
			'icon' => 'dzialania',
		),
		'pisma' => array(
			'menu_id' => 'pisma',
			'label' => 'Pisma',
			'icon' => 'pisma',
		),
		/*
		'zbiorki_publiczne' => array(
			'menu_id' => 'zbiorki',
			'label' => 'Zbiórki publiczne',
			'separator' => 'bottom',
		),
		*/
		'krs_podmioty' => array(
			'label' => 'Organizacje:',
			'class' => '__label border-top',
			'icon' => 'krs_podmioty',
			'forma_prawna_id' => '_all',
		),
		'fundacje' => array(
			'menu_id' => 'fundacje',
			'label' => 'Fundacje',
			'forma_prawna_id' => '1',
			'icon' => 'dot',
		),
		'stowarzyszenia' => array(
			'menu_id' => 'stowarzyszenia',
			'label' => 'Stowarzyszenia',
			'forma_prawna_id' => '15',
			'icon' => 'dot',
		),
		'zwiazki_zawodowe' => array(
			'menu_id' => 'zwiazki_zawodowe',
			'label' => 'Związki zawodowe',
			'forma_prawna_id' => '18',
			'icon' => 'dot',
		),
		'spoldzielnie' => array(
			'menu_id' => 'spoldzielnie',
			'label' => 'Spółdzielnie',
			'forma_prawna_id' => '9',
			'icon' => 'dot',
		),
		'pozostale_ngo' => array(
			'menu_id' => 'pozostale',
			'label' => 'Pozostałe organizacje',
			'forma_prawna_id' => '_other',
			'icon' => 'dot',
		),
	);
    
    public $_aggs = array(
        'dataset' => array(
            'terms' => array(
                'field' => 'dataset',
            ),
            'aggs' => array(
                'forma_prawna' => array(
                    'terms' => array(
	                    'field' => 'data.krs_podmioty.forma_prawna_id',
	                    'size' => 100,
                    ),
                ),
            ),
        ),
    );
        
    private function getSubAggs() {
	    return array(
	        '_query' => array(
	            'filter' => array(
		            'or' => array(
			            array(
				            'terms' => array(
					            'dataset' => array('dzialania', 'pisma'),
				            ),
			            ),
			            array(
				            'bool' => array(
					            'must' => array(
						            array(
							            'term' => array(
								            'dataset' => 'krs_podmioty',
							            ),
						            ),
						            array(
							            'term' => array(
								            'data.krs_podmioty.forma_prawna_typ_id' => '2',
							            ),
						            ),
					            ),
				            ),
			            ),
		            ),
	            ),
	            'scope' => 'query',
	            'aggs' => $this->_aggs,
	        ),
	    );
    }

    public $components = array('RequestHandler');

    public $submenus = array(
        'ngo' => array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Start',
                ),
                array(
                    'id' => 'dzialania',
                    'label' => 'Działania',
                ),
                array(
                    'id' => 'fundacje',
                    'label' => 'Fundacje',
                ),
                array(
                    'id' => 'stowarzyszenia',
                    'label' => 'Stowarzyszenia',
                ),
            )
        )
    );

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function addDeclaration()
    {

        $status = $this->Ngo->addDeclaration($this->request->data);
        if ($status) {
            $this->Session->setFlash('Twoje zgłoszenie zostało zapisane. Skontaktujemy się z Tobą w najbliższym czasie', null, array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash('Wystąpił problem z wysyłaniem zgłoszenia', null, array('class' => 'alert-error'));
        }

        return $this->redirect('/ngo');

    }

    public function map()
    {

        if (
        isset($this->request->query['area'])
        ) {

            list($tl, $br) = explode(',', $this->request->query['area']);

            $strlen = strlen($tl);

            if( $strlen==10 )
            	$strlen = 9;

            if( $strlen==12 )
            	$strlen = 11;

            if( $strlen==14 )
            	$strlen = 13;

            if( $strlen==16 )
            	$strlen = 15;


            $precision = floor($strlen / 2);

            $options = array(
                'cover' => array(
                    'force' => true,
                    'aggs' => array(
                        'map' => array(
                            'scope' => 'global',
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
                                                'data.krs_podmioty.forma_prawna_typ_id' => '2',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.krs_podmioty.wykreslony' => '0',
                                            ),
                                        ),
                                        array(
                                            'geo_bounding_box' => array(
                                                'position' => array(
                                                    'top_left' => $tl,
                                                    'bottom_right' => $br,
                                                ),
                                            ),
                                        ),
                                    ),
                                    '_cache' => true,
                                ),
                            ),
                            'aggs' => array(
                                'grid' => array(
                                    'geohash_grid' => array(
                                        'field' => 'position',
                                        'precision' => $precision,
                                    ),
                                    'aggs' => array(
                                        'inner_grid' => array(
                                            'geohash_grid' => array(
                                                'field' => 'position',
                                                'precision' => $precision + 1,
                                                'size' => 1,
                                            ),
                                        ),
                                        'top' => array(
	                                        'top_hits' => array(
		                                        'size' => 1,
		                                        'fielddata_fields' => array('position.lat', 'position.lon'),
		                                        '_source' => false,
		                                        'fields' => array(),
	                                        ),
                                        ),
                                        /*
                                        'lat' => array(
                                            'terms' => array(
                                                'field' => 'position.lat',
                                                'size' => 1,
                                            ),
                                        ),
                                        'lng' => array(
                                            'terms' => array(
                                                'field' => 'position.lon',
                                                'size' => 1,
                                            ),
                                        ),
                                        'id' => array(
                                            'terms' => array(
                                                'field' => '_id',
                                                'size' => 1,
                                            ),
                                        ),
                                        */
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            );

            $this->Components->load('Dane.DataBrowser', $options);
            $this->set('_serialize', 'dataBrowser');


        } else {

            throw new BadRequestException('Required parameters missing');

        }

    }

    public function beforeRender()
    {

        parent::beforeRender();
       
        // debug( $this->viewVars['dataBrowser']['aggs'] ); die();

        if ($this->request->params['action'] == 'map') {

            $data = $this->viewVars['dataBrowser']['aggs']['map'];
            foreach ($data['grid']['buckets'] as &$b) {

                if ($b['doc_count'] === 1) {

                    $b['data'] = $b['top']['hits']['hits'][0]['fields']['source'][0]['data'];
					$b['location'] = array(
						'lat' => $b['top']['hits']['hits'][0]['fields']['position.lat'][0],
						'lon' => $b['top']['hits']['hits'][0]['fields']['position.lon'][0],
					);

                    unset($b['top']);

                } else {

                    unset($b['top']);

                }

                $b['inner_key'] = $b['inner_grid']['buckets'][0]['key'];
                unset($b['inner_grid']);

            }

            $this->viewVars['dataBrowser'] = $data;

        }

    }
	
    public function view()
    {

        $options = array(
            'searchTag' => array(
	            'href' => '/ngo',
	            'label' => 'NGO',
            ),
            'autocompletion' => array(
                'dataset' => 'ngo',
            ),
            'conditions' => array(
	            'dataset' => array(
		            'dzialania', 
		            'pisma', 
		            'krs_podmioty{krs_podmioty.forma_prawna_typ_id:2}',
	            ),	            
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Ngo',
                    'element' => 'cover',
                ),
                'aggs' => array(
				    'dzialania' => array(
				        'scope' => 'global',
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
				                            'data.dzialania.status' => '1',
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
				    ),
				    'pisma' => array(
				        'scope' => 'global',
				        'filter' => array(
				            'bool' => array(
				                'must' => array(
				                    array(
				                        'term' => array(
				                            'dataset' => 'pisma',
				                        ),
				                    ),
                                    array(
                                        'term' => array(
                                            'data.pisma.is_promoted' => 'true',
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
				    ),
                    'tweets' => array(
                        'scope' => 'global',
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'dataset' => 'twitter',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.twitter.retweet' => '0',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'global_timerange' => array(
                                'filter' => array(
                                    'range' => array(
                                        'date' => array(
                                            'gte' => 'now-26d'
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'selected_accounts' => array(
                                        'filter' => array(
                                            'term' => array(
                                                'data.twitter.twitter_account_type_id' => 9
                                            )
                                        ),
                                        'aggs' => array(
                                            'histogram' => array(
                                                'date_histogram' => array(
                                                    'field' => 'date',
                                                    'interval' => 'day',
                                                    'format' => 'yyyy-MM-dd'
                                                ),
                                            ),
                                        ),
                                    ),
                                    'target_timerange' => array(
                                        'filter' => array(
                                            'range' => array(
                                                'date' => array(
                                                    'gte' => 'now-1w'
                                                ),
                                            ),
                                        ),
                                        'aggs' => array(
                                            'accounts' => array(
                                                'filter' => array(
                                                    'term' => array(
                                                        'data.twitter.twitter_account_type_id' => 9
                                                    )
                                                ),
                                                'aggs' => array(
                                                    'top' => array(
                                                        'top_hits' => array(
                                                            'sort' => array(
                                                                'data.twitter.liczba_zaangazowan' => array(
                                                                    'order' => 'desc',
                                                                ),
                                                            ),
                                                            'fielddata_fields' => array('id', 'date', 'dataset'),
                                                            'size' => 7,
                                                        ),
                                                    ),
                                                    'accounts_engagement' => array(
                                                        'terms' => array(
                                                            'field' => 'data.twitter.twitter_account_id',
                                                            'order' => array(
                                                                'engagement_count' => 'desc',
                                                            ),
                                                            'size' => 10,
                                                        ),
                                                        'aggs' => array(
                                                            'name' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter_accounts.name',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'image_url' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter_accounts.profile_image_url_https',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'account_type' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter.twitter_account_type_id',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'engagement_count' => array(
                                                                'sum' => array(
                                                                    'field' => 'data.twitter.liczba_zaangazowan',
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                    'accounts_tweets' => array(
                                                        'terms' => array(
                                                            'field' => 'data.twitter.twitter_account_id',
                                                            'size' => 10,
                                                        ),
                                                        'aggs' => array(
                                                            'name' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter_accounts.name',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'image_url' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter_accounts.profile_image_url_https',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'account_type' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter.twitter_account_type_id',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                    'accounts_engagement_tweets' => array(
                                                        'terms' => array(
                                                            'field' => 'data.twitter.twitter_account_id',
                                                            'size' => 10,
                                                            'order' => array(
                                                                'engagement_count' => 'desc',
                                                            ),
                                                        ),
                                                        'aggs' => array(
                                                            'name' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter_accounts.name',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'image_url' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter_accounts.profile_image_url_https',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'account_type' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter.twitter_account_type_id',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                            'engagement_count' => array(
                                                                'avg' => array(
                                                                    'field' => 'data.twitter.liczba_zaangazowan',
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                    'tags' => array(
                                                        'nested' => array(
                                                            'path' => 'twitter-tags',

                                                        ),
                                                        'aggs' => array(
                                                            'tags' => array(
                                                                'terms' => array(
                                                                    'field' => 'twitter-tags.id',
                                                                    'size' => 20,
                                                                    'order' => array(
                                                                        'rn' => 'desc',
                                                                    ),
                                                                ),
                                                                'aggs' => array(
                                                                    'label' => array(
                                                                        'terms' => array(
                                                                            'field' => 'twitter-tags.name',
                                                                            'size' => 1,
                                                                        ),
                                                                    ),
                                                                    'rn' => array(
                                                                        'reverse_nested' => '_empty',
                                                                        'aggs' => array(
                                                                            'engagement_count' => array(
                                                                                'sum' => array(
                                                                                    'field' => 'data.twitter.liczba_zaangazowan',
                                                                                ),
                                                                            ),
                                                                        ),
                                                                    ),
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                    'sources' => array(
                                                        'terms' => array(
                                                            'field' => 'data.twitter.source_id',
                                                            'size' => 5,
                                                        ),
                                                        'aggs' => array(
                                                            'label' => array(
                                                                'terms' => array(
                                                                    'field' => 'data.twitter.source',
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'mentions' => array(
                                                'nested' => array(
                                                    'path' => 'twitter-mentions',
                                                ),
                                                'aggs' => array(
                                                    'accounts' => array(
                                                        'filter' => array(
                                                            'bool' => array(
                                                                'must_not' => array(
                                                                    'term' => array(
                                                                        'twitter-mentions.account_id' => '0',
                                                                    ),
                                                                ),
                                                            ),
                                                        ),
                                                        'aggs' => array(
                                                            'ids' => array(
                                                                'terms' => array(
                                                                    'field' => 'twitter-mentions.account_id',
                                                                    'size' => 10,
                                                                ),
                                                                'aggs' => array(
                                                                    'screen_name' => array(
                                                                        'terms' => array(
                                                                            'field' => 'twitter-mentions.screen_name',
                                                                            'size' => 1,
                                                                        ),
                                                                    ),
                                                                    'name' => array(
                                                                        'terms' => array(
                                                                            'field' => 'twitter-mentions.name',
                                                                            'size' => 1,
                                                                        ),
                                                                    ),
                                                                    'photo' => array(
                                                                        'terms' => array(
                                                                            'field' => 'twitter-mentions.account_photo_url',
                                                                            'size' => 1,
                                                                        ),
                                                                    ),
                                                                )
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
            ),
            'aggs' => $this->_aggs,
        );

        $this->set('_submenu', array_merge($this->submenus['ngo'], array(
            'selected' => '',
        )));

        $this->title = 'Organizacje pozarządowe i akcje społeczne';

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

    public function dzialania()
    {
	    $this->title = 'Działania organizacji społecznych';
        $this->loadDatasetBrowser('dzialania', array(
            'conditions' => array(
                'dataset' => 'dzialania',
                'dzialania.status' => '1',
            ),
            'aggs' => $this->getSubAggs(),
        ));
    }

    public function pisma()
    {
	    $this->title = 'Pisma | NGO';
        $this->loadDatasetBrowser('pisma', array(
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function fundacje()
    {
	    $this->title = 'Fundacje | NGO';
        $this->loadDatasetBrowser('krs_podmioty', array(
            'conditions' => array(
                'krs_podmioty.forma_prawna_id' => '1',
            ),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'fundacje',
                'base' => '/ngo'
            )),
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function zwiazki_zawodowe()
    {
	    $this->title = 'Związki zawodowe | NGO';
        $this->loadDatasetBrowser('krs_podmioty', array(
            'conditions' => array(
                'krs_podmioty.forma_prawna_id' => '18',
            ),
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function spoldzielnie()
    {
        $this->title = 'Spółdzielnie | NGO';
        $this->loadDatasetBrowser('krs_podmioty', array(
            'conditions' => array(
                'krs_podmioty.forma_prawna_id' => '9',
            ),
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function pozostale()
    {
        $this->title = 'Pozostałe organizacje | NGO';
        $this->loadDatasetBrowser('krs_podmioty', array(
            'conditions' => array(
                'krs_podmioty.forma_prawna_id' => array('2', '3', '4', '5', '8', '16', '17', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '33', '34', '35', '36', '37', '40', '41', '43', '45'),
            ),
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function zbiorki()
    {
        $this->loadDatasetBrowser('zbiorki_publiczne', array(
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'zbiorki',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Fundacje | NGO');

    }

    public function stowarzyszenia()
    {
        $this->set('_submenu', array_merge($this->submenus['ngo'], array(
            'selected' => 'stowarzyszenia',
        )));

        $this->loadDatasetBrowser('krs_podmioty', array(
            'conditions' => array(
                'krs_podmioty.forma_prawna_id' => '15',
            ),
            'aggs' => $this->getSubAggs(),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'stowarzyszenia',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Stowarzyszenia | NGO');

    }
	
	public function getChapters() {

		$mode = false;
		$items = array();
		$app = $this->getApplication( $this->settings['id'] );		
		
		if( @$this->viewVars['dataBrowser']['aggs']['_query']['dataset']['buckets'] )
			$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] = $this->viewVars['dataBrowser']['aggs']['_query']['dataset']['buckets'];
		
		if(
			isset( $this->request->query['q'] ) &&
			$this->request->query['q']
		) {
			
			$items[] = array(
				'id' => '_results',
				'label' => 'Szukaj w NGO:',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
				'tool' => array(
					'icon' => 'search',
					'href' => '/' . $this->settings['id'],
				),
				'icon' => 'appIcon',
				'appIcon' => $app['icon'],
				'class' => '_label',
			);

			if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';

		} else {
			
			$items[] = array(
				'label' => 'NGO',
				'href' => '/' . $this->settings['id'],
				'class' => '_label',
				'icon' => 'appIcon',
				'appIcon' => $app['icon'],
			);
			
		}
		
		

		
		$others_count = 0;
		
		foreach( $this->menu as $key => $value ) {
						
			if( !isset($value['menu_id']) )
				$value['menu_id'] = '';
						
			$item = array(
				'id' => $value['menu_id'],
				'label' => $value['label'],
			);
			
			if( $value['menu_id'] )
				$item['href'] = '/' . $this->settings['id'] . '/' . $value['menu_id'];
			
			if( isset($value['icon']) )
				$item['icon'] = 'icon-datasets-' . $value['icon'];
				
			if( isset($value['class']) )
				$item['class'] = $value['class'];

			if( $mode == 'results' ) {
			
				
				$datasets = array();
				
				if( isset($item['href']) )
					$item['href'] .= '?q=' . urlencode( $this->request->query['q'] );
				
				if( @$value['forma_prawna_id'] ) {
					
					if( @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] ) {
						foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {
													
							if( $dataset['key']=='krs_podmioty' ) {
								
								if( $value['forma_prawna_id']=='_all' ) {
									
									if( $dataset['doc_count'] );
										$items[] = $item;
									
								} else {
											
									foreach( $dataset['forma_prawna']['buckets'] as $forma ) {
										if( $forma['doc_count'] ) {
																				
											if( $value['forma_prawna_id']==$forma['key'] ) {
												
												$item['count'] = $forma['doc_count'];
												$items[] = $item;
													
											} elseif( ($value['forma_prawna_id']=='_other') && !in_array($forma['key'], array('1', '15', '18', '9')) ) {
												
												$others_count += $forma['doc_count'];
												
											}
																				
										}
									}
									
									if( ($value['forma_prawna_id']=='_other') && $others_count ) {
										
										$item['count'] = $others_count;
										$items[] = $item;
										
									}
								
								}
								
							}
						}
					}
					
				} else {
					
					if( @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] ) {
						foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {
							if( ($dataset['key'] == $key) && $dataset['doc_count'] ) {
									
								$item['count'] = $dataset['doc_count'];
								$items[] = $item;
								
							}
						}
					}
					
				}

			} else {

				$items[] = $item;

			}

		}
				
        foreach($items as $i => $item) {

            if(isset($item['submenu'])) {
                $items[$i]['submenu']['selected'] = $this->chapter_submenu_selected;
            }
                                
            if(
            	$i && 
            	( @strpos($item['class'], 'border-top')!==false ) && 
            	( @strpos($items[$i-1]['class'], '_label')!==false )
            )
	            $items[$i]['class'] = str_replace('border-top', '', $item['class']);

        }
        
		
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}
	
    public function page()
    {
	    
	    $options = array(
            'searchTag' => array(
	            'href' => '/ngo',
	            'label' => 'NGO',
            ),
            'autocompletion' => array(
                'dataset' => 'ngo',
            ),
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.forma_prawna_typ_id' => '2',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Ngo',
                    'element' => 'page',
                ),
                'aggs' => array(
                ),
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
                            'krs_podmioty' => 'Organizacje',
                        ),
                    ),
                ),
            ),
        );

        $this->set('_submenu', array_merge($this->submenus['ngo'], array(
            'selected' => '',
        )));

        $this->title = 'Organizacje pozarządowe i akcje społeczne';

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
	    
    }

}
