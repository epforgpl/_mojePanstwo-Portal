<?php

App::uses('ApplicationsController', 'Controller');

/**
 * @property TwitterComponent Twitter
 */
class MediaController extends ApplicationsController
{
    public $settings = array(
        'id' => 'media',
        'title' => 'Państwo w mediach społecznościowych',
        'shortTitle' => 'Media społecznościowe',
        'subtitle' => 'Polityka w mediach społecznościowych',
        'headerImg' => 'media',
    );

    public $components = array('Media.Twitter');

    public $mainMenuLabel = 'Analiza';
    private $twitterAccountType = '0';
    private $twitterTimerange = '1D';

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/media/img/social/media.jpg');
    }


    public function view()
    {
		$this->set('last_month_report', $this->Twitter->getLastMonthReport());
        $this->set('dropdownRanges', $this->Twitter->getDropdownRanges());

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
            $timerange = $this->Twitter->getTimerange($this->twitterTimerange);
            if(!$timerange)
                $this->redirect('/media');
		}

		$timerange['init'] = $init;

		$selectedAccountsFilter = array(
			'term' => array(
				'data.twitter.konto_obserwowane' => '1',
			),
		);

		$mentions_accounts_filter = array(
	        'bool' => array(
		        'must_not' => array(
			        'term' => array(
				        'twitter-mentions.account_id' => '0',
			        ),
		        ),
	        ),
        );

        if(
        	isset($this->request->query['a']) &&
        	array_key_exists($this->request->query['a'], $this->Twitter->twitterAccountTypes) &&
            $this->twitterAccountType = $this->request->query['a']
        ) {

        	$selectedAccountsFilter['term'] = array(
	        	'data.twitter.twitter_account_type_id' => $this->twitterAccountType,
        	);

        	$mentions_accounts_filter = array(
		        'bool' => array(
			        'must' => array(
				        'term' => array(
					        'twitter-mentions.account_type_id' => $this->request->query['a'],
				        ),
			        ),
		        ),
	        );

        }



        $this->set('twitterAccountTypes', $this->Twitter->twitterAccountTypes);
        $this->set('twitterAccountType', $this->twitterAccountType);

        $this->set('twitterTimeranges', $this->Twitter->twitterTimeranges);
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
	    );


        $options = array(
            'searchTag' => array(
	            'href' => '/media',
	            'label' => 'Media',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets),
            ),
            'cover' => array(
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
	                /*
	                'accounts' => array(
		                'scope' => 'global',
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'term' => array(
							                'dataset' => 'twitter_accounts',
						                ),
					                ),
					                array(
						                'nested' => array(
							                'path' => 'twitter_accounts-followers',
							                'filter' => array(
								                'term' => array(
									                'twitter_accounts-followers.date' => array(
									                	substr($timerange['labels']['min'], 0, 10),
									                	substr($timerange['labels']['max'], 0, 10),
									                ),
								                ),
							                ),
						                ),
					                ),
				                ),
			                ),
		                ),
		                'aggs' => array(
			                'accounts' => array(
				                'terms' => array(
					                'field' => 'id',
				                ),
				                'aggs' => array(
					                'name' => array(
						                'terms' => array(
							                'field' => 'twitter_accounts.name',
							                'size' => 1,
						                ),
					                ),
					                'photo' => array(
						                'terms' => array(
							                'field' => 'twitter_accounts.profile_image_url_https',
							                'size' => 1,
						                ),
					                ),
					                'counts' => array(
						                'nested' => array(
							                'path' => 'twitter_accounts-followers',
						                ),
						                'aggs' => array(
							                'dates' => array(
								                'filter' => array(
									                'term' => array(
										                'twitter_accounts-followers.date' => array(
											                substr($timerange['labels']['min'], 0, 10),
										                	substr($timerange['labels']['max'], 0, 10),
										                )
									                ),
								                ),
								                'aggs' => array(
									                'dates' => array(
										                'terms' => array(
											                'field' => 'twitter_accounts-followers.date',
											                'size' => 2,
										                ),
										                'aggs' => array(
											                'count' => array(
												                'terms' => array(
													                'field' => 'twitter_accounts-followers.count',
													                'size' => 1,
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
	                */
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
												        'filter' => $mentions_accounts_filter,
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
							                'fielddata_fields' => array('dataset', 'id', 'date'),
							                'size' => 3,
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

        $this->set('twitterAccountTypes', $this->Twitter->twitterAccountTypes);
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

	    if( $this->isSuperUser() )
		    $chapters['items'][] = array(
			    'id' => 'propozycje_kont',
			    'href' => 'propozycje_kont',
			    'label' => 'Propozycje nowych kont',
		    );

	    return $chapters;

    }
}
