<?
$this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/themes/dark-unica');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Finanse.budzety');
// $this->Combinator->add_libs('js', 'Finanse.budzety-tiles');

$dane = $dataBrowser['aggs']['budzety']['top']['hits']['hits'];


$rok1 = array();
$rok2 = array();
$lata = array();
foreach ($dane as $rocznik) {
    if ($rocznik['fields']['source'][0]['data']['budzety.rok'] == $p1) {
        $rok1['premier_id'] = $rocznik['fields']['source'][0]['data']['budzety.premier_czlowiek_id'];
        $rok1['premier'] = $rocznik['fields']['source'][0]['data']['budzety.premier_nazwa'];
        $rok1['bezrobocie'] = $rocznik['fields']['source'][0]['data']['budzety.bezrobocie'];
        $rok1['inflacja'] = $rocznik['fields']['source'][0]['data']['budzety.inflacja'];
        $rok1['pkb'] = $rocznik['fields']['source'][0]['data']['budzety.pkb'];
        $rok1['pkb_per_capita'] = $rocznik['fields']['source'][0]['data']['budzety.pkb_per_capita'];
        $rok1['dlug_publiczny'] = $rocznik['fields']['source'][0]['data']['budzety.dlug_publiczny']*1000*1000;
        $rok1['eur'] = $rocznik['fields']['source'][0]['data']['budzety.eur'];
        $rok1['usd'] = $rocznik['fields']['source'][0]['data']['budzety.usd'];
        $rok1['dem'] = $rocznik['fields']['source'][0]['data']['budzety.dem'];
        $rok1['wydatki'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_wydatki']*1000;
        $rok1['dochody'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_dochody']*1000;
        $rok1['deficyt'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_deficyt']*1000;
    }
    if ($rocznik['fields']['source'][0]['data']['budzety.rok'] == $p2) {
        $rok2['premier_id'] = $rocznik['fields']['source'][0]['data']['budzety.premier_czlowiek_id'];
        $rok2['premier'] = $rocznik['fields']['source'][0]['data']['budzety.premier_nazwa'];
        $rok2['bezrobocie'] = $rocznik['fields']['source'][0]['data']['budzety.bezrobocie'];
        $rok2['inflacja'] = $rocznik['fields']['source'][0]['data']['budzety.inflacja'];
        $rok2['pkb'] = $rocznik['fields']['source'][0]['data']['budzety.pkb'];
        $rok2['pkb_per_capita'] = $rocznik['fields']['source'][0]['data']['budzety.pkb_per_capita'];
        $rok2['dlug_publiczny'] = $rocznik['fields']['source'][0]['data']['budzety.dlug_publiczny']*1000*1000;
        $rok2['eur'] = $rocznik['fields']['source'][0]['data']['budzety.eur'];
        $rok2['usd'] = $rocznik['fields']['source'][0]['data']['budzety.usd'];
        $rok2['dem'] = $rocznik['fields']['source'][0]['data']['budzety.dem'];
        $rok2['wydatki'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_wydatki']*1000;
        $rok2['dochody'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_dochody']*1000;
        $rok2['deficyt'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_deficyt']*1000;
    }
    if ($rocznik['fields']['source'][0]['data']['budzety.rok'] != 1989) {
        $lata[] = $rocznik['fields']['source'][0]['data']['budzety.rok'];
    }
}
sort($lata);
$zmiana_wydatki = $rok1['wydatki'] / $rok2['wydatki'];
$zmiana_dochody = $rok2['dochody'] / $rok1['dochody'];
?>

<div class="col-xs-12">
    <div class="appBanner">
        <h1 class="appTitle">Finanse publiczne</h1>

        <p class="appSubtitle">Poznaj stan finansów publicznych Polski.</p>
    </div>
</div>
</div>
</div>
<div class="col-xs-12 finanseBlock">

    <div class="chart"
         data-json='<?php echo json_encode($dane); ?>'></div>

    <div class="mid-chart"></div>
    <div class="chart2"></div>

</div>
<div class="container">
    <div class="row dataBrowserContent">

        <div id="compare" class="col-xs-12">

            <div class="appBanner">
                <p class="appSubtitle">Porównaj stan finansów publicznych w wybranych latach.</p>
            </div>


            <div class="row head">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-4">
                    <h2>Rok <?= $p1 ?></h2>

                    <p class="rok1"><span class="btn btn-link">Wybierz inny rocznik</span></p>

                    <div class="dropdown rok1_dropdown hidden">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Wybierz rocznik
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <? foreach ($lata as $rok) { ?>
                                <li><a href="/finanse/<?= $rok ?>-<?= $p2 ?>"><?= $rok ?></a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <h2>Rok <?= $p2 ?></h2>

                    <p class="rok2"><span class="btn btn-link">Wybierz inny rocznik</span></p>

                    <div class="dropdown rok2_dropdown hidden">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Wybierz rocznik
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <? foreach ($lata as $rok) { ?>
                                <li><a href="/finanse/<?= $rok ?>-<?= $p2 ?>"><?= $rok ?></a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Premier w chwili uchwalania budżetu:</h3>
                </div>
                <div class="col-sm-4">

                    <img alt="" src="//resources.sejmometr.pl/mowcy/a/1/<?= $rok1['premier_id'] ?>.jpg">

                    <p><?= $rok1['premier'] ?></p>
                </div>
                <div class="col-sm-4">

                    <img alt="" src="//resources.sejmometr.pl/mowcy/a/1/<?= $rok2['premier_id'] ?>.jpg">

                    <p><?= $rok2['premier'] ?></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Zadłużenie na koniec roku:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['dlug_publiczny'] == 0) {
                            echo "b.d.";
                        } else {
                            echo number_format_h($rok1['dlug_publiczny']) . " zł";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['dlug_publiczny'] == 0) {
                            echo "b.d.";
                        } else {
                            echo number_format_h($rok2['dlug_publiczny']) . " zł";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><? if (($rok2['dlug_publiczny'] == 0) || ($rok1['dlug_publiczny'] == 0)) { ?>
                            n.d.
                        <? } else {
                        $v = round(($rok2['dlug_publiczny'] * 100 / $rok1['dlug_publiczny']) - 100, 2);
                        if ($v > 0) {
                            $factor = 'glyphicon-arrow-up u';
                        } else {
                            $factor = 'glyphicon-arrow-down d';
                        }
                        ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                        <? } ?></span></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Produkt Krajowy Brutto:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['pkb'] == 0) {
                            echo "b.d.";
                        } else {
                            echo number_format_h($rok1['pkb'] * $rok1['usd']) . " zł";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['pkb'] == 0) {
                            echo "b.d.";
                        } else {
                            echo number_format_h($rok2['pkb'] * $rok2['usd']) . " zł";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><span
                            class="text"><? if (($rok2['pkb'] == 0) || ($rok1['pkb'] == 0)) { ?>
                                n.d.
                            <? } else {
                                $v = round(($rok2['pkb'] * 100 / $rok1['pkb']) - 100, 2);
                                if ($v > 0) {
                                    $factor = 'glyphicon-arrow-up u';
                                } else {
                                    $factor = 'glyphicon-arrow-down d';
                                }
                                ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                            <? } ?></span></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Produkt Krajowy Brutto na osobę:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['pkb_per_capita'] == 0) {
                            echo "b.d.";
                        } else {
                            echo number_format_h($rok1['pkb_per_capita'] * $rok1['usd']) . " zł";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['pkb_per_capita'] == 0) {
                            echo "b.d.";
                        } else {
                            echo number_format_h($rok2['pkb_per_capita'] * $rok2['usd']) . " zł";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><? if (($rok2['pkb_per_capita'] == 0) || ($rok1['pkb_per_capita'] == 0)) { ?>
                            n.d.
                        <? } else {
                        $v = round(($rok2['pkb_per_capita'] * 100 / $rok1['pkb_per_capita']) - 100, 2);
                        if ($v > 0) {
                            $factor = 'glyphicon-arrow-up u';
                        } else {
                            $factor = 'glyphicon-arrow-down d';
                        }
                        ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                        <? } ?></span></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Inflacja:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['inflacja'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok1['inflacja'] - 100 . "%";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['inflacja'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok2['inflacja'] - 100 . "%";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><? if (($rok2['inflacja'] == 0) || ($rok1['inflacja'] == 0)) { ?>
                            n.d.
                        <? } else {
                            $v = round(($rok2['inflacja'] * 100 / $rok1['inflacja']) - 100, 1);
                            if ($v > 0) {
                                $factor = 'glyphicon-arrow-up u';
                            } else {
                                $factor = 'glyphicon-arrow-down d';
                            }
                            ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                        <? } ?></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Wydatki budżetu państwa:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok1['wydatki']) ?> zł</p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok2['wydatki']) ?> zł</p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><? if (($rok2['wydatki'] == 0) || ($rok1['wydatki'] == 0)) { ?>
                            n.d.
                        <? } else {
                            $v = round(($rok2['wydatki'] * 100 / $rok1['wydatki']) - 100, 1);
                            if ($v > 0) {
                                $factor = 'glyphicon-arrow-up u';
                            } else {
                                $factor = 'glyphicon-arrow-down d';
                            }
                            ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                        <? } ?></p>
                </div>
            </div>
            <select class="select_wydatki">
                <option value="czesci">wg. Części</option>
                <option value="dzialy" selected>wg. Działów</option>
                <option value="rozdzialy">wg. Rozdziałów</option>
            </select>

            <div class="compare-details">
                <? if (count($compareData['wydatki']['dzialy']['wzrost']) !== 0) { ?>
                    <div class="row data internal">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4>Wzrosły wydatki na:</h4>
                        </div>
                    </div>
                    <div class="czesci wydatki wzrost hidden">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['czesci']['wzrost'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span
                                            class="glyphicon glyphicon-arrow-up factor u"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="dzialy wydatki wzrost">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['dzialy']['wzrost'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span
                                            class="glyphicon glyphicon-arrow-up factor u"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="rozdzialy wydatki wzrost hidden">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['rozdzialy']['wzrost'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span
                                            class="glyphicon glyphicon-arrow-up factor u"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="wydatki_wzrost_on text-center"><span class="btn btn-link btn-sm">Pokaż więcej</span>
                    </div>
                    <div class="wydatki_wzrost_off hidden text-center"><span class="btn btn-link btn-sm">Ukryj</span>
                    </div>
                <? }
                if (count($compareData['wydatki']['dzialy']['spadek']) !== 0) { ?>
                    <div class="row data internal">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4>Spadły wydatki na:</h4>
                        </div>
                    </div>
                    <div class="czesci wydatki spadek hidden">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['czesci']['spadek'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span class="glyphicon glyphicon-arrow-down factor d"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="dzialy wydatki spadek">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['dzialy']['spadek'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span class="glyphicon glyphicon-arrow-down factor d"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="rozdzialy wydatki spadek hidden">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['rozdzialy']['spadek'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['wydatki'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span class="glyphicon glyphicon-arrow-down factor d"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="wydatki_spadek_on text-center"><span class="btn btn-link btn-sm">Pokaż więcej</span>
                    </div>
                    <div class="wydatki_spadek_off hidden text-center"><span class="btn btn-link btn-sm">Ukryj</span>
                    </div>
                <? }
                if (count($compareData['wydatki']['dzialy']['bd']) !== 0) { ?>
                    <div class="row data internal">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4>Dane dostępne tylko w jednym roczniku:</h4>
                        </div>
                    </div>
                    <div class="czesci wydatki hidden bd">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['czesci']['bd'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p1'])) {
                                            echo round($row['p1'] * 100 / $rok1['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p2'])) { ?>
                                            <?= round($row['p2'] * 100 / $rok2['wydatki'], 2); ?>%
                                        <?
                                        } else { ?>
                                            b.d.
                                        <? } ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff">n.d.</p>
                                </div>
                            </div>
                            <?
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="dzialy wydatki bd">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['dzialy']['bd'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p1'])) {
                                            echo round($row['p1'] * 100 / $rok1['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p2'])) {
                                            echo round($row['p2'] * 100 / $rok2['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff">n.d.</p>
                                </div>
                            </div>
                            <?
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="rozdzialy wydatki hidden bd">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['rozdzialy']['bd'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p1'])) {
                                            echo round($row['p1'] * 100 / $rok1['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p2'])) {
                                            echo round($row['p2'] * 100 / $rok2['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff">n.d.</p>
                                </div>
                            </div>
                            <?
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="wydatki_bd_on text-center"><span class="btn btn-link btn-sm">Pokaż więcej</span></div>
                    <div class="wydatki_bd_off hidden text-center"><span class="btn btn-link btn-sm">Ukryj</span></div>
                <? } ?>
            </div>

            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Dochody budżetu państwa:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok1['dochody']) ?> zł</p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok2['dochody']) ?> zł</p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><? if (($rok2['dochody'] == 0) || ($rok1['dochody'] == 0)) { ?>
                            n.d.
                        <? } else {
                            $v = round(($rok2['dochody'] * 100 / $rok1['dochody']) - 100, 1);
                            if ($v > 0) {
                                $factor = 'glyphicon-arrow-up u';
                            } else {
                                $factor = 'glyphicon-arrow-down d';
                            }
                            ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                        <? } ?></p>
                </div>
            </div>
            <select class="select_dochody">
                <option value="czesci">wg. Części</option>
                <option value="dzialy" selected>wg. Działów</option>
            </select>

            <div class="compare-details">
                <? if (count($compareData['dochody']['dzialy']['wzrost']) !== 0) { ?>
                    <div class="row data internal">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4>Wzrost wpływów z:</h4>
                        </div>
                    </div>
                    <div class="czesci dochody wzrost hidden">
                        <?
                        $i = 0;
                        foreach ($compareData['dochody']['czesci']['wzrost'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span
                                            class="glyphicon glyphicon-arrow-up factor u"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="dzialy dochody wzrost">
                        <?
                        $i = 0;
                        foreach ($compareData['dochody']['dzialy']['wzrost'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span
                                            class="glyphicon glyphicon-arrow-up factor u"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="dochody_wzrost_on text-center"><span class="btn btn-link btn-sm">Pokaż więcej</span>
                    </div>
                    <div class="dochody_wzrost_off hidden text-center"><span class="btn btn-link btn-sm">Ukryj</span>
                    </div>
                <? } ?>
                <? if (count($compareData['dochody']['dzialy']['spadek']) !== 0) { ?>
                    <div class="row data internal">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4>Spadek wpływów z:</h4>
                        </div>
                    </div>

                    <div class="czesci dochody spadek hidden">
                        <?
                        $i = 0;
                        foreach ($compareData['dochody']['czesci']['spadek'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span
                                            class="glyphicon glyphicon-arrow-down factor d"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="dzialy dochody spadek">
                        <?
                        $i = 0;
                        foreach ($compareData['dochody']['dzialy']['spadek'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p1'] * 100 / $rok1['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><?= round($row['p2'] * 100 / $rok2['dochody'], 2) ?>%</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff"><span
                                            class="glyphicon glyphicon-arrow-down factor d"></span> <span
                                            class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                                </div>
                            </div>
                            <?
                            $i++;
                        } ?>
                    </div>
                    <div class="dochody_spadek_on text-center"><span class="btn btn-link btn-sm">Pokaż więcej</span>
                    </div>
                    <div class="dochody_spadek_off hidden text-center"><span class="btn btn-link btn-sm">Ukryj</span>
                    </div>
                <? } ?>
                <? if (count($compareData['dochody']['dzialy']['bd']) !== 0) { ?>
                    <div class="row data internal">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4>Dane dostępne tylko w jednym roczniku:</h4>
                        </div>
                    </div>
                    <div class="czesci dochody hidden bd">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['czesci']['bd'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p1'])) {
                                            echo round($row['p1'] * 100 / $rok1['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p2'])) {
                                            echo round($row['p2'] * 100 / $rok2['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff">n.d.</p>
                                </div>
                            </div>
                            <?
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="dzialy dochody bd">
                        <?
                        $i = 0;
                        foreach ($compareData['wydatki']['dzialy']['bd'] as $row) {
                            ?>
                            <div class="row subdata <? if ($i > 2) { ?>hidden<? } else { ?>primary_row<? } if($i%2==1){?> grey <?}?>">
                                <div class="col-sm-2 _label">
                                    <p><?= $row['tresc'] ?>:</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p1'])) {
                                            echo round($row['p1'] * 100 / $rok1['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="value"><? if (isset($row['p2'])) {
                                            echo round($row['p2'] * 100 / $rok2['wydatki'], 2); ?>%<?
                                        } else { ?>b.d.<?
                                        } ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="value diff">n.d.</p>
                                </div>
                            </div>
                            <?
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="dochody_bd_on text-center"><span class="btn btn-link btn-sm">Pokaż więcej</span></div>
                    <div class="dochody_bd_off hidden  text-center"><span class="btn btn-link btn-sm">Ukryj</span></div>
                <? } ?>
            </div>

            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Deficyt budżetu państwa:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok1['deficyt']) ?> zł</p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok2['deficyt']) ?> zł</p>
                </div>
                <div class="col-sm-2">
                    <p class="value"><? if (($rok2['deficyt'] == 0) || ($rok1['deficyt'] == 0)) { ?>
                            n.d.
                        <? } else {
                            $v = round(($rok2['deficyt'] * 100 / $rok1['deficyt']) - 100, 1);
                            if ($v > 0) {
                                $factor = 'glyphicon-arrow-up u';
                            } else {
                                $factor = 'glyphicon-arrow-down d';
                            }
                            ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                        <? } ?></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Stopa bezrobocia:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['bezrobocie'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok1['bezrobocie'] . "%";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['bezrobocie'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok2['bezrobocie'] . "%";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value"><? if (($rok2['bezrobocie'] == 0) || ($rok1['bezrobocie'] == 0)) { ?>
                            n.d.
                        <? } else {
                            $v = round(($rok2['bezrobocie'] * 100 / $rok1['bezrobocie']) - 100, 1);
                            if ($v > 0) {
                                $factor = 'glyphicon-arrow-up u';
                            } else {
                                $factor = 'glyphicon-arrow-down d';
                            }
                            ?><span class="glyphicon factor <?= $factor ?>"></span><?= $v ?>%
                        <? } ?></p>
                </div>
            </div>
        </div>



