<?php

App::uses('ApplicationsController', 'Controller');

class FinanseController extends ApplicationsController
{
	
	public $helpers = array('FVal');
	public $components = array('RequestHandler');
    public $settings = array(
        'id' => 'finanse',
        'title' => 'Finanse publiczne',
        'subtitle' => 'Przeglądaj informacje o finansach Polski',
    );
    public $menu = array(
        
        'gminy' => array(
            'menu_id' => 'gminy',
            'label' => 'Budżety gmin',
            'icon' => 'dot',
        ),
        
        'dochody_i_wydatki_sektora_finansow_publicznych' => array(
            'menu_id' => 'dochody_i_wydatki_sektora_finansow_publicznych',
            'label' => 'Dochody i wydatki sektora finansów publicznych',
            'icon' => 'dot',
        ),
        'dlug_publiczny' => array(
            'menu_id' => 'dlug_publiczny',
            'label' => 'Dług publiczny',
            'icon' => 'dot',
        ),
        
        'wykonanie_budzetu_panstwa' => array(
            'menu_id' => 'wykonanie_budzetu_panstwa',
            'label' => 'Wykonanie budżetu państwa',
            'icon' => 'dot',
        ),
        
        'dotacje_i_subwencje_budzetu_panstwa' => array(
            'menu_id' => 'dotacje_i_subwencje_budzetu_panstwa',
            'label' => 'Dotacje i subwencje z budżetu państwa',
            'icon' => 'dot',
        ),
        
        
        
        'dochody_budzetu_panstwa' => array(
            'menu_id' => 'dochody_budzetu_panstwa',
            'label' => 'Dochody budżetu państwa',
            'icon' => 'dot',
        ),
        'wydatki_budzetu_panstwa_wedlug_dzialow' => array(
            'menu_id' => 'wydatki_budzetu_panstwa_wedlug_dzialow',
            'label' => 'Wydatki budżetu państwa według działów',
            'icon' => 'dot',
        ),
        /*
        'wydatki_budzetu_panstwa_wedlug_czesci' => array(
            'menu_id' => 'wydatki_budzetu_panstwa_wedlug_czesci',
            'label' => 'Wydatki budżetu państwa według części',
            'icon' => 'dot',
        ),
        */
        
        
        
        
        
        
        'dochody_ue' => array(
            'menu_id' => 'dochody_ue',
            'label' => 'Dochody budżetu środków europejskich',
            'icon' => 'dot',
        ),
        'wydatki_ue' => array(
            'menu_id' => 'wydatki_ue',
            'label' => 'Wydatki budżetu środków europejskich',
            'icon' => 'dot',
        ),
        
        
        
        'fundusze_celowe' => array(
            'menu_id' => 'fundusze_celowe',
            'label' => 'Fundusze celowe',
            'icon' => 'dot',
        ),
        'wykonanie_fus' => array(
            'menu_id' => 'wykonanie_fus',
            'label' => 'Wykonanie Funduszu Ubezpieczeń Społecznych',
            'icon' => 'dot',
        ),
        'wykonanie_fer_rolnikow' => array(
            'menu_id' => 'wykonanie_fer_rolnikow',
            'label' => 'Wykonanie Funduszu Emerytalno-Rentowego',
            'icon' => 'dot',
        ),
        'wykonanie_funduszu_pracy' => array(
            'menu_id' => 'wykonanie_funduszu_pracy',
            'label' => 'Wykonanie Funduszu Pracy',
            'icon' => 'dot',
        ),
        
        
        'wskazniki_makroekonomiczne' => array(
            'menu_id' => 'wskazniki_makroekonomiczne',
            'label' => 'Wskaźniki makroekonomiczne',
            'icon' => 'dot',
        ),
        
        /*
        'budzet_panstwa' => array(
            'menu_id' => 'budzet_panstwa',
            'label' => 'Budżet państwa',
            'icon' => 'dot',
        ),
        
        'budzet_srodkow_europejskich' => array(
            'menu_id' => 'budzet_srodkow_europejskich',
            'label' => 'Budżet środków europejskich',
            'icon' => 'dot',
        ),
        */        
        
    );
    private $histogramIntervals = array(
        100000000,                  // 100 mln.
        10000000,                   // 10 mln.
        1000000,                    // 1 mln.
        100000,                     // 100 tys.
        1000
    );

