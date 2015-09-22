<?php

App::uses('Component', 'Controller');

class TwitterComponent extends Component {

    public $twitterAccountTypes = array(
        '0' => 'Wszystkie obserwowane',
        '2' => 'Komentatorzy',
        '3' => 'Urzędy',
        // '6' => 'Media',
        '7' => 'Politycy i urzędnicy',
        '8' => 'Partie',
        '9' => 'NGO i akcje społeczne',
        '10' => 'Miasta',
    );

    public $twitterTimeranges = array(
        '1D' => 'Ostatnia doba',
        '1W' => 'Tydzień',
        '1M' => 'Miesiąc',
        '1Y' => 'Rok',
    );

    public $dateUnitsMapES = array(
        'D' => 'd',
        'W' => 'w',
        'Y' => 'y',
    );

    public $dateUnitsMapPHP = array(
        'D' => 'day',
        'W' => 'week',
        'M' => 'month',
        'Y' => 'year',
    );

    public $histogramMarginsMap = array(
        'D' => 26,
        'W' => 13,
        'M' => 5,
        'Y' => 3,
    );

    public function getDropdownRanges() {
        $ranges = array(
            array(
                'title' => 'Raporty miesięczne',
                'ranges' => array()
            ),
            array(
                'title' => 'Raporty roczne',
                'ranges' => array()
            )
        );

        $months = __months();
        list($y, $n) = explode(' ', date('Y n'));

        for($m = 2; $m <= 4; $m++) {
            $data = explode(' ', date('Y m n', mktime(0, 0, 0, $n- $m, 1, $y)));
            $ranges[0]['ranges'][] = array(
                'param' => $data[0] . '-' . $data[1],
                'label' => $months[$data[2]-1] . ' ' . $data[0]
            );
        }

        for($m = 0; $m < 3; $m++) {
            $year = ($y - $m - 1);
            $ranges[1]['ranges'][] = array(
                'param' => $year,
                'label' => $year
            );
        }

        return $ranges;
    }

    public function getLastMonthReport() {
        list($y, $n) = explode(' ', date('Y n'));
        $n--;

        $data = explode(' ', date('Y m n', mktime(0, 0, 0, $n, 1, $y)));
        $months = __months();
        return array(
            'param' => $data[0] . '-' . $data[1],
            'label' => $months[$data[2]-1] . ' ' . $data[0],
        );
    }

    public function getTimerange($twitterTimerange) {
        if( preg_match('/^([0-9]+)(D|W|M|Y)$/', $twitterTimerange, $match) ) {

            $ts = time();
            $value = (int) $match[1];

            $unit = array_key_exists($match[2], $this->dateUnitsMapES) ?
                $this->dateUnitsMapES[ $match[2] ] :
                $match[2];

            $timerange = array(
                'target_filter' => array(
                    'gte' => 'now-' . $value . $unit,
                ),
                'histogram_filter' => array(
                    'gte' => 'now-' . ($this->histogramMarginsMap[$match[2]] * $value) . $unit,
                ),
                'range' => array(
                    'min' => strtotime('-' . $value . $this->dateUnitsMapPHP[ $match[2] ]),
                    'max' => $ts,
                ),
                'labels' => array(
                    'min' =>  date('Y-m-d H:i', strtotime('-' . $value . $this->dateUnitsMapPHP[ $match[2] ])),
                    'max' =>  date('Y-m-d H:i', $ts),
                ),
                'xmax' => $ts * 1000,
            );

        } elseif( preg_match('/^([0-9]{4})\-([0-9]{2})$/', $twitterTimerange, $match) ) {

            $month = (int) $match[2];
            $min = mktime(0, 0, 0, $month, 1, $match[1]);
            $max = mktime(0, 0, 0, $month+1, 0, $match[1]);

            $timerange = array(
                'target_filter' => array(
                    'gte' => date('Y-m-d', $min),
                    'lte' => date('Y-m-d', $max),
                ),
                'histogram_filter' => array(
                    'gte' => date('Y-m-d', mktime(0, 0, 0, $month, -49, $match[1])),
                    'lte' => date('Y-m-d', mktime(0, 0, 0, $month+1, 50, $match[1])),
                ),
                'range' => array(
                    'min' => $min,
                    'max' => $max,
                ),
                'labels' => array(
                    'min' => date('Y-m-d', $min),
                    'max' => date('Y-m-d', $max),
                ),
            );

        } elseif(preg_match('/^([0-9]{4})$/', $twitterTimerange, $match)) {

            $year = (int) $match[0];
            $min = mktime(0, 0, 0, 1, 1, $year);
            $max = mktime(0, 0, 0, 12, 31, $year);

            $timerange = array(
                'target_filter' => array(
                    'gte' => date('Y-m-d', $min),
                    'lte' => date('Y-m-d', $max),
                ),
                'histogram_filter' => array(
                    'gte' => date('Y-m-d', mktime(0, 0, 0, 1, -49, $year)),
                    'lte' => date('Y-m-d', mktime(0, 0, 0, 12, 50, $year)),
                ),
                'range' => array(
                    'min' => $min,
                    'max' => $max,
                ),
                'labels' => array(
                    'min' => date('Y-m-d', $min),
                    'max' => date('Y-m-d', $max),
                ),
            );

        } elseif( preg_match('/^\[([0-9]{4})-([0-9]{2})-([0-9]{2}) TO ([0-9]{4})-([0-9]{2})-([0-9]{2})\]$/i', $twitterTimerange, $match) ) {

            $min = mktime(0, 0, 0, $match[2], $match[3], $match[1]);
            $max = mktime(0, 0, 0, $match[5], $match[6], $match[4]);

            $timerange = array(
                'target_filter' => array(
                    'gte' => date('Y-m-d', $min),
                    'lte' => date('Y-m-d', $max),
                ),
                'histogram_filter' => array(
                    'gte' => date('Y-m-d', mktime(0, 0, 0, $match[2], $match[3]-49, $match[1])),
                    'lte' => date('Y-m-d', mktime(0, 0, 0, $match[5], $match[6]+50, $match[4])),
                ),
                'range' => array(
                    'min' => $min,
                    'max' => $max,
                ),
                'labels' => array(
                    'min' => date('Y-m-d', $min),
                    'max' => date('Y-m-d', $max),
                ),
            );

        }

        return isset($timerange) ? $timerange : false;
    }

}
