<?php

App::uses('AppController', 'Controller');

class GminyController extends AppController {

    public $uses = array(
        'Finanse.Finanse'
    );

    public $components = array('RequestHandler');

    private static $rangeTypes = array('q');
    private static $rangeDefaultYear = 2014;
    private static $rangeQuery = 'zakres';

    private static $populationRanges = array(
        array(0, 20000),
        array(20000, 50000),
        array(50000, 100000),
        array(100000, 500000),
        array(500000, 9999999)
    );

    public function dzial($id, $gmina_id, $typ) {
        $count = $this->Finanse->getCommunePopCount($gmina_id);
        $popRange = $this->getPopRange($count);
        $range = $this->getRange();

        $this->loadModel('Dane.Dataobject');
        $this->Dataobject->find('all', array(
            'limit' => 0,
            'aggs' => array(
                'gmina' => array(
                    'filter' => array(
                        'term' => array(
                            'id' => $gmina_id,
                        ),
                    ),
                    'aggs' => array(
                        'wydatki' => array(
                            'nested' => array(
                                'path' => 'gminy-wydatki',
                            ),
                            'aggs' => array(
                                'dzial' => array(
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'gminy-wydatki.rok' => $range['year'],
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'gminy-wydatki.kwartal' => $range['quarter'],
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'gminy-wydatki.dzial_id' => $id,
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'aggs' => array(
                                        'rozdzialy' => array(
                                            'terms' => array(
                                                'field' => 'gminy-wydatki.rozdzial_id',
                                                'size' => 100,
                                            ),
                                            'aggs' => array(
                                                'nazwa' => array(
                                                    'terms' => array(
                                                        'field' => 'gminy-wydatki.rozdzial',
                                                        'size' => 1,
                                                    ),
                                                ),
                                                'wydatki' => array(
                                                    'sum' => array(
                                                        'field' => 'gminy-wydatki.wydatki',
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
                'gminy' => array(
                    'filter' => array(
                        'range' => array(
                            'data.gminy.liczba_ludnosci' => array(
                                'gte' => $popRange['min'],
                                'lt' => $popRange['max']
                            ),
                        ),
                    ),
                    'scope' => 'global',
                    'aggs' => array(
                        'wydatki' => array(
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
                                                        'gminy-wydatki-dzialy.rok' => $range['year'],
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'gminy-wydatki-dzialy.kwartal' => $range['quarter'],
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'gminy-wydatki-dzialy.id' => $id,
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'aggs' => array(
                                        'min' => array(
                                            'terms' => array(
                                                'field' => 'gminy-wydatki-dzialy.wydatki',
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
                                                'field' => 'gminy-wydatki-dzialy.wydatki',
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
                                        'histogram' => array(
                                            'histogram' => array(
                                                'field' => 'gminy-wydatki-dzialy.wydatki',
                                                'interval' => 10000,
                                            ),
                                            'aggs' => array(
                                                'reverse' => array(
                                                    'reverse_nested' => '_empty',
                                                    'aggs' => array(

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
            'conditions' => array(
                'dataset' => 'gminy',
            ),
        ));

        $aggs = $this->Dataobject->getAggs();

        $dzial = array(
            'wydatki_min_gmina_id' => 0,
            'min' => 0,
            'min_nazwa' => 0,
            'wydatki_max_gmina_id' => 0,
            'max' => 0,
            'max_nazwa' => 0,
            'rozdzialy' => array(),
            'buckets' => array()
        );

        if(isset($aggs['gmina']['wydatki']['dzial']['rozdzialy']['buckets'])) {
            foreach($aggs['gmina']['wydatki']['dzial']['rozdzialy']['buckets'] as $bucket) {
                $dzial['rozdzialy'][] = array(
                    'id' => @$bucket['key'],
                    'nazwa' => @$bucket['nazwa']['buckets'][0]['key'],
                    'wartosc' => @$bucket['wydatki']['value'],
                );
            }
        }

        if($m = @$aggs['gminy']['wydatki']['timerange']['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['fields']['source'][0]['data']) {
            $dzial['wydatki_min_gmina_id'] = $m['gminy.id'];
            $dzial['min'] = @$aggs['gminy']['wydatki']['timerange']['min']['buckets'][0]['key'];
            $dzial['min_nazwa'] = $m['gminy.nazwa'];
        }

        if($m = @$aggs['gminy']['wydatki']['timerange']['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['fields']['source'][0]['data']) {
            $dzial['wydatki_max_gmina_id'] = $m['gminy.id'];
            $dzial['max'] = @$aggs['gminy']['wydatki']['timerange']['max']['buckets'][0]['key'];
            $dzial['max_nazwa'] = $m['gminy.nazwa'];
        }

        $dzial['buckets'] = @$aggs['gminy']['wydatki']['timerange']['histogram']['buckets'];

        $this->set(array(
            'dzial' => $dzial,
            '_serialize' => array('dzial'),
        ));
    }

    private function getPopRange($count) {
        $min = 0; $max = 0; $count = (int) $count;
        foreach(self::$populationRanges as $range) {
            if($count >= $range[0] && $count <= $range[1]) {
                $min = $range[0];
                $max = $range[1];
                break;
            }
        }

        return array(
            'min' => $min,
            'max' => $max
        );
    }

    private function getRange() {
        $quarter = 0;
        $year = self::$rangeDefaultYear;

        if(isset($this->request->query[self::$rangeQuery])) {
            $range = $this->request->query[self::$rangeQuery];
            if (strlen($range) == 4 && is_numeric($range)) {
                $year = (int) $range;
            } elseif (strlen($range) == 6) {
                $year = (int) substr($range, 0, 4);
                $type = strtolower(substr($range, 4, 1));

                if (in_array($type, self::$rangeTypes)) {
                    $num = (int) substr($range, 5, 1);
                    if ($num > 0 && $num < 5)
                        $quarter = $num;
                }
            }
        }

        return array(
            'year' => $year,
            'quarter' => $quarter
        );
    }

}