	public function view() {

		$options = array(
            'searchTitle' => 'Szukaj w finansach publicznych...',
            'conditions' => array(
                'dataset' => 'budzety',
            ),
            'cover' => array(
	            // 'cache' => true,
                'view' => array(
                    'plugin' => 'Finanse',
                    'element' => 'cover',
                ),
                'aggs' => array(
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

        if(
	        isset($this->request->params['p1']) &&
	        isset($this->request->params['p2'])
        ) {

	        $p1 = $this->request->params['p1'];
	        $p2 = $this->request->params['p2'];

        } else {

	        $p1 = '2014';
	        $p2 = '2015';

        }

        $compareData = $this->Finanse->getCompareData($p1, $p2);
        $this->set('p1', $p1);
        $this->set('p2', $p2);
        $this->set('compareData', $compareData);

		$this->chapter_selected = 'view';
        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

	}

    public function gminy() {
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
                    'min_doc_count' => 1,

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

            $main_chart['subtitle'] = 'Porównuje z miastami na prawach powiatu';


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

            $main_chart['subtitle'] = 'Porównuje z gminami miejsko-wiejskimi';

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
                                                            '_source' => array(
	                                                            'include' => array(
		                                                            'data.*'
	                                                            ),
                                                            ),
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
                                                            '_source' => array(
	                                                            'include' => array(
		                                                            'data.*'
	                                                            ),
                                                            ),
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
                                                                    '_source' => array(
			                                                            'include' => array(
				                                                            'data.*'
			                                                            ),
		                                                            ),
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
                                                                    '_source' => array(
			                                                            'include' => array(
				                                                            'data.*'
			                                                            ),
		                                                            ),
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
            'gmina' => array(
                'scope' => 'global',
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'gminy',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'id' => 903,
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
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
                                    'wydatki' => array(
                                        'sum' => array(
                                            'field' => 'gminy-wydatki-okresy.' . $field,
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
                                            'order' => array(
                                                'wydatki' => 'desc',
                                            ),
                                        ),
                                        'aggs' => array(
                                            'label' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-wydatki-dzialy.dzial',
                                                    'size' => 1,
                                                ),
                                            ),
                                            'wydatki' => array(
                                                'sum' => array(
                                                    'field' => 'gminy-wydatki-dzialy.' . $field,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'rozdzialy' => array(
                        'nested' => array(
                            'path' => 'gminy-wydatki-rozdzialy',
                        ),
                        'aggs' => array(
                            'timerange' => array(
                                'filter' => array(
                                    'bool' => array(
                                        'must' => array(
                                            array(
                                                'term' => array(
                                                    'gminy-wydatki-rozdzialy.rok' => $rok,
                                                ),
                                            ),
                                            array(
                                                'term' => array(
                                                    'gminy-wydatki-rozdzialy.kwartal' => $kwartal,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                                'aggs' => array(
                                    'dzialy' => array(
                                        'terms' => array(
                                            'field' => 'gminy-wydatki-rozdzialy.dzial_id',
                                            'size' => 100,
                                        ),
                                        'aggs' => array(
                                            'rozdzialy' => array(
                                                'terms' => array(
                                                    'field' => 'gminy-wydatki-rozdzialy.rozdzial_id',
                                                    'size' => 100,
                                                    'order' => array(
                                                        'wydatki' => 'desc',
                                                    ),
                                                ),
                                                'aggs' => array(
                                                    'nazwa' => array(
                                                        'terms' => array(
                                                            'field' => 'gminy-wydatki-rozdzialy.rozdzial',
                                                            'size' => 1,
                                                        ),
                                                    ),
                                                    'wydatki' => array(
                                                        'sum' => array(
                                                            'field' => 'gminy-wydatki-rozdzialy.' . $field,
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
        );

        // debug($aggs); die();

        $this->set('histogram_interval', $histogram_interval);
        $this->set('mode', $mode);
        $this->set('main_chart', $main_chart);

        $options = array(
            'searchTitle' => 'Szukaj w budżetach krajowych...',
            'conditions' => array(
                'dataset' => 'budzety',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Finanse',
                    'element' => 'budzety-gminy',
                ),
                'aggs' => array(
                    'gminy' => $aggs['gminy'],
                    'gmina' => $aggs['gmina'],
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

    public function beforeRender() {

        parent::beforeRender();

        if($this->request->params['action'] == 'gminy') {

            $aggs = $this->viewVars['dataBrowser']['aggs'];
            
            $this->viewVars['dataBrowser']['aggs']['gminy'] = null;
            $this->viewVars['dataBrowser']['aggs']['gmina'] = null;
			
			
			// debug( $aggs['gminy']['sumy']['timerange']['min']['buckets'][0]['reverse']['top']['hits']['hits'][0] );  die();
			
            $global = array(
                'min' => array(
                    'value' => $aggs['gminy']['sumy']['timerange']['min']['buckets'][0]['key'],
                    'label' => $aggs['gminy']['sumy']['timerange']['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                    'id' => $aggs['gminy']['sumy']['timerange']['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                ),
                'max' => array(
                    'value' => $aggs['gminy']['sumy']['timerange']['max']['buckets'][0]['key'],
                    'label' => $aggs['gminy']['sumy']['timerange']['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                    'id' => $aggs['gminy']['sumy']['timerange']['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                ),
                //'cur' => $aggs['gmina']['sumy']['timerange']['wydatki']['value'],
                'median' => $aggs['gminy']['sumy']['timerange']['percentiles']['values']['50.0'],
                'histogram' => $aggs['gminy']['sumy']['timerange']['histogram']['buckets'],
            );

            $global = array_merge($global, array(
                //'left' => ($global['min']['value'] == $global['max']['value']) ? 0 : 100 * ( $global['cur'] - $global['min']['value'] ) / ( $global['max']['value'] - $global['min']['value'] ),
                'median_left' => ($global['min']['value'] == $global['max']['value']) ? 0 : 100 * ($global['median'] - $global['min']['value']) / ($global['max']['value'] - $global['min']['value']),
            ));


            $dzialy = array();

            foreach ($aggs['gmina']['dzialy']['timerange']['dzialy']['buckets'] as $b) {

                $dzial = array(
                    'id' => $b['key'],
                    'label' => @$b['label']['buckets'][0]['key'],
                );

                foreach ($aggs['gminy']['dzialy']['timerange']['dzialy']['buckets'] as $d) {
                    if ($d['key'] == $b['key']) {

                        $min = (int)$d['min']['buckets'][0]['key'];
                        $max = (int)$d['max']['buckets'][0]['key'];
                        $range = $max - $min;

                        $histogram_i = (string)(count($this->histogramIntervals) - 1);

                        foreach ($this->histogramIntervals as $i => $interval) {
                            $buckets = ceil($range / $interval);
                            if ($buckets > 8 && $buckets < 100) {
                                $histogram_i = $i;
                                break;
                            }
                        }

                        if ($range > 300000 && $histogram_i == (count($this->histogramIntervals) - 1)) {
                            $histogram_i = (string)(count($this->histogramIntervals) - 2);
                        }

                        $dzial['global'] = array(
                            'min' => array(
                                'value' => $d['min']['buckets'][0]['key'],
                                'label' => $d['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                                'id' => $d['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                            ),
                            'max' => array(
                                'value' => $d['max']['buckets'][0]['key'],
                                'label' => $d['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['nazwa'],
                                'id' => $d['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['_source']['data']['gminy']['id'],
                            ),
                            'cur' => $b['wydatki']['value'],
                            'median' => $d['percentiles']['values']['50.0'],
                            'histogram' => $d['histogram_' . $histogram_i]['buckets'],
                            'interval' => $this->histogramIntervals[(int)$histogram_i]
                        );

                        $dzial['global'] = array_merge($dzial['global'], array(
                            'left' => ($dzial['global']['min']['value'] == $dzial['global']['max']['value']) ? 0 : 100 * ($dzial['global']['cur'] - $dzial['global']['min']['value']) / ($dzial['global']['max']['value'] - $dzial['global']['min']['value']),
                            'median_left' => ($dzial['global']['min']['value'] == $dzial['global']['max']['value']) ? 0 : 100 * ($dzial['global']['median'] - $dzial['global']['min']['value']) / ($dzial['global']['max']['value'] - $dzial['global']['min']['value']),
                            'class' => ($dzial['global']['cur'] > $dzial['global']['median']) ? 'more' : 'less',
                        ));

                        break;

                    }
                }

                foreach( $aggs['gmina']['rozdzialy']['timerange']['dzialy']['buckets'] as &$c ) {
                    if( $c['key']==$dzial['id'] ) {

                        $rozdzialy = $c['rozdzialy']['buckets'];
                        foreach( $rozdzialy as &$r ) {

                            if( !$r['key'] )
                                continue;

                            $r = array(
                                'id' => $r['key'],
                                'label' => $r['nazwa']['buckets'][0]['key'],
                                'wydatki' => $r['wydatki']['value'],
                            );

                        }

                        $dzial['rozdzialy'] = $rozdzialy;

                        unset($c);
                        break;

                    }
                }

                $dzialy[] = $dzial;

            }

            // debug( $dzialy ); die();

            $this->set('global', $global);
            $this->set('dzialy', $dzialy);
        }

    }

	public function getChapters() {

		$mode = false;
		$items = array();
        $app = $this->getApplication($this->settings['id']);

		if( @$this->viewVars['dataBrowser']['aggs']['_query']['dataset']['buckets'] )
			$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] = $this->viewVars['dataBrowser']['aggs']['_query']['dataset']['buckets'];

        if(
			isset( $this->request->query['q'] ) &&
			$this->request->query['q']
		) {

            $items[] = array(
				'id' => '_results',
				'label' => 'Szukaj w finansach publicznych:',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
				'tool' => array(
					'icon' => 'search',
					'href' => '/' . $this->settings['id'],
				),
				'icon' => 'appIcon',
				'appIcon' => $app['icon'],
				'class' => '_label',
			);

			if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';

		}


        $others_count = 0;

        foreach( $this->menu as $key => $value ) {

            if( !isset($value['menu_id']) )
				$value['menu_id'] = '';

            $item = array(
				'id' => $value['menu_id'],
				'label' => $value['label'],
			);

            if( $value['menu_id'] )
				$item['href'] = '/' . $this->settings['id'] . '/' . $value['menu_id'];

            if( isset($value['icon']) )
				$item['icon'] = 'icon-datasets-' . $value['icon'];

            if( isset($value['class']) )
				$item['class'] = $value['class'];

			if( $mode == 'results' ) {


                $datasets = array();

                if( isset($item['href']) )
					$item['href'] .= '?q=' . urlencode( $this->request->query['q'] );

                if( @$value['forma_prawna_id'] ) {

                    if( @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] ) {
						foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {

                            if( $dataset['key']=='krs_podmioty' ) {

                                if( $value['forma_prawna_id']=='_all' ) {

                                    if( $dataset['doc_count'] );
										$items[] = $item;

                                } else {

                                    foreach( $dataset['forma_prawna']['buckets'] as $forma ) {
										if( $forma['doc_count'] ) {

                                            if( $value['forma_prawna_id']==$forma['key'] ) {

                                                $item['count'] = $forma['doc_count'];
												$items[] = $item;

                                            } elseif( ($value['forma_prawna_id']=='_other') && !in_array($forma['key'], array('1', '15', '18', '9')) ) {

                                                $others_count += $forma['doc_count'];

                                            }

                                        }
									}

                                    if( ($value['forma_prawna_id']=='_other') && $others_count ) {

                                        $item['count'] = $others_count;
										$items[] = $item;

                                    }

                                }

                            }
						}
					}

                } else {

                    if( @$this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] ) {
						foreach( $this->viewVars['dataBrowser']['aggs']['dataset']['buckets'] as $dataset ) {
							if( ($dataset['key'] == $key) && $dataset['doc_count'] ) {

                                $item['count'] = $dataset['doc_count'];
								$items[] = $item;

                            }
						}
					}

                }

			} else {

				$items[] = $item;

			}

		}

        foreach($items as $i => $item) {

            if(isset($item['submenu'])) {
                $items[$i]['submenu']['selected'] = $this->chapter_submenu_selected;
            }

            if(
                $i &&
                (@strpos($item['class'], 'border-top') !== false) &&
            	( @strpos($items[$i-1]['class'], '_label')!==false )
            )
	            $items[$i]['class'] = str_replace('border-top', '', $item['class']);

        }


        $output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}
		
	public function wskazniki_makroekonomiczne() {
		
		$this->title = 'Wskaźniki makroekonomiczne';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wskazniki_makroekonomiczne');
		
		if( $this->isCsv($tables) )
			return $this->response;
		
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function dochody_i_wydatki_sektora_finansow_publicznych() {
		
		$this->title = 'Dochody i wydatki sektora finansów publicznych';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('dochody_i_wydatki_sektora_finansow_publicznych');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function fundusze_celowe() {
		
		$this->title = 'Fundusze celowe';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('fundusze_celowe');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function dlug_publiczny() {
		
		$this->title = 'Dług publiczny';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('dlug_publiczny');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function dochody_ue() {
		
		$this->title = 'Dochody budżetu środków europejskich';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('dochody_ue');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function wydatki_ue() {
		
		$this->title = 'Wydatki budżetu środków europejskich';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wydatki_ue');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function wykonanie_fus() {
		
		$this->title = 'Wykonanie budżetu Funduszu Ubezpieczeń Społecznych';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wykonanie_fus');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function wykonanie_budzetu_panstwa() {
		
		$this->title = 'Wykonanie budżetu państwa';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wykonanie_budzetu_panstwa');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function dochody_budzetu_panstwa() {
		
		$this->title = 'Dochody budżetu państwa';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('dochody_budzetu_panstwa');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function wydatki_budzetu_panstwa_wedlug_dzialow() {
		
		$this->title = 'Wydatki budżetu państwa według działów';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wydatki_budzetu_panstwa_wedlug_dzialow');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function dotacje_i_subwencje_budzetu_panstwa() {
		
		$this->title = 'Dotacje i subwencje z budżetu państwa';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('dotacje_i_subwencje_budzetu_panstwa');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function wykonanie_fer_rolnikow() {
		
		$this->title = 'Wykonanie Funduszu Emerytalno-Rentowego';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wykonanie_fer_rolnikow');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function wykonanie_funduszu_pracy() {
		
		$this->title = 'Wykonanie Funduszu Pracy';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wykonanie_funduszu_pracy');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	public function wydatki_budzetu_panstwa_wedlug_czesci() {
		
		$this->title = 'Wydatki budżetu państwa według części';
		$this->set('subtitle', $this->title);

		$tables = $this->Finanse->getTables('wydatki_budzetu_panstwa_wedlug_czesci');
		
		if( $this->isCsv($tables) )
			return $this->response;
			
		$this->set('tables', $tables);
		$this->render('tables');
		
	}
	
	private function isCsv($tables) {
		
		$output = false;
		
		if(
			( $pathinfo = pathinfo( $this->request->here ) ) && 
			( @$pathinfo['extension'] == 'csv' )
		) {
			
			$this->response->body( $this->prepareCsvBody($tables, $this->request->params['year']) );
		    $this->response->type('csv');
		    $this->response->download( $this->request->params['action'] . '-' . $this->request->params['year'] . '.csv' );
		    $output = true;
		    
		}
		
		return $output;
		
	}
	
	private function prepareCsvBody($tables, $year) {
		
		$table = false;
		foreach( $tables as $t ) {
			if( $t['table']['name'] == $year ) {
				$table = $t;
				break;
			}
		}
		
		if( $table ) {
			
			// debug($table); die();
			return 'CSV CONTENT';
			
		} else return false;
					
	}
		
}
