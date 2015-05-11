<?php

App::uses('ApplicationsController', 'Controller');

class MediaController extends ApplicationsController
{
    public $settings = array(
        'menu' => array(
            array(
                'id' => '',
                'label' => 'Start'
            ),
            array(
                'id' => 'tweets',
                'label' => 'Tweety'
            ),
            array(
                'id' => 'twitter_accounts',
                'label' => 'Obserwowane konta'
            ),
            array(
                'id' => 'media_2013',
                'label' => 'Media w 2013r.'
            ),
        ),
        'title' => 'Media',
        'subtitle' => 'Polityka w mediach społecznościowych',
        'headerImg' => 'media',
    );


    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/media/img/social/media.jpg');
    }
	
	public function view() {
		
		$datasets = $this->getDatasets('media');
	    
        $options  = array(
            'searchTitle' => 'Szukaj w tweetach i kontach twitter...',
            'conditions' => array(
	            'dataset' => array_keys($datasets),
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Media',
		            'element' => 'cover',
	            ),
	            'aggs' => array(
					'prawo_obowiazujace' => array(
						'filter' => array(
							'bool' => array(
								'must' => array(
									array(
										'term' => array(
											'dataset' => 'prawo',
										),
									),
									array(
										'term' => array(
											'data.prawo.status_id' => '1',
										),
									),
								),
							),
						),
						'aggs' => array(
							'typ_id' => array(
					            'terms' => array(
						            'field' => 'prawo.typ_id',
						            'exclude' => array(
							            'pattern' => '0'
						            ),
					            ),
					            'aggs' => array(
						            'label' => array(
							            'terms' => array(
								            'field' => 'data.prawo.typ_nazwa',
							            ),
						            ),
					            ),
					        ),
					        'autor_id' => array(
					            'terms' => array(
						            'field' => 'prawo.autor_id',
						            'exclude' => array(
							            'pattern' => '0'
						            ),
					            ),
					            'aggs' => array(
						            'label' => array(
							            'terms' => array(
								            'field' => 'data.prawo.autor_nazwa',
							            ),
						            ),
					            ),
					        ),
						),
					),
					'prawo' => array(
						'filter' => array(
							'bool' => array(
								'must' => array(
									array(
										'term' => array(
											'dataset' => 'prawo',
										),
									),
								),
							),
						),
						'aggs' => array(
					        'date' => array(
					            'date_histogram' => array(
						            'field' => 'date',
						            'interval' => 'year',
						            'format' => 'yyyy-MM-dd',
					            ),
					        ),
					        'wejda' => array(
						        'filter' => array(
							        'bool' => array(
								        'must' => array(
									        array(
										        'range' => array(
											        'data.prawo.data_wejscia_w_zycie' => array(
												        'gte' => 'now',
											        ),
										        ),
									        ),
								        ),
							        ),
						        ),
						        'aggs' => array(
							        'top' => array(
								        'top_hits' => array(
									        'size' => 5,
									        'fielddata_fields' => array('dataset', 'id'),
									        'sort' => array(
										        'data.prawo.data_wejscia_w_zycie' => array(
											        'order' => 'asc',
										        ),
									        ),
								        ),
							        ),
						        ),
					        ),
					        'weszly' => array(
						        'filter' => array(
							        'bool' => array(
								        'must' => array(
									        array(
										        'range' => array(
											        'data.prawo.data_wejscia_w_zycie' => array(
												        'lt' => 'now',
											        ),
										        ),
									        ),
								        ),
							        ),
						        ),
						        'aggs' => array(
							        'top' => array(
								        'top_hits' => array(
									        'size' => 5,
									        'fielddata_fields' => array('dataset', 'id'),
									        'sort' => array(
										        'data.prawo.data_wejscia_w_zycie' => array(
											        'order' => 'desc',
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
			            'label' => 'Zbiory danych',
			            'skin' => 'datasets',
			            'class' => 'special',
		                'field' => 'dataset',
		                'dictionary' => $datasets,
		            ),
		        ),
            ),
        );
        
	    $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
		
	}
	
    public function _view()
    {
	    
	    
	    
        $this->setMenuSelected();
        
        $ranges = array('24h', '3d', '7d', '1m');
        $range = (isset($this->request->query['range']) && in_array($this->request->query['range'], $ranges)) ?
            $this->request->query['range'] :
            $ranges[0];


        $toc = array(
            array(
                'name' => 'media',
                'title' => 'Urzędy w mediach',
            ),
            array(
                'name' => 'twitter',
                'title' => 'Polityka na Twitterze',
                'subchapters' => array(
                    array(
                        'name' => 'obserwowani',
                        'title' => 'Najbardziej obserwowani',
                    ),
                    array(
                        'name' => 'najaktywniejsi',
                        'title' => 'Najaktywniesji',
                    ),
                    array(
                        'name' => 'retweetowani',
                        'title' => 'Najczęściej retweetowani',
                    ),
                    array(
                        'name' => 'retweetowane_tresci',
                        'title' => 'Najczęściej retweetowane treści',
                    ),
                    array(
                        'name' => 'hashtagi',
                        'title' => 'Najpopularniejsze hashtagi',
                    ),
                    array(
                        'name' => 'www',
                        'title' => 'Najczęściej udostępniane adresy WWW',
                    ),
                    array(
                        'name' => 'wzmiankowani',
                        'title' => 'Najczęściej wzmiankowani',
                    ),
                    array(
                        'name' => 'wywolujacy_dyskusje',
                        'title' => 'Najczęściej wywołujący dyskusje',
                    ),
                    array(
                        'name' => 'dyskutowane_tweety',
                        'title' => 'Najbardziej dyskutowane tweety',
                    ),
                    array(
                        'name' => 'aplikacje',
                        'title' => 'Najczęściej używane aplikacje',
                    ),
                    array(
                        'name' => 'wpadki',
                        'title' => 'Wpadki',
                    ),
                ),
            ),
            array(
                'name' => 'prawo',
                'title' => 'Prawo',
            ),
            array(
                'name' => 'kontrowersje',
                'title' => 'Kontrowersje',
            ),
            array(
                'name' => 'wnioski',
                'title' => 'Wnioski',
            ),
            array(
                'name' => 'ofundacji',
                'title' => 'O Fundacji',
            ),
            array(
                'name' => 'twitter_na_swiecie',
                'title' => 'Twitter na świecie',
            ),
        );


        $toc[0]['active'] = true;


        $this->set('toc', $toc);


        $font = array(
            'min' => 15,
            'max' => 100,
        );
        $font['diff'] = $font['max'] - $font['min'];

		
		$stats = $this->Media->getTwitterStats($range);
		
		

        $tags = $stats['from']['*']['tags']['objects'];

        $_stats = array(
            'min' => (int)$tags[count($tags) - 1]['count'],
            'max' => (int)$tags[1]['count'],
        );
        $_stats['diff'] = $_stats['max'] - $_stats['min'];

        foreach ($tags as &$tag) {
            $score = $_stats['diff']
                ? ($tag['count'] - $_stats['min']) / $_stats['diff']
                : 0;

            $score = min($score, 1);

            $tag = array_merge($tag, array(
                'score' => $score,
                'size' => $font['min'] + $score * $font['diff'],
            ));
        }

        shuffle($tags);
        $stats['from']['*']['tags']['objects'] = $tags;
        $this->set('stats', $stats);

        // debug( $stats ); die();

        $accounts_types = $this->Media->getTwitterAccountsTypes();
        $accounts_types_ids = array_column($accounts_types, 'id');
        $accounts_types_nazwy = array_column($accounts_types, 'nazwa', 'id');
        $accounts_types_klasy = array_column($accounts_types, 'class', 'id');


        $ranks = array(


            array(
                'title' => 'Najczęściej retweetowane treści',
                'name' => 'retweetowane_tresci',
                'groups' => array(
                    array(
                        'mode' => 'tweet',
                        'field' => 'liczba_retweetow',
                        'order' => 'liczba_retweetow desc',
                        'link' => array(
                            'dataset' => 'twitter',
                        ),
                    ),
                ),
            ),
            array(
                'title' => 'Najbardziej dyskutowane tweety',
                'name' => 'dyskutowane_tweety',
                'groups' => array(
                    array(
                        'mode' => 'tweet',
                        'field' => 'liczba_zaangazowan',
                        'order' => 'liczba_zaangazowan desc',
                        'link' => array(
                            'dataset' => 'twitter',
                        ),
                    ),
                ),
            ),
            array(
                'title' => 'Najpopularniejsze hashtagi',
                'name' => 'hashtagi',
                'groups' => array(
                    array(
                        'mode' => 'tags',
                    ),
                    array(
                        'mode' => 'tag',
                    ),
                ),
            ),
            /*
            array(
                'title' => 'Największy przyrost oberwujących',
                'name' => 'obserwujacy',
                'groups' => array(
                    array(
                        'mode' => 'account',
                        'preset' => 'followers',
                        'desc' => '',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
            */

            array(
                'title' => 'Najczęściej używane aplikacje',
                'name' => 'aplikacje',
                'groups' => array(
                    array(
                        'mode' => 'source',
                    ),
                ),
            ),
            array(
                'title' => 'Najczęściej udostępniane adresy WWW',
                'name' => 'www',
                'groups' => array(
                    array(
                        'mode' => 'url',
                    ),
                ),
            ),
            /*
            array(
                'title' => 'Najaktywniejsi',
                'name' => 'najaktywniejsi',
                'groups' => array(
                    array(
                        'mode' => 'stats',
                        'preset' => 'twitter_account_id',
                        'field' => 'liczba_tweetow_wlasnych_2013',
                        'order' => 'liczba_tweetow_wlasnych_2013 desc',
                        'desc' => 'Liczba nowych, własnych tweetów. Pod uwagę nie są brane retweety.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
            */

            array(
                'title' => 'Najczęściej retweetowani',
                'name' => 'retweetowani',
                'groups' => array(
                    array(
                        'mode' => 'stats',
                        'preset' => 'accounts_retweets',
                        'field' => 'liczba_retweetow_wlasnych_2013',
                        'order' => 'liczba_retweetow_wlasnych_2013 desc',
                        'desc' => 'Liczba retweetów tweetów z danego konta.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
            array(
                'title' => 'Najczęściej wywołujący dyskusje',
                'name' => 'wywolujacy_dyskusje',
                'groups' => array(
                    array(
                        'mode' => 'stats',
                        'preset' => 'accounts_replies',
                        'field' => 'liczba_odpowiedzi_rts_2013',
                        'order' => 'liczba_odpowiedzi_rts_2013 desc',
                        'desc' => 'Liczba komentarzy do tweetów z danego konta.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
            array(
                'title' => 'Najczęściej wzmiankowani',
                'name' => 'wzmiankowani',
                'groups' => array(
                    array(
                        'mode' => 'stats',
                        'preset' => 'mentions',
                        'field' => 'liczba_wzmianek_rts_2013',
                        'order' => 'liczba_wzmianek_rts_2013 desc',
                        'desc' => 'Liczba tweetów wzmiankujących dane konto.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),


            /*
            array(
                'title' => 'Najczęściej wzmiankowani przez przedstawicieli grup',
                'name' => 'wzmiankowani',
                'groups' => array(
                    array(
                        'mode' => 'stats',
                        'preset' => 'mentions',
                        'field' => 'liczba_wzmianek_rts_2013',
                        'order' => 'liczba_wzmianek_rts_2013 desc',
                        'desc' => 'Liczba tweetów wzmiankujących dane konto.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
            */


        );

		
        foreach ($ranks as &$rank) {

            foreach ($rank['groups'] as $g => $group) {

                // debug( $group );

                if ($group['mode'] == 'tweet') {

                    $types = $this->Media->getTwitterTweetsGroupByTypes($range, $accounts_types_ids, $group['field']);
						
                    foreach ($types as &$type) {
                        $type = array_merge($type, array(
                            'nazwa' => $accounts_types_nazwy[$type['id']],
                            'class' => $accounts_types_klasy[$type['id']],
                        ));
                    }

                    $rank['groups'][$g] = array_merge($group, array(
                        'types' => $types,
                    ));

                    // debug( $rank['groups'][$g] );

                } elseif ($group['mode'] == 'tag') {


                    $_data = $stats['from']['types'];

                    for ($_d = 0; $_d < count($_data); $_d++) {
                        $rank['groups'][$g]['types'][$_data[$_d]['type_id']] = array_merge($_data[$_d]['data']['tags'], array(
                            'id' => $_data[$_d]['type_id'],
                            'nazwa' => @$accounts_types_nazwy[$_data[$_d]['type_id']],
                            'class' => @$accounts_types_klasy[$_data[$_d]['type_id']],
                        ));
                    }


                } elseif ($group['mode'] == 'url') {

                    $_data = $stats['from']['types'];

                    for ($_d = 0; $_d < count($_data); $_d++) {
                        $rank['groups'][$g]['types'][$_data[$_d]['type_id']] = array_merge($_data[$_d]['data']['urls'], array(
                            'id' => $_data[$_d]['type_id'],
                            'nazwa' => @$accounts_types_nazwy[$_data[$_d]['type_id']],
                            'class' => @$accounts_types_klasy[$_data[$_d]['type_id']],
                        ));
                    }

                } elseif ($group['mode'] == 'source') {

                    $_data = $stats['from']['types'];

                    for ($_d = 0; $_d < count($_data); $_d++) {
                        $rank['groups'][$g]['types'][$_data[$_d]['type_id']] = array_merge($_data[$_d]['data']['source_id'], array(
                            'id' => $_data[$_d]['type_id'],
                            'nazwa' => @$accounts_types_nazwy[$_data[$_d]['type_id']],
                            'class' => @$accounts_types_klasy[$_data[$_d]['type_id']],
                        ));
                    }

                } elseif ($group['mode'] == 'stats') {


                    $_data = $stats['to']['types'];

                    // debug( $_data ); die();

                    for ($_d = 0; $_d < count($_data); $_d++) {
                        $rank['groups'][$g]['types'][$_data[$_d]['type_id']] = array_merge($_data[$_d]['data'][$group['preset']], array(
                            'id' => $_data[$_d]['type_id'],
                            'nazwa' => @$accounts_types_nazwy[$_data[$_d]['type_id']],
                            'class' => @$accounts_types_klasy[$_data[$_d]['type_id']],
                        ));
                    }


                }

            }

        }


        // debug( $ranks );

        $this->set('range', $range);
        $this->set('ranks', $ranks);
    }
    
    public function tweets()
    {
	    if( !isset($this->request->query['conditions']['twitter.konto_obserwowane']) )
	    	$this->request->query['conditions']['twitter.konto_obserwowane'] = '1';
	    
	    $this->title = "Tweety - Media";
        $this->loadDatasetBrowser('twitter');
    }

    public function twitter_accounts()
    {
	    $this->title = "Konta Twitter - Media";
        $this->loadDatasetBrowser('twitter_accounts');
    }

    public function media_2013()
    {
        $this->title = "Media polityczne w 2013 roku";
        //$this->loadDatasetBrowser('twitter_accounts');
    }
}