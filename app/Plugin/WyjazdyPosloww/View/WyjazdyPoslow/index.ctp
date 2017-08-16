<?php
$this->Combinator->add_libs('css', $this->Less->css('wyjazdy_poslow', array('plugin' => 'WyjazdyPosloww')));
$this->Combinator->add_libs('css', $this->Less->css('naglosnij', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/extras/map');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js', 'WyjazdyPosloww.wyjazdy_poslow.js');

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

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
                <p class="_label">Na podróże posłów w VII Kadencji Sejmu, wydaliśmy:</p>

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
