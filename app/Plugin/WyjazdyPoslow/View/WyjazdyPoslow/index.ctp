<?php
$this->Combinator->add_libs('css', $this->Less->css('wyjazdy_poslow', array('plugin' => 'WyjazdyPoslow')));
$this->Combinator->add_libs('css', $this->Less->css('naglosnij', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/extras/map');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js', 'WyjazdyPoslow.wyjazdy_poslow.js');

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<style>
.appMenu {
  display: none;
}
#_wrapper #_main {
  margin: 0;
  background: #29292F;
}
#_wrapper #_main .baner {
  background-color: #4eafe1;
  margin: 15px 5px;
  display: block;
  height: 80px;
}
#_wrapper #_main .baner .inner {
  background: url(/WyjazdyPoslow/img/banerhead.png) 54px center no-repeat;
  height: 80px;
  position: relative;
  color: #ffffff;
}
#_wrapper #_main .baner .inner .text {
  position: relative;
  top: 50%;
  -webkit-transform: translate(0, -50%);
  -moz-transform: translate(0, -50%);
  -ms-transform: translate(0, -50%);
  -o-transform: translate(0, -50%);
  transform: translate(0, -50%);
}
#_wrapper #_main .baner .inner .text p {
  padding-left: 135px;
  padding-right: 35px;
  font-size: 18px;
  margin-bottom: 5px;
  line-height: 1em;
  font-weight: 300;
  color: #FFFFFF;
}
#_wrapper #_main .baner .inner .text p:first-of-type {
  font-weight: 400;
}
#_wrapper #_main .baner .inner i,
#_wrapper #_main .baner .inner > span {
  position: absolute;
  right: 30px;
  top: 50%;
  -webkit-transform: translate(0, -50%);
  -moz-transform: translate(0, -50%);
  -ms-transform: translate(0, -50%);
  -o-transform: translate(0, -50%);
  transform: translate(0, -50%);
}
#_wrapper #_main .containerHandler {
  background-color: #e9eaed;
  padding: 20px 0;
}
#_wrapper #_main .stats {
  margin: 10px 0;
}
#_wrapper #_main .stats .bigger {
  border-bottom: 1px solid #ddd;
  margin-bottom: 10px;
  padding-bottom: 0;
}
#_wrapper #_main .stats .bigger ._value {
  font-size: 18px;
  margin-top: 3px;
}
#_wrapper #_main .stats ._label {
  font-size: 13px;
  margin-bottom: 0;
}
#_wrapper #_main .stats ._value {
  font-size: 14px;
  color: green;
  font-weight: 400;
}
#_wrapper #_main .stats ._value strong {
  font-weight: 500;
}
#_wrapper #_main .maplabel {
  position: relative;
  padding: 10px 0 20px;
}
#_wrapper #_main .maplabel > p {
  color: #ddd;
  font-family: "Lato", Arial, sans-serif;
  font-weight: 300;
  text-align: center;
}
#_wrapper #_main .maplabel > .naglosnijHandler {
  position: absolute;
  right: 2%;
  top: 6px;
}
#_wrapper #_main #wyjazdyPoslowMap {
  position: relative;
  min-height: 500px;
  max-height: 80vh;
  display: block;
  margin-bottom: 30px;
}
#_wrapper #_main #wyjazdyPoslowMap .loading {
  width: 100%;
  min-height: 500px;
  max-height: 80vh;
  background: url(/img/loader/search-loading.png) no-repeat center center;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfoBackground {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 2;
  background-color: rgba(0, 0, 0, 0.75);
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo {
  width: 90vw;
  max-width: 960px;
  position: fixed;
  top: 50%;
  left: 50%;
  z-index: 9000;
  border: 1px solid #7cb5ec;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  background-color: #f9f9f9;
  font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;
  font-size: 12px;
  color: #333333;
  -webkit-transform: translate(-50%, -46%);
  -moz-transform: translate(-50%, -46%);
  -ms-transform: translate(-50%, -46%);
  -o-transform: translate(-50%, -46%);
  transform: translate(-50%, -46%);
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .detailInfoClose {
  position: absolute;
  top: -12px;
  right: -12px;
  width: 26px;
  height: 26px;
  padding: 5px 0;
  cursor: pointer;
  border: 1px solid #7cb5ec;
  border-bottom-width: 0;
  border-left-width: 0;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  background-color: #f9f9f9;
  text-align: center;
  font-size: 14px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .detail-header {
  background-color: #157ab5;
  color: #FFF;
  margin-top: -8px;
  margin-bottom: 8px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content {
  height: auto;
  max-height: 85vh;
  overflow-x: hidden;
  overflow-y: auto;
  padding: 8px 0;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content > div {
  padding: 5px 12px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content.loading {
  min-height: 150px;
  display: block;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content .kraj,
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content .ilosc,
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content .koszt {
  font-size: 14px;
  padding-top: 5px;
  padding-bottom: 5px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content .koszt {
  text-align: right;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content .miasto,
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content .nazwa {
  padding-bottom: 5px;
  line-height: 14px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content .delegacja {
  font-size: 15px;
  margin: 10px 0 5px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content table {
  font-size: 10px;
  padding-bottom: 16px;
  background-color: #FFF;
  border-radius: 5px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content table td {
  padding: 5px;
}
#_wrapper #_main #wyjazdyPoslowMap .detailInfo .content table thead > td {
  color: #999;
  font-size: 9px;
}
#_wrapper #_main .block h3 {
  margin: 0 0 5px;
  padding: 0;
}
#_wrapper #_main .block ul li {
  border-bottom: 1px solid #ddd;
  margin: 0 10px;
  padding: 10px 0;
}
#_wrapper #_main .block ul li:last-child {
  border-bottom: none;
}
#_wrapper #_main .block ul li img.border {
  border: 1px solid #DDD;
}
#_wrapper #_main .block ul li .title {
  font-size: 16px;
  padding: 0;
  margin: 0;
}
#_wrapper #_main .block ul li .title .klub {
  font-size: 12px;
  color: #999;
}
#_wrapper #_main .block ul li .loc {
  font-weight: 500;
  font-size: 12px;
}
#_wrapper #_main .block ul li .desc {
  padding: 0;
  margin: 5px 0 0;
  font-size: 12px;
  color: green;
}
#_wrapper #_main .block ul li .desc ._number,
#_wrapper #_main .block ul li .desc ._currency {
  font-weight: 500;
  color: green;
  font-size: 13px;
}
#_wrapper #_main .block ul li .desc-loc-cont {
  margin-top: 5px;
  overflow: auto;
}
#_wrapper #_main .block ul li .desc-loc-cont .desc {
  margin: 0;
  padding: 0;
}
#_wrapper #_main .block ul li .desc-loc-cont .loc {
  margin: 2px 0 0;
  padding: 0;
}
#_wrapper #_main .block .klubyTitle img {
  float: left;
  width: 30px;
  -webkit-transform: translate(0px, -25%);
  -moz-transform: translate(0px, -25%);
  -ms-transform: translate(0px, -25%);
  -o-transform: translate(0px, -25%);
  transform: translate(0px, -25%);
}
#_wrapper #_main .block .klubyTitle span {
  display: block;
  margin-left: 35px;
  font-size: 13px;
}
#_wrapper #_main ul.controversy {
  list-style: none;
  padding: 0;
}
#_wrapper #_main ul.controversy li {
  list-style: outside none none;
  margin: 15px 0;
  padding: 5px 0 25px;
  border-bottom: 1px solid #DDD;
}
#_wrapper #_main ul.controversy li:last-child {
  border-bottom: none;
}
#_wrapper #_main ul.controversy li .poslowie {
  margin: 0;
  padding: 0;
  background-color: #FCFCFC;
  border-radius: 5px;
}
#_wrapper #_main ul.controversy li .poslowie li {
  padding: 5px;
  margin: 5px;
  min-height: 33px;
  border-bottom: 1px solid #EEE;
}
#_wrapper #_main ul.controversy li .poslowie li:last-child {
  border-bottom: none;
}
#_wrapper #_main ul.controversy li .poslowie li span.label {
  margin: 0 3px 3px 0;
  float: left;
}
#_wrapper #_main ul.controversy li p {
  margin: 0;
  padding: 0;
}
#_wrapper #_main ul.controversy li p.event {
  font-weight: 500;
  font-size: 14px;
  margin-top: 15px;
  margin-bottom: 2px;
  margin-left: 8px;
}
#_wrapper #_main ul.controversy li p.dates {
  margin-left: 8px;
}
#_wrapper #_main ul.controversy li p.dates .label {
  padding: 2px 6px;
}
#_wrapper #_main ul.controversy li .title {
  margin-left: 5px;
  font-size: 15px;
}
#_wrapper #_main ul.controversy li .w_title {
  font-size: 18px;
}
#_wrapper #_main ul.controversy li ._currency {
  font-size: 12px;
}
#_wrapper #_main ul.controversy li .loc {
  overflow: auto;
}
#_wrapper #_main ul.controversy li .desc {
  font-size: 12px;
  padding: 5px 5px 10px;
  color: green;
}
#_wrapper #_main ul.controversy li .licza_dni {
  color: green;
  position: relative;
  top: 1px;
}
#_wrapper #_main ul.controversy li .licza_dni strong {
  font-weight: 500;
}
#_wrapper #_main ul.controversy li .klub {
  color: #999;
  font-size: 10px;
  font-weight: 600;
}
#_wrapper #_main ul.controversy li .klub a {
  color: #777;
}
#_wrapper #_main ul.controversy li .klub a:hover {
  color: #157ab5;
}
</style>

