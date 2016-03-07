<?php

App::uses('DataobjectsController', 'Dane.Controller');
App::uses('MediaController', 'Media.Controller');

/**
 * @property TwitterComponent Twitter
 */
class TwitterAccountsController extends DataobjectsController
{

    public $components = array(
        'RequestHandler', 'Media.Twitter'
    );

    public $uses = array('Dane.Dataobject');

    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(),
    );

    private $twitterAccountType = '0';
    private $twitterTimerange = '1W';

    public function view()
    {
        $timerange = false;
        $init = false;

        if( !isset($this->request->query['t']) ) {
            $this->request->query['t'] = $this->twitterTimerange;
            $init = true;
        }

        $this->addInitLayers(array('powiazania'));
        $this->load();

        if(
	        ( $page = $this->object->getLayer('page') ) &&
	        ( $page['logo'] )
        ) {

        } else {

	        $this->object->layers['page'] = array(
		        'cover' => false,
		        'logo' => str_replace('_normal', '', $this->object->getData('profile_image_url_https')),
	        );

        }

        if( $this->twitterTimerange = $this->request->query['t'] ) {
            $timerange = $this->Twitter->getTimerange($this->twitterTimerange);
            if(!$timerange)
                $this->redirect('/dane/twitter_accounts/' . $this->object->getId());
        }

        $this->set('last_month_report', $this->Twitter->getLastMonthReport());
        $this->set('dropdownRanges', $this->Twitter->getDropdownRanges());

        $this->set('twitterAccountTypes', $this->Twitter->twitterAccountTypes);
        $this->set('twitterAccountType', $this->twitterAccountType);

        $this->set('twitterTimeranges', $this->Twitter->twitterTimeranges);
        $this->set('twitterTimerange', $this->twitterTimerange);

        $this->set('timerange', $timerange);

		$selectedAccountsFilter = array(
			'term' => array(
				'data.twitter.twitter_account_id' => $this->object->getId(),
			),
		);

		$date_histogram = array(
            'field' => 'date',
            'interval' => 'day',
            'format' => 'yyyy-MM-dd',
        );

        $selectedAccountsAggs = array(
	        /*
	        'deleted' => array(
		        'filter' => array(
			        'term' => array(
				        'data.twitter.usuniety' => '1',
			        ),
		        ),
		        'aggs' => array(
			        'top' => array(
				        'top_hits' => array(
					        'size' => 1,
				        ),
			        ),
		        ),
	        ),
	        */
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
	        /*
	        'retweets' => array(
		        'filter' => array(
			        'term' => array(
				        'data.twitter.retweet' => '1',
			        ),
		        ),
		        'aggs' => array(
			        'accounts' => array(
				        'terms' => array(
					        'field' => 'data.twitter.twitter_user_id',
					        'size' => 10,
				        ),
				        'aggs' => array(
					        'name' => array(
						        'terms' => array(
							        'field' => 'data.twitter.twitter_user_name',
							        'size' => 1,
						        ),
					        ),
				        ),
				        'aggs' => array(
					        'photo' => array(
						        'terms' => array(
							        'field' => 'data.twitter.twitter_user_avatar_url',
							        'size' => 1,
						        ),
					        ),
				        ),
			        ),
		        ),
	        ),
	        */
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
	        'mentions' => array(
		        'nested' => array(
	                'path' => 'twitter-mentions',

	            ),
	            'aggs' => array(
	                'accounts' => array(
		                'terms' => array(
			                'field' => 'twitter-mentions.screen_name',
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

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'twitter',
                'twitter.twitter_account_id' => $this->object->getId(),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'twitter_accounts/cover',
                ),
                'aggs' => array(
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
											        'account' => array(
												        'filter' => array(
													        'term' => array(
														        'twitter-mentions.account_id' => $this->object->getId(),
													        ),
												        ),
												        'aggs' => array(
											                'accounts' => array(
												                'reverse_nested' => '_empty',
												                'aggs' => array(
													                'ids' => array(
														                'terms' => array(
															                'field' => 'data.twitter.twitter_user_screenname',
															                'exclude' => array(
																                'pattern' => '',
															                ),
															                'size' => 10,
														                ),
														                'aggs' => array(
															                'name' => array(
																                'terms' => array(
																	                'field' => 'data.twitter.twitter_user_name',
																	                'size' => 1,
																                ),
															                ),
															                'photo' => array(
																                'terms' => array(
																	                'field' => 'data.twitter.twitter_user_avatar_url',
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
						        ),
					        ),
		                ),
	                ),
                ),
            ),
        ));
        $this->render('Dane.DataBrowser/browser');

    }

    public function tweety() {

        $this->_prepareView();

        if(
	        ( $page = $this->object->getLayer('page') ) &&
	        ( $page['logo'] )
        ) {

        } else {

	        $this->object->layers['page'] = array(
		        'cover' => false,
		        'logo' => str_replace('_normal', '', $this->object->getData('profile_image_url_https')),
	        );

        }

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'twitter',
                'twitter.twitter_account_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', $this->object->getTitle());
    }

    public function getMenu()
    {
	    	    
        return array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Analiza konta',
                ),
                array(
                    'id' => 'tweety',
                    'label' => 'Tweety',
                ),
            ),
            'base' => $this->object->getUrl(),
        );
    }

}
