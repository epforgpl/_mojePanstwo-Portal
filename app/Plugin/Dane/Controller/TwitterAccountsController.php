<?php

App::uses('DataobjectsController', 'Dane.Controller');

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

    private $twitterAccountTypes = array(
        '0' => 'Wszystkie obserwowane',
        '2' => 'Komentatorzy',
        '3' => 'Urzędy',
        '7' => 'Politycy',
        '8' => 'Partie',
        '9' => 'NGO'
    );

    public function view()
    {

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

        $this->set('twitterAccountTypes', $this->twitterAccountTypes);

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
                    'tweets_whitout_account_type_id' => array(
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
                                            'data.twitter.konto_obserwowane' => '1',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.twitter.retweet' => '0',
                                        ),
                                    ),
                                    array(
                                        'term' => array(
                                            'data.twitter.twitter_account_id' => $this->object->getId(),
                                        ),
                                    )
                                ),
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
                                'must' => array(
                                    'term' => array(
                                        'data.twitter.twitter_account_id' => $this->object->getId(),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'histogram' => array(
                                'filter' => array(
                                    'range' => array(
                                        'date' => array(
                                            'gte' => 'now-3M',
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'histogram' => array(
                                        'date_histogram' => array(
                                            'field' => 'date',
                                            'interval' => 'day',
                                            'format' => 'yyyy-MM-dd hh',
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
                                    'tags' => array(
                                        'nested' => array(
                                            'path' => 'twitter-tags',

                                        ),
                                        'aggs' => array(
                                            'tags' => array(
                                                'terms' => array(
                                                    'field' => 'twitter-tags.id',
                                                    'size' => 10,
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
        ));
        $this->render('Dane.DataBrowser/browser');

    }

}
