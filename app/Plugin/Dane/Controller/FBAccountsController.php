<?php

App::uses('DataobjectsController', 'Dane.Controller');
App::uses('MediaController', 'Media.Controller');

/**
 * @property TwitterComponent Twitter
 */
class FbAccountsController extends DataobjectsController
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

        $this->load();

        if(
	        ( $page = $this->object->getLayer('page') ) &&
	        ( $page['logo'] )
        ) {

        } else {

	        $this->object->layers['page'] = array(
		        'cover' => false,
		        'logo' => str_replace('_normal', '', $this->object->getData('picture')),
	        );

        }

        if( $this->twitterTimerange = $this->request->query['t'] ) {
            $timerange = $this->Twitter->getTimerange($this->twitterTimerange);
            if(!$timerange)
                $this->redirect('/dane/fb_accounts/' . $this->object->getId());
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
				'data.fb_posts.fb_account_id' => $this->object->getData('src_id'),
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
		                'data.fb_posts.engagement' => array(
			                'order' => 'desc',
		                ),
	                ),
	                'size' => 7,
	                'fielddata_fields' => array('dataset', 'id', 'date'),
	            ),
	        ),
	    );

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'fb_posts',
                'fb_posts.fb_account_id' => $this->object->getData('src_id'),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'fb_accounts/cover',
                ),
                'aggs' => array(
                    'tweets' => array(
		                'scope' => 'global',
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'term' => array(
							                'dataset' => 'fb_posts',
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
    
    public function usuniete() {

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
                'twitter.usuniety' => '1',
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
                array(
                    'id' => 'usuniete',
                    'label' => 'Usunięte tweety',
                ),
            ),
            'base' => $this->object->getUrl(),
        );
    }

}
