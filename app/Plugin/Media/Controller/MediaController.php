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

    private $twitterAccountTypes = array(
        '0' => 'Wszystkie obserwowane',
        '2' => 'Komentatorzy',
        '3' => 'Urzędy',
        '7' => 'Politycy',
        '8' => 'Partie',
        '9' => 'NGO'
    );

    private $twitterAccountType = '0';

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/media/img/social/media.jpg');
    }

    public function view()
    {


        $datasets = $this->getDatasets('media');

		$must_whitout_account_type_id = $must = array(
            array(
                'term' => array(
	                'dataset' => 'twitter',
                ),
            ),
            array(
                'term' => array(
	                'data.twitter.konto_obserwowane' => '1',
                ),
            ),
            array(
                'term' => array(
	                'data.twitter.retweet' => '0',
                ),
            ),
        );
        
        if(
        	isset($this->request->query['type']) &&
        	array_key_exists($this->request->query['type'], $this->twitterAccountTypes) &&
            $this->twitterAccountType = $this->request->query['type']
        )
        	$must[] = array(
	        	'term' => array(
	                'data.twitter.twitter_account_type_id' => $this->twitterAccountType,
                ),
        	);
        	
        $must_whitout_account_type_id[] = array(
			'range' => array(
			    'date' => array(
			        'gte' => 'now-1d',
			    ),
			),
        );

        $this->set('twitterAccountTypes', $this->twitterAccountTypes);
        $this->set('twitterAccountType', $this->twitterAccountType);

        $options = array(
            'searchTitle' => 'Szukaj w tweetach i kontach Twitter...',
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
	                'tweets_whitout_account_type_id' => array(
		                'filter' => array(
			                'bool' => array(
				                'must' => $must_whitout_account_type_id,
			                ),
		                ),
		                'aggs' => array(
			                'types' => array(
				                'terms' => array(
					                'field' => 'data.twitter.twitter_account_type_id',
				                ),
				                'aggs' => array(
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
				                ),
			                ),
		                ),
	                ),
	                'tweets' => array(
		                'filter' => array(
			                'bool' => array(
				                'must' => $must,
			                ),
		                ),
		                'aggs' => array(
			                'timerange' => array(
				                'filter' => array(
					                'range' => array(
						                'date' => array(
							                'gte' => 'now-1d',
						                ),
					                ),
				                ),
				                'aggs' => array(
					                'types' => array(
						                'terms' => array(
							                'field' => 'data.twitter.twitter_account_type_id',
							                'exclude' => array(
								                'pattern' => '0'
							                ),
						                ),
						                
					                ),
					                'top' => array(
						                'top_hits' => array(
							                'sort' => array(
								                'data.twitter.liczba_zaangazowan' => array(
									                'order' => 'desc',
								                ),
							                ),
							                'size' => 5,
							                'fielddata_fields' => array('dataset', 'id'),
						                ),
					                ),
					                'accounts' => array(
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
					                'tags' => array(
						                'nested' => array(
							                'path' => 'twitter-tags',
							                
						                ),
						                'aggs' => array(
							                'tags' => array(
								                'terms' => array(
									                'field' => 'twitter-tags.id',
									                'size' => 20,
								                ),
								                'aggs' => array(
									                'label' => array(
										                'terms' => array(
											                'field' => 'twitter-tags.name',
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

    public function media_2013()
    {
        $this->title = "Media polityczne w 2013 roku";
        //$this->loadDatasetBrowser('twitter_accounts');
    }
}
