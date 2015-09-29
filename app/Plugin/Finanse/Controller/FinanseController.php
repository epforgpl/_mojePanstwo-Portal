<?php

App::uses('ApplicationsController', 'Controller');

class FinanseController extends ApplicationsController
{

    public $settings = array(
        'id' => 'finanse',
        'title' => 'Finanse',
        'subtitle' => 'Przeglądaj informacje o finansach Polski',
    );

    private $histogramIntervals = array(
        100000000,                  // 100 mln.
        10000000,                   // 10 mln.
        1000000,                    // 1 mln.
        100000,                     // 100 tys.
        1000
    );

    public function view()
	{
        App::import("Model", "Finanse.PKB");
        $PKB = new PKB();

        $dane=$PKB->getPKB();

        $this->set('pkb', $dane);
        $this->set('_serialize', 'pkb');


        $compare = array(
            'items' => array(
                array(
                    'id' => 'wszystkie',
                    'label' => 'Wszystkie gminy',
                )
            ),
        );

        $compare['items'][] = array(
            'id' => 'powiatowe',
            'label' => 'Miasta na prawach powiatów',
        );

        $compare['items'][] = array(
            'id' => 'wojewodzkie',
            'label' => 'Miasta wojewódzkie',
        );

        $types = array(
            '1' => array(
                'id' => 'miejskie',
                'interval' => 100000000, // 100 mln
                'interval_pp' => 100,
            ),
            '3' => array(
                'id' => 'miejsko-wiejskie',
                'interval' => 10000000, // 10 mln
                'interval_pp' => 100,
            ),
            '2' => array(
                'id' => 'wiejskie',
                'interval' => 1000000,  // 1 mln
                'interval_pp' => 100,
            ),
        );

        $types['4'] = $types['1']; // miejskie typ_id IN (1, 4)
        $type = $types['1'];

        $mode = false;

        $options = array(
            'data' => array(
                'items' => array(
                    array(
                        'id' => 'wydatki',
                        'label' => 'Wydatki - wartości absolutne',
                    ),
                    array(
                        'id' => 'wydatki_na_osobe',
                        'label' => 'Wydatki w przeliczeniu na osobę'
                    )
                ),
            ),
            'timerange' => array(
                'items' => array(
                    array(
                        'id' => '2015Q1',
                        'label' => '2015, I kwartał',
                    ),
                    array(
                        'id' => '2014',
                        'label' => '2014, cały rok',
                    ),
                    array(
                        'id' => '2014Q4',
                        'label' => '2014, IV kwartał',
                    ),
                    array(
                        'id' => '2014Q3',
                        'label' => '2014, III kwartał',
                    ),
                    array(
                        'id' => '2014Q2',
                        'label' => '2014, II kwartał',
                    ),
                    array(
                        'id' => '2014Q1',
                        'label' => '2014, I kwartał',
                    ),
                    array(
                        'id' => '2013',
                        'label' => '2013, cały rok',
                    ),
                    array(
                        'id' => '2013Q4',
                        'label' => '2013, IV kwartał',
                    ),
                    array(
                        'id' => '2013Q3',
                        'label' => '2013, III kwartał',
                    ),
                    array(
                        'id' => '2013Q2',
                        'label' => '2013, II kwartał',
                    ),
                    array(
                        'id' => '2013Q1',
                        'label' => '2013, I kwartał',
                    ),
                    array(
                        'id' => '2012',
                        'label' => '2012, cały rok',
                    ),
                    array(
                        'id' => '2012Q4',
                        'label' => '2012, IV kwartał',
                    ),
                    array(
                        'id' => '2012Q3',
                        'label' => '2012, III kwartał',
                    ),
                    array(
                        'id' => '2012Q2',
                        'label' => '2012, II kwartał',
                    ),
                    array(
                        'id' => '2012Q1',
                        'label' => '2012, I kwartał',
                    ),
                ),
            ),
            'compare' => $compare,
        );


        foreach( $options as $key => &$option ) {

            $allowed_values = array_column($option['items'], 'id');

            if(
                array_key_exists($key, $this->request->query) &&
                in_array($this->request->query[$key], $allowed_values)
            ) {

                $option['selected_id'] = $this->request->query[$key];
                $option['selected_i'] = array_search($this->request->query[$key], $allowed_values);

            } else {

                $option['selected_id'] = $option['items'][0]['id'];
                $option['selected_i'] = 0;

            }

        }

        $this->set('filter_options', $options);

        $main_chart = array();


        // DATA

        $data = $options['data']['items'][ $options['data']['selected_i'] ]['id'];
        $field = 'wydatki';
        $histogram_interval = $type['interval'];

        if( $data=='wydatki' ) {

            $mode = 'absolute';
            $main_chart['title'] = 'Wydatki - wartości absolutne';

        } elseif( $data=='wydatki_na_osobe' ) {

            $mode = 'perperson';
            $main_chart['title'] = 'Wydatki w przeliczeniu na osobę';
            $field = 'wydatki_pp';
            $histogram_interval = $type['interval_pp'];
            $this->histogramIntervals = array(
                100,
                50,
                20,
                10
            );

        }


        $histogramAggs = array();
        foreach($this->histogramIntervals as $i => $interval) {
            $histogramAggs['histogram_' . $i] = array(
                'histogram' => array(
                    'field' => 'gminy-wydatki-dzialy.' . $field,
                    'interval' => $interval,
                ),
            );
        }

        // TIMERANGE

        $timerange = $options['timerange']['items'][ $options['timerange']['selected_i'] ]['id'];

        if(preg_match('/^([0-9]{4})$/', $timerange)) {
            $rok = (int) $timerange;
            $kwartal = 0;
        } elseif(preg_match('/^([0-9]{4})Q([0-4]{1})$/', $timerange)) {
            $p = explode('Q', $timerange);
            $rok = (int) $p[0];
            $kwartal = (int) $p[1];
        } else {
            throw new NotFoundException;
        }




        // COMPARE

        $compare = $options['compare']['items'][ $options['compare']['selected_i'] ]['id'];

        if( $compare=='wszystkie' ) {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ze wszystkimi gminami';

            $histogram_interval = $mode == 'absolute' ? 100000000 : $type['interval_pp'];

        } elseif( $compare=='powiatowe' ) {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z miastami na prawach powiatu';


        } elseif( $compare=='wojewodzkie' ) {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.wojewodzka' => '1',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Gminy wojewódzkie';


        } elseif( $compare=='miejskie' ) {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.typ_id' => array('1', '4'),
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Gminy miejskie';

        } elseif( $compare=='miejsko-wiejskie' ) {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.typ_id' => '3',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje ' . $this->object->getTitle() . ' z gminami miejsko-wiejskimi';

        } elseif( $compare=='wiejskie' ) {

            $gminy_filter = array(
                array(
                    'term' => array(
                        'dataset' => 'gminy',
                    ),
                ),
                array(
                    'term' => array(
                        'data.gminy.typ_id' => '2',
                    ),
                ),
            );

            $main_chart['subtitle'] = 'Porównuje z gminami wiejskimi';

        }


        $aggs = array(
            'gminy' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => $gminy_filter,
                    ),
                ),
                'scope' => 'global',
                'aggs' => array(
                    /*
                    'top' => array(
                        'top_hits' => array(
                            'size' => 100,
                        ),
                    ),
                    */
                    'sumy' => array(
                        'nested' => array(
                            'path' => 'gminy-wydatki-okresy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-wydatki-okresy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-wydatki-okresy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'min' => array(
                                        'terms' => array(
                                            'field' => 'gminy-wydatki-okresy.' . $field,
                                            'size' => '1',
                                            'order' => array(
                                                '_term' => 'asc',
                                            ),
                                        ),
                                        'aggs' => array(
                                            'reverse' => array(
                                                'reverse_nested' => '_empty',
                                                'aggs' => array(
                                                    'top' => array(
                                                        'top_hits' => array(
                                                            'size' => 1,
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'max' => array(
                                        'terms' => array(
                                            'field' => 'gminy-wydatki-okresy.' . $field,
                                            'size' => '1',
                                            'order' => array(
                                                '_term' => 'desc',
                                            ),
                                        ),
                                        'aggs' => array(
                                            'reverse' => array(
                                                'reverse_nested' => '_empty',
                                                'aggs' => array(
                                                    'top' => array(
                                                        'top_hits' => array(
                                                            'size' => 1,
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'percentiles' => array(
                                        'percentiles' => array(
                                            'field' => 'gminy-wydatki-okresy.' . $field,
                                            'percents' => array(50),
                                        ),
                                    ),
                                    'stats' => array(
                                        'stats' => array(
                                            'field' => 'gminy-wydatki-okresy.' . $field,
                                        ),
                                    ),
                                    'histogram' => array(
                                        'histogram' => array(
                                            'field' => 'gminy-wydatki-okresy.' . $field,
                                            'interval' => $histogram_interval,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'dzialy' => array(
                        'nested' => array(
                            'path' => 'gminy-wydatki-dzialy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-wydatki-dzialy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-wydatki-dzialy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'dzialy' => array(
                                        'terms' => array(
                                            'field' => 'gminy-wydatki-dzialy.dzial_id',
                                            'size' => 100,
                                        ),
                                        'aggs' => array_merge(array(
                                            'label' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-wydatki-dzialy.dzial',
                                                    'size' => 1,
                                                ),
                                            ),
                                            'min' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-wydatki-dzialy.' . $field,
                                                    'size' => 1,
                                                    'order' => array(
                                                        '_term' => 'asc',
                                                    ),
                                                ),
                                                'aggs' => array(
                                                    'reverse' => array(
                                                        'reverse_nested' => '_empty',
                                                        'aggs' => array(
                                                            'top' => array(
                                                                'top_hits' => array(
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'max' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-wydatki-dzialy.' . $field,
                                                    'size' => 1,
                                                    'order' => array(
                                                        '_term' => 'desc',
                                                    ),
                                                ),
                                                'aggs' => array(
                                                    'reverse' => array(
                                                        'reverse_nested' => '_empty',
                                                        'aggs' => array(
                                                            'top' => array(
                                                                'top_hits' => array(
                                                                    'size' => 1,
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'percentiles' => array(
                                                'percentiles' => array(
                                                    'field' => 'gminy-wydatki-dzialy.' . $field,
                                                    'percents' => array(50),
                                                ),
                                            ),
                                            'stats' => array(
                                                'stats' => array(
                                                    'field' => 'gminy-wydatki-dzialy.' . $field,
                                                ),
                                            ),
                                        ),
                                            $histogramAggs
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );

        // debug($aggs); die();


        $this->set('main_chart', $main_chart);
        $this->set('mode', $mode);

        $options = array(
            'searchTitle' => 'Szukaj w budżetach krajowych...',
            'conditions' => array(
                'dataset' => 'budzety',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Finanse',
                    'element' => 'budzety-cover',
                ),
                'aggs' => array(
                    'gminy' => $aggs['gminy'],
	                'budzety' => array(
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'term' => array(
							                'dataset' => 'budzety',
						                ),
					                ),
					                array(
						                'range' => array(
							                'data.budzety.rok' => array(
								                'gte' => 1989
							                ),
						                ),
					                ),
				                ),
			                ),
		                ),
		                'aggs' => array(
			                'top' => array(
				                'top_hits' => array(
					                'size' => 100,
					                'sort' => array(
						                'date' => array(
							                'order' => 'desc',
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

		$this->chapter_selected = 'view';
        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

	}

    public function getChapters() {

	    return array(
		    'items' => array(
			    array(
				    'href' => '/finanse',
				    'label' => 'Budżety krajowe',
			    ),
			    array(
				    'id' => 'samorzad',
				    'href' => '/finanse/samorzad',
				    'label' => 'Budżety samorządu terytorialnego',
			    ),
		    ),
	    );

    }

}