<div class="maplabel">
    <p>Kliknij na podświetlone Państwo, aby poznać szczegóły wyjazdów.</p>
</div>

<div id="wyjazdyPoslowMap">
    <div class="loading"></div>
</div>

<div class="containerHandler">
    <div class="container">

        <div class="stats text-center">

            <div class="bigger">
                <p class="_label">Na podróże w VIII Kadencji Sejmu, wydaliśmy:</p>

                <p class="_value"><?= $this->Waluta->slownie($stats['koszta']['calosc']) ?></p>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <p class="_label">Na transport</p>

                    <p class="_value"><?= $this->Waluta->slownie($stats['koszta']['transport']) ?></p>
                </div>
                <div class="col-md-3">
                    <p class="_label">Na hotele</p>

                    <p class="_value"><?= $this->Waluta->slownie($stats['koszta']['hotele']) ?></p>
                </div>
                <div class="col-md-3">
                    <p class="_label">Na diety</p>

                    <p class="_value"><?= $this->Waluta->slownie($stats['koszta']['diety']) ?></p>
                </div>
                <div class="col-md-3">
                    <p class="_label">Pozostałe koszty</p>

                    <p class="_value"><?= $this->Waluta->slownie($stats['koszta']['pozostale']) ?></p>
                </div>
            </div>

        </div>

        <div class="block col-xs-12">

            <header>Najwięcej na podróże wydali</header>

            <section class="content">
                <div class="col-md-5">

                    <h3>Indywidualnie</h3>

                    <ul>
                        <? foreach ($stats['calosc']['indywidualne'] as $i) { ?>
                            <li class="row">
                                <div class="col-md-2 text-right">
                                    <img class="border" onerror="imgFixer(this)"
                                         src="http://resources.sejmometr.pl/mowcy/a/2/<?= $i['mowca_id'] ?>.jpg"/>
                                </div>
                                <div class="col-md-10">
                                    <p class="title"><a onclick="return false;"
                                            href="/dane/poslowie/<?= $i['id'] ?>/wyjazdy"><?= $i['nazwa'] ?></a>
                                    <span class="klub">(<a
                                            href="/dane/sejm_kluby/<?= $i['klub_id'] ?>"><?= $i['skrot'] ?></a>)</span>
                                    </p>

                                    <p class="desc"><?= pl_dopelniacz($i['count'], 'wyjazd', 'wyjazdy', 'wyjazdów') ?>
                                        na
                                        kwotę <?= _currency($i['sum']) ?></p>
                                </div>
                            </li>
                        <? } ?>
                    </ul>

                    <p class="text-center"><a onclick="return false;" class="btn btn-sm btn-primary"
                                              href="/dane/poslowie?order=wartosc_wyjazdow desc">Zobacz
                            pełny ranking</a></p>

                </div>
                <div class="col-md-7">

                    <h3>Średnio na posła, według klubów</h3>

                    <?php
                    $klubowoChartData = array();
                    foreach ($stats['calosc']['klubowe'] as $i) {
                        array_push($klubowoChartData, array(
                            "name" => $i['skrot'],
                            "fullname" => $i['nazwa'],
                            "link" => "/dane/sejm_kluby/" . $i['id'],
                            "image" => ($i['id'] != 8) ? "http://resources.sejmometr.pl/s_kluby/" . $i['id'] . "_s_t.png" : '',
                            "ilosc" => (int)$i['count'],
                            "y" => (int)($i['avg']),
                            "avg" => _currency(round($i['avg'], 2)),
                            "sum" => _currency($i['sum'])
                        ));
                    }; ?>
                    <div class="pieChartKlubowo"
                         style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"
                         data-kluby='<?php echo htmlspecialchars(json_encode($klubowoChartData), ENT_QUOTES, 'UTF-8') ?>'></div>

                </div>
            </section>
        </div>

        <div class="block col-xs-12">

            <header>Najdroższe wyjazdy</header>

            <section class="content">
                <div class="col-md-6">
                    <h3>Całościowo</h3>

                    <ul>
                        <? foreach ($stats['najdrozsze']['calosc'] as $i) { ?>
                            <li class="row">

                                <div class="col-md-12">
                                    <p class="title">
                                        <a onclick="return false;" href="/dane/poslowie_wyjazdy_wydarzenia/<?= $i['id'] ?>"><?= $i['delegacja'] ?></a>
                                    </p>

                                    <p class="loc">
                                        <?= $i['lokalizacja'] ?>
                                    </p>

                                    <p class="desc"><?= _currency($i['koszt']) ?> <span
                                            class="separator">|</span> <?= pl_dopelniacz($i['liczba_dni'], 'dzień', 'dni', 'dni') ?>
                                        <span
                                            class="separator">|</span> <?= pl_dopelniacz($i['liczba_poslow'], 'posel', 'posłów', 'posłów') ?>
                                    </p>
                                </div>
                            </li>
                        <? } ?>

                    </ul>

                    <p class="text-center">
                        <a class="btn btn-sm btn-primary" onclick="return false;"
                           href="/dane/poslowie_wyjazdy_wydarzenia?order=wartosc_koszt desc">Zobacz pełny
                            ranking</a>
                    </p>
                </div>

                <div class="col-md-6">
                    <h3>Indywidualnie</h3>

                    <ul>
                        <? foreach ($stats['najdrozsze']['indywidualnie'] as $i) { ?>
                            <li class="row">
                                <div class="col-md-2 text-right">
                                    <img class="border" onerror="imgFixer(this)"
                                         src="http://resources.sejmometr.pl/mowcy/a/2/<?= $i['mowca_id'] ?>.jpg"/>
                                </div>
                                <div class="col-md-10">
                                    <p class="title"><a onclick="return false;"
                                            href="/dane/poslowie/<?= $i['id'] ?>/wyjazdy"><?= $i['nazwa'] ?></a>
                                    <span class="klub">(<a onclick="return false;"
                                            href="/dane/sejm_kluby/<?= $i['klub_id'] ?>"><?= $i['skrot'] ?></a>)</span>
                                    </p>

                                    <div class="desc-loc-cont">
                                        <p class="desc pull-left"><?= _currency($i['koszt']) ?></p>

                                        <p class="loc pull-right"><?= $i['lokalizacja'] ?></p>
                                    </div>
                                </div>
                            </li>
                        <? } ?>
                    </ul>

                    <p class="text-center">
                        <a onclick="return false;" class="btn btn-sm btn-primary" href="/dane/poslowie_wyjazdy?order=wartosc_koszt desc">Zobacz
                            pełny ranking</a>
                    </p>
                </div>
            </section>
        </div>
		
		<? /*
        <div class="block col-xs-12">
            <header>Wyjazdy posłów, a prace w Sejmie</header>

            <section class="content">
                <div class=" col-xs-12">
                    <p>Poniżej prezentujemy daty zagranicznych wydarzeń, w których brali udział posłowie pokrywające się
                        z
                        datami
                        głosowań, na których ci sami posłowie byli obecni w Sejmie.</p>

                    <p>Zestawienie tych danych nie jest równoznaczne z nieobecnością posłów w delegacjach. Jak
                        poinformowała
                        Kancelaria Sejmu niektórzy z posłów skracali swój pobyt w czasie dłuższych delegacji ze względu
                        na
                        obowiązek
                        wzięcia udziału w głosowaniach w Polsce.</p>
                </div>
            </section>
        </div>

        <div class="col-xs-12">
            <ul class="controversy row">
                <? foreach ($stats['wydarzenia'] as $w) { ?>
                    <li>
                        <div class="loc">
                            <p class="w_title pull-left">
                                <a href="/dane/poslowie_wyjazdy_wydarzenia/<?= $w['data']['id'] ?>"><?= $w['data']['delegacja'] ?></a>
                            </p>

                            <p class="pull-right">
                                    <span
                                        class="licza_dni"><?= pl_dopelniacz($w['data']['liczba_dni'], 'dzień', 'dni', 'dni') ?></span>
                                    <span class="label label-warning"><?= $w['data']['date_start'] ?>
                                        - <?= $w['data']['date_stop'] ?></span>
                            </p>
                        </div>

                        <p class="desc"><?= $w['data']['lokalizacja'] ?></p>

                        <ul class="poslowie">
                            <li class="row">
                                <p class="col-sm-4">Poseł</p>

                                <p class="col-sm-2">Transport</p>

                                <p class="col-sm-2">Hotel</p>

                                <p class="col-sm-2">Dieta</p>

                                <p class="col-sm-2">Aktywności w Sejmie</p>
                            </li>

                            <? foreach ($w['poslowie'] as $p) { ?>
                                <li class="row">
                                    <p class="col-sm-4">
                                        <img class="border" onerror="imgFixer(this)"
                                             src="http://resources.sejmometr.pl/mowcy/a/3/<?= $p['mowca_id'] ?>.jpg"/>
                                        <a class="title"
                                           href="/dane/poslowie/<?= $p['id'] ?>/wyjazdy"><?= $p['nazwa'] ?>
                                        </a> <span class="klub"><a
                                                href="/dane/sejm_kluby/<?= $p['klub_id'] ?>"><?= $p['klub_skrot'] ?></a>
                                            </span>
                                    </p>

                                    <p class="col-sm-3 col-md-2">
                                        <?= _currency($p['koszt_transport']) ?>
                                    </p>

                                    <p class="col-sm-3 col-md-2">
                                        <?= _currency($p['koszt_hotel']) ?>
                                    </p>

                                    <p class="col-sm-3 col-md-2">
                                        <?= _currency($p['koszt_dieta']) ?>
                                    </p>

                                    <p class="col-sm-3 col-md-2 text-right">
                                            <span
                                                class="label label-danger"><?= implode('</span> <span class="label label-danger">', $p['glosowania_dni']) ?></span>
                                    </p>
                                </li>
                            <? } ?>
                        </ul>
                    </li>
                <? } ?>
            </ul>
        </div>
        */ ?>
        
    </div>
</div>
