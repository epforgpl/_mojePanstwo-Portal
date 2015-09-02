<?php

App::uses('DataobjectsController', 'Dane.Controller');
App::uses('MediaController', 'Media.Controller');

class TwitterAccountsController extends DataobjectsController
{

    public $components = array(
        'RequestHandler',
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
            $timerange = MediaController::getTimerange($this->twitterTimerange);
            if(!$timerange)
                $this->redirect('/dane/twitter_accounts/' . $this->object->getId());
        }

        $this->set('last_month_report', MediaController::getLastMonthReport());
        $this->set('dropdownRanges', MediaController::getDropdownRanges());

        $this->set('twitterAccountTypes', MediaController::$twitterAccountTypes);
        $this->set('twitterAccountType', $this->twitterAccountType);

        $this->set('twitterTimeranges', MediaController::$twitterTimeranges);
        $this->set('twitterTimerange', $this->twitterTimerange);

        $this->set('timerange', $timerange);


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
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    'term' => array(
                                        'data.twitter.twitter_account_id' => $this->object->getId(),
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
                                        'filter' => array(
                                            'term' => array(
                                                'data.twitter.twitter_account_id' => $this->object->getId(),
                                            ),
                                        ),
                                        'aggs' => array(
                                            'histogram' => array(
                                                'date_histogram' => array(
                                                    'field' => 'date',
                                                    'interval' => 'day',
                                                    'format' => 'yyyy-MM-dd',
                                                ),
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
                                            'mentions_by_account' => array(
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
                                                                    'image_url' => array(
                                                                        'terms' => array(
                                                                            'field' => 'data.twitter_accounts.profile_image_url_https',
                                                                            'size' => 1,
                                                                        ),
                                                                    ),
                                                                )
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'accounts_by_mentions' => array(
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
                        ),
                    ),
                ),
            ),
        ));
        $this->render('Dane.DataBrowser/browser');

    }

    public function tweety() {
        $this->_prepareView();
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
                    'label' => 'Analiza',
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
