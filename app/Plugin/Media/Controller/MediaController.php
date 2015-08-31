<?php

App::uses('ApplicationsController', 'Controller');

class MediaController extends ApplicationsController
{
    public $settings = array(
        'id' => 'media',
        'title' => 'Media - Polityka w mediach społecznościowych',
        'subtitle' => 'Polityka w mediach społecznościowych',
        'headerImg' => 'media',
    );
    public $mainMenuLabel = 'Analiza';

    public static $twitterAccountTypes = array(
        '0' => 'Wszystkie obserwowane',
        '2' => 'Komentatorzy',
        '3' => 'Urzędy',
        '6' => 'Media',
        '7' => 'Politycy',
        '8' => 'Partie',
        '9' => 'NGO'
    );

    public static $twitterTimeranges = array(
        '1D' => 'Ostatnia doba',
        '1W' => 'Tydzień',
        '1M' => 'Miesiąc',
        '1Y' => 'Rok',
    );

    private $twitterAccountType = '0';
    private $twitterTimerange = '1D';

    public static $dateUnitsMapES = array(
        'D' => 'd',
        'W' => 'w',
        'Y' => 'y',
    );

    public static $dateUnitsMapPHP = array(
        'D' => 'day',
        'W' => 'week',
        'M' => 'month',
        'Y' => 'year',
    );

