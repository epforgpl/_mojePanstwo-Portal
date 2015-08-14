<?php

class GminaBudzet extends AppModel {

    public function getDzial($id, $gmina_id, $typ) {
        return array(
            'id' => '5',
            'nazwa' => 'Oświata i wychowanie',
            'wartosc' => '74600100000',
            'wydatki_min_gmina_id' => '1952',
            'wydatki_max_gmina_id' => '2226',
            'min' => '98712.3',
            'min_nazwa' => 'Stary Brus',
            'max' => '629632000',
            'max_nazwa' => 'Warszawa',
            'buckets' => array(
                (int) round(16),
                (int) round(16),
                (int) round(16),
                (int) round(16),
                (int) round(16),
                (int) round(16),
                (int) round(16),
                (int) round(16),
                (int) round(16),
                (int) round(16),
            ),
            'rodzialy' => array(
                array (
                    'id' => 1,
                    'nazwa' => 'Lorem ipsum',
                    'wartosc' => (int) round(12521552) + 125125
                ),
                array (
                    'id' => 2,
                    'nazwa' => 'Perspiciatis',
                    'wartosc' => (int) round(12521552) + 125125
                ),
                array (
                    'id' => 3,
                    'nazwa' => 'Nemo enim',
                    'wartosc' => (int) round(12521552) + 125125
                ),
                array (
                    'id' => 4,
                    'nazwa' => 'At vero eos et accusamus',
                    'wartosc' => (int) round(12521552) + 125125
                ),
                array (
                    'id' => 5,
                    'nazwa' => 'Temporibus autem quibusdam et aut',
                    'wartosc' => (int) round(12521552) + 125125
                ),
                array (
                    'id' => 6,
                    'nazwa' => 'Voluptatibus',
                    'wartosc' => (int) round(12521552) + 125125
                ),
            )
        );
    }

    public function getDzialy($gmina_id, $typ) {
        return array(
            array(
                'id' => '5',
                'nazwa' => 'Oświata i wychowanie',
                'wartosc' => '74600100000'
            ),
            array(
                'id' => '26',
                'nazwa' => 'Pomoc społeczna',
                'wartosc' => '29948800000'
            ),
            array(
                'id' => '17',
                'nazwa' => 'Transport i łączność',
                'wartosc' => '26817200000'
            ),
            array(
                'id' => '7',
                'nazwa' => 'Administracja publiczna',
                'wartosc' => '19243200000'
            ),
            array(
                'id' => '16',
                'nazwa' => 'Gospodarka komunalna i ochrona środowiska',
                'wartosc' => '16955700000'
            ),
        );
    }

}
