<?php

class PagesController extends PanstwoInternetAppController
{
    public $components = array(
        'Session',
        'RequestHandler'
    );

    public function home()
    {


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
            'min' => 10,
            'max' => 100,
        );
        $font['diff'] = $font['max'] - $font['min'];

        $stats = $this->API->getAnnualTwitterStats(2013);

        $tags = $stats['tags'];
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

        $stats['tags'] = $tags;


        $this->set('stats', $stats);


        $accounts_types = $this->API->getTwitterAccountsTypes();
        $accounts_types_ids = array_column($accounts_types, 'id');
        $accounts_types_nazwy = array_column($accounts_types, 'nazwa', 'id');
        $accounts_types_klasy = array_column($accounts_types, 'class', 'id');

        $ranks = array(
            array(
                'title' => 'Najbardziej obserwowani',
                'name' => 'obserwowani',
                'groups' => array(
                    array(
                        'mode' => 'account',
                        'field' => 'liczba_obserwujacych',
                        'order' => 'liczba_obserwujacych desc',
                        'desc' => 'Ranking na podstawie ilości osób obserwujących danego użytkownika',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
            array(
                'title' => 'Najaktywniejsi',
                'name' => 'najaktywniejsi',
                'groups' => array(
                    array(
                        'mode' => 'account',
                        'field' => 'liczba_tweetow_wlasnych_2013',
                        'order' => 'liczba_tweetow_wlasnych_2013 desc',
                        'desc' => 'Ranking na podstawie nowych, własnych tweetów. Pod uwagę nie są brane retweety.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
            array(
                'title' => 'Najczęściej retweetowani',
                'name' => 'retweetowani',
                'groups' => array(
                    array(
                        'mode' => 'account',
                        'field' => 'liczba_retweetow_wlasnych_2013',
                        'order' => 'liczba_retweetow_wlasnych_2013 desc',
                        'desc' => 'Ranking na podstawie sumarycznej ilości wszystkich retweetów, które uzyskały tweety danego użytkownika.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
                        ),
                    ),
                ),
            ),
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
                'title' => 'Najpopularniejsze hashtagi',
                'name' => 'hashtagi',
                'groups' => array(
                    array(
                        'desc' => 'Najczęściej tweetowane tagi przez monitorowanych użytkowników.',
                        'mode' => 'tags',
                    ),
                    array(
                        'mode' => 'tag',
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
            array(
                'title' => 'Najczęściej wzmiankowani',
                'name' => 'wzmiankowani',
                'groups' => array(
                    array(
                        'mode' => 'account',
                        'field' => 'liczba_wzmianek_rts_2013',
                        'order' => 'liczba_wzmianek_rts_2013 desc',
                        'desc' => 'Ranking na podstawie sumy tweetów i retweetów wzmiankujących danego użytkownika.',
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
                        'mode' => 'account',
                        'field' => 'liczba_odpowiedzi_rts_2013',
                        'order' => 'liczba_odpowiedzi_rts_2013 desc',
                        'desc' => 'Ranking na podstawie sumy tweetów i retweetów będących odpowiedziami na tweety danego użytkownika.',
                        'link' => array(
                            'dataset' => 'twitter_accounts',
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
                        'field' => 'liczba_odpowiedzi',
                        'order' => 'liczba_odpowiedzi desc',
                        'link' => array(
                            'dataset' => 'twitter',
                        ),
                    ),
                ),
            ),
            array(
                'title' => 'Najczęściej używane aplikacje',
                'name' => 'aplikacje',
                'groups' => array(
                    array(
                        'mode' => 'source',
                    ),
                ),
            ),
        );


        foreach ($ranks as &$rank) {

            foreach ($rank['groups'] as &$group) {

                if ($group['mode'] == 'account') {

                    $types = $this->API->getTwitterAccountsGroupByTypes($accounts_types_ids, $group['field']);
                    foreach ($types as &$type) {
                        $type = array_merge($type, array(
                            'title' => $accounts_types_nazwy[$type['id']],
                            'class' => $accounts_types_klasy[$type['id']],
                        ));
                    }

                    $group = array_merge($group, array(
                        'types' => $types,
                    ));

                } elseif ($group['mode'] == 'tweet') {

                    $types = $this->API->getTwitterTweetsGroupByTypes($accounts_types_ids, $group['field']);

                    foreach ($types as &$type) {
                        $type = array_merge($type, array(
                            'title' => $accounts_types_nazwy[$type['id']],
                            'class' => $accounts_types_klasy[$type['id']],
                        ));
                    }

                    $group = array_merge($group, array(
                        'types' => $types,
                    ));

                } elseif ($group['mode'] == 'tag') {

                    $group['types'] = $stats['tags_by_groups'];

                } elseif ($group['mode'] == 'url') {

                    $group['types'] = $stats['urls_by_groups'];

                } elseif ($group['mode'] == 'source') {

                    $group['types'] = $stats['sources_by_groups'];

                }

            }

        }


        // var_export( $ranks ); die();
        $this->set('ranks', $ranks);
        $this->set('title_for_layout', 'Państwo w mediach społecznościowych');

    }

} 