    public static $histogramMarginsMap = array(
        'D' => 26,
        'W' => 13,
        'M' => 5,
        'Y' => 3,
    );


    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/media/img/social/media.jpg');
    }

    public static function getDropdownRanges() {
        $ranges = array(
            array(
                'title' => 'Raporty miesięczne',
                'ranges' => array()
            ),
            array(
                'title' => 'Raporty roczne',
                'ranges' => array()
            )
        );

        $months = __months();
        list($y, $n) = explode(' ', date('Y n'));

        for($m = 2; $m <= 4; $m++) {
            $data = explode(' ', date('Y m n', mktime(0, 0, 0, $n- $m, 1, $y)));
            $ranges[0]['ranges'][] = array(
                'param' => $data[0] . '-' . $data[1],
                'label' => $months[$data[2]-1] . ' ' . $data[0]
            );
        }

        for($m = 0; $m < 3; $m++) {
            $year = ($y - $m);
            $ranges[1]['ranges'][] = array(
                'param' => $year,
                'label' => $year
            );
        }

        return $ranges;
    }

    public static function getLastMonthReport() {
        list($y, $n) = explode(' ', date('Y n'));
        $n--;

        $data = explode(' ', date('Y m n', mktime(0, 0, 0, $n, 1, $y)));
        $months = __months();
        return array(
            'param' => $data[0] . '-' . $data[1],
            'label' => $months[$data[2]-1] . ' ' . $data[0],
        );
    }

    public static function getTimerange($twitterTimerange) {
        if( preg_match('/^([0-9]+)(D|W|M|Y)$/', $twitterTimerange, $match) ) {

            $ts = time();
            $value = (int) $match[1];

            $unit = array_key_exists($match[2], self::$dateUnitsMapES) ?
                self::$dateUnitsMapES[ $match[2] ] :
                $match[2];

            $timerange = array(
                'target_filter' => array(
                    'gte' => 'now-' . $value . $unit,
                ),
                'histogram_filter' => array(
                    'gte' => 'now-' . (self::$histogramMarginsMap[$match[2]] * $value) . $unit,
                ),
                'range' => array(
                    'min' => strtotime('-' . $value . self::$dateUnitsMapPHP[ $match[2] ]),
                    'max' => $ts,
                ),
                'labels' => array(
                    'min' =>  date('Y-m-d H:i', strtotime('-' . $value . self::$dateUnitsMapPHP[ $match[2] ])),
                    'max' =>  date('Y-m-d H:i', $ts),
                ),
                'xmax' => $ts * 1000,
            );

        } elseif( preg_match('/^([0-9]{4})\-([0-9]{2})$/', $twitterTimerange, $match) ) {

            $month = (int) $match[2];
            $min = mktime(0, 0, 0, $month, 1, $match[1]);
            $max = mktime(0, 0, 0, $month+1, 0, $match[1]);

            $timerange = array(
                'target_filter' => array(
                    'gte' => date('Y-m-d', $min),
                    'lte' => date('Y-m-d', $max),
                ),
                'histogram_filter' => array(
                    'gte' => date('Y-m-d', mktime(0, 0, 0, $month, -49, $match[1])),
                    'lte' => date('Y-m-d', mktime(0, 0, 0, $month+1, 50, $match[1])),
                ),
                'range' => array(
                    'min' => $min,
                    'max' => $max,
                ),
                'labels' => array(
                    'min' => date('Y-m-d', $min),
                    'max' => date('Y-m-d', $max),
                ),
            );

        } elseif(preg_match('/^([0-9]{4})$/', $twitterTimerange, $match)) {

            $year = (int) $match[0];
            $min = mktime(0, 0, 0, 1, 1, $year);
            $max = mktime(0, 0, 0, 12, 31, $year);

            $timerange = array(
                'target_filter' => array(
                    'gte' => date('Y-m-d', $min),
                    'lte' => date('Y-m-d', $max),
                ),
                'histogram_filter' => array(
                    'gte' => date('Y-m-d', mktime(0, 0, 0, 1, -49, $year)),
                    'lte' => date('Y-m-d', mktime(0, 0, 0, 12, 50, $year)),
                ),
                'range' => array(
                    'min' => $min,
                    'max' => $max,
                ),
                'labels' => array(
                    'min' => date('Y-m-d', $min),
                    'max' => date('Y-m-d', $max),
                ),
            );
        }

        return isset($timerange) ? $timerange : false;
    }

    public function view()
    {
		$this->set('last_month_report', self::getLastMonthReport());
        $this->set('dropdownRanges', self::getDropdownRanges());

		$timerange = false;
		$init = false;

        if(isset($this->request->query['t']))
            $this->set('t', $this->request->query['t']);

		if( !isset($this->request->query['t']) ) {
			$this->request->query['t'] = '1D';
			$init = true;
		}

		$date_histogram = array(
            'field' => 'date',
            'interval' => 'day',
            'format' => 'yyyy-MM-dd',
        );

		if( $this->twitterTimerange = $this->request->query['t'] ) {
            $timerange = self::getTimerange($this->twitterTimerange);
            if(!$timerange)
                $this->redirect('/media');
		}

		$timerange['init'] = $init;

		$selectedAccountsFilter = array(
			'term' => array(
				'data.twitter.konto_obserwowane' => '1',
			),
		);

        if(
        	isset($this->request->query['a']) &&
        	array_key_exists($this->request->query['a'], self::$twitterAccountTypes) &&
            $this->twitterAccountType = $this->request->query['a']
        )
        	$selectedAccountsFilter['term'] = array(
	        	'data.twitter.twitter_account_type_id' => $this->twitterAccountType,
        	);



        $this->set('twitterAccountTypes', self::$twitterAccountTypes);
        $this->set('twitterAccountType', $this->twitterAccountType);

        $this->set('twitterTimeranges', self::$twitterTimeranges);
        $this->set('twitterTimerange', $this->twitterTimerange);

		$this->set('timerange', $timerange);

        $datasets = $this->getDatasets('media');
        $selectedAccountsAggs = array(
	        'top' => array(
	            'top_hits' => array(
	                'sort' => array(
		                'data.twitter.liczba_zaangazowan' => array(
			                'order' => 'desc',
		                ),
	                ),
	                'size' => 7,
	                'fielddata_fields' => array('dataset', 'id', 'date'),
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
	                'size' => 3,
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
	    );

        $options = array(
            'searchTitle' => 'Szukaj w tweetach i kontach Twitter...',
            'conditions' => array(
                'dataset' => array_keys($datasets),
            ),
            'cover' => array(
                'force' => true,
                'view' => array(
                    'plugin' => 'Media',
                    'element' => 'cover',
                ),
                'aggs' => array(
	                'dataset' => array(
	                    'terms' => array(
	                        'field' => 'dataset',
	                    ),
	                    'visual' => array(
	                        'skin' => 'datasets',
	                        'class' => 'special',
	                        'field' => 'dataset',
	                        'dictionary' => $datasets,
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
						                'date' => $timerange['histogram_filter'],
					                ),
						        ),
						        'aggs' => array(
							        'selected_accounts' => array(
								        'filter' => $selectedAccountsFilter,
								        'aggs' => array(
									        'histogram' => array(
								                'date_histogram' => $date_histogram,
							                ),
								        ),
							        ),
							        'target_timerange' => array(
								        'filter' => array(
									        'range' => array(
								                'date' => $timerange['target_filter'],
							                ),
								        ),
								        'aggs' => array(
									        'accounts' => array(
										        'filter' => $selectedAccountsFilter,
										        'aggs' => $selectedAccountsAggs,
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
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
            'apps' => true,
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

    public function propozycje_kont()
    {

	    $accounts = $this->Media->getAccountsPropositions();

		$keys = array_slice($accounts['keys'], 0, 20);
		// $keys = $accounts['keys'];

        $options = array(
            'searchTitle' => 'Szukaj w tweetach i kontach Twitter...',
            'conditions' => array(
                'dataset' => 'twitter',
                // 'twitter.twitter_user_id' => $accounts['keys'],
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Media',
                    'element' => 'propozycje_kont',
                ),
                'aggs' => array(
	                /*
	                'accounts' => array(
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'term' => array(
							                'dataset' => 'twitter_accounts',
						                ),
					                ),
					                array(
						                'term' => array(
							                'data.twitter_accounts.twitter_id' => $keys,
						                ),
					                ),
				                ),
			                ),
		                ),
		                'aggs' => array(
			                'ids' => array(
				                'top_hits' => array(
					                'size' => 100,
				                ),
			                ),
		                ),
		                'scope' => 'global',
	                ),
	                */
	                'new' => array(
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'terms' => array(
							                'data.twitter.twitter_user_id' => $keys,
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
			                'accounts' => array(
				                'terms' => array(
					                'field' => 'twitter.twitter_user_id',
					                'size' => 100,
				                ),
				                'aggs' => array(
					                'tweets' => array(
						                'top_hits' => array(
							                'sort' => array(
								                'data.twitter.liczba_zaangazowan' => array(
									                'order' => 'desc',
								                ),
							                ),
							                'size' => 3,
							                'fielddata_fields' => array('dataset', 'id', 'date'),
						                ),
						            ),
				                ),
			                ),
		                ),
	                ),

                ),
            ),
            'apps' => true,
        );

        $this->set('twitterAccountTypes', self::$twitterAccountTypes);
		$this->set('accounts', $accounts['items']);
		$this->set('time', $accounts['time']);
        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

    public function manage_account()
    {

	    if(
	    	isset( $this->request->data['id'] ) &&
	    	isset( $this->request->data['add'] )
    	) {

	    	$res = $this->Media->manage_account($this->request->data);
	    	$this->Session->setFlash( $res['msg'] );

    	}

    	return $this->redirect($this->referer());

    }

    public function media_2013()
    {
        $this->title = "Media polityczne w 2013 roku";
        //$this->loadDatasetBrowser('twitter_accounts');
    }

    public function getChapters()
    {

	    $chapters = parent::getChapters();

	    $chapters['items'][0]['label'] = 'Analiza';
	    $chapters['items'][0]['element'] = array(
		    'path' => 'Media.start_menu',
	    );
	    return $chapters;

    }
}
