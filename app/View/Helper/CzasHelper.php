<?php

class CzasHelper extends AppHelper
{

    public $strings = array(
        'miesiace' => array(
            'celownik' => array(
                1 => 'stycznia',
                2 => 'lutego',
                3 => 'marca',
                4 => 'kwietnia',
                5 => 'maja',
                6 => 'czerwca',
                7 => 'lipca',
                8 => 'sierpnia',
                9 => 'września',
                10 => 'października',
                11 => 'listopada',
                12 => 'grudnia',
            ),
        ),
    );

    public function wiek($data)
    {
        return pl_dopelniacz(pl_wiek($data), 'rok', 'lata', 'lat');
    }

    public function dataSlownie($data, $options = array())
    {
        return dataSlownie($data, $options);
    }

}