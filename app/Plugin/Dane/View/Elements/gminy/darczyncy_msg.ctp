<?php

$pl_gminy_krakow_darczyncy_komitety_roczniki = array(
    array('komitet_id' => '1','rocznik' => '2014','tresc' => '50 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 1680 PLN (płaca minimalna 2014) od osoby na łączną kwotę 31787,37 PLN'),
    array('komitet_id' => '2','rocznik' => '2010','tresc' => '298 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 1317 PLN (płaca minimalna 2010) od osoby na łączną kwotę 42869,05 PLN. Oprócz tego zanotowano 3 wpłaty od firm (niedozwolone) na łączną kwotę 200 PLN.'),
    array('komitet_id' => '3','rocznik' => '2006','tresc' => '15 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 899,1 PLN (płaca minimalna 2006) od osoby na łączną kwotę 6245 PLN'),
    array('komitet_id' => '4','rocznik' => '2006','tresc' => '5 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 899,1 PLN (płaca minimalna 2006) od osoby na łączną kwotę 2484,40 PLN'),
    array('komitet_id' => '5','rocznik' => '2014','tresc' => '238 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 1680 PLN (płaca minimalna 2014) od osoby na łączną kwotę 39555,87 PLN'),
    array('komitet_id' => '6','rocznik' => '2014','tresc' => '125 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 1680 PLN (płaca minimalna 2014) od osoby na łączną kwotę 15986 PLN'),
    array('komitet_id' => '8','rocznik' => '2014','tresc' => '4 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 1680 PLN (płaca minimalna 2014) od osoby na łączną kwotę 2871,4 PLN'),
    array('komitet_id' => '9','rocznik' => '2010','tresc' => '14 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 1317 PLN (płaca minimalna 2010) od osoby na łączną kwotę 4927 PLN'),
    array('komitet_id' => '14','rocznik' => '2010','tresc' => '15 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 1317 PLN (płaca minimalna 2010) od osoby na łączną kwotę 7179 PLN'),
    array('komitet_id' => '15','rocznik' => '2006','tresc' => '4 darczyńców wpłaciło darowizny w kwotach sumujących się na mniej niż 899,1 PLN (płaca minimalna 2006) od osoby na łączną kwotę 1150 PLN')
);

if(isset($this->request->query['conditions']['krakow_darczyncy.komitet_id'])) {
    foreach($pl_gminy_krakow_darczyncy_komitety_roczniki as $row) {
        if($row['komitet_id'] == $this->request->query['conditions']['krakow_darczyncy.komitet_id']) { ?>
            <div class="alert alert-info"><?= $row['tresc'] ?></div>
        <? }
    }
}

?>