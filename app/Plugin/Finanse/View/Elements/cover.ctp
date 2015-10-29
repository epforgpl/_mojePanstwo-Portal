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
foreach ($dane as $rocznik) {
    if ($rocznik['fields']['source'][0]['data']['budzety.rok'] == $p1) {
        $rok1['premier_id'] = $rocznik['fields']['source'][0]['data']['budzety.premier_czlowiek_id'];
        $rok1['premier'] = $rocznik['fields']['source'][0]['data']['budzety.premier_nazwa'];
        $rok1['bezrobocie'] = $rocznik['fields']['source'][0]['data']['budzety.bezrobocie'];
        $rok1['inflacja'] = $rocznik['fields']['source'][0]['data']['budzety.inflacja'];
        $rok1['pkb'] = $rocznik['fields']['source'][0]['data']['budzety.pkb'];
        $rok1['pkb_per_capita'] = $rocznik['fields']['source'][0]['data']['budzety.pkb_per_capita'];
        $rok1['dlug_publiczny'] = $rocznik['fields']['source'][0]['data']['budzety.dlug_publiczny'];
        $rok1['eur'] = $rocznik['fields']['source'][0]['data']['budzety.eur'];
        $rok1['usd'] = $rocznik['fields']['source'][0]['data']['budzety.usd'];
        $rok1['dem'] = $rocznik['fields']['source'][0]['data']['budzety.dem'];
        $rok1['wydatki'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_wydatki'];
        $rok1['dochody'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_dochody'];
        $rok1['deficyt'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_deficyt'];
        break;
    }
}
foreach ($dane as $rocznik) {
    if ($rocznik['fields']['source'][0]['data']['budzety.rok'] == $p2) {
        $rok2['premier_id'] = $rocznik['fields']['source'][0]['data']['budzety.premier_czlowiek_id'];
        $rok2['premier'] = $rocznik['fields']['source'][0]['data']['budzety.premier_nazwa'];
        $rok2['bezrobocie'] = $rocznik['fields']['source'][0]['data']['budzety.bezrobocie'];
        $rok2['inflacja'] = $rocznik['fields']['source'][0]['data']['budzety.inflacja'];
        $rok2['pkb'] = $rocznik['fields']['source'][0]['data']['budzety.pkb'];
        $rok2['pkb_per_capita'] = $rocznik['fields']['source'][0]['data']['budzety.pkb_per_capita'];
        $rok2['dlug_publiczny'] = $rocznik['fields']['source'][0]['data']['budzety.dlug_publiczny'];
        $rok2['eur'] = $rocznik['fields']['source'][0]['data']['budzety.eur'];
        $rok2['usd'] = $rocznik['fields']['source'][0]['data']['budzety.usd'];
        $rok2['dem'] = $rocznik['fields']['source'][0]['data']['budzety.dem'];
        $rok2['wydatki'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_wydatki'];
        $rok2['dochody'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_dochody'];
        $rok2['deficyt'] = $rocznik['fields']['source'][0]['data']['budzety.liczba_deficyt'];
        break;
    }
}
?>

<div class="col-xs-12">
    <div class="appBanner">
        <h1 class="appTitle">Finanse publiczne</h1>

        <p class="appSubtitle">Poznaj stan finansów publicznych Polski.</p>
    </div>
    <? //debug($compareData); ?>
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

                    <p><a href="#">Wybierz inny rocznik</a></p>
                </div>
                <div class="col-sm-4">
                    <h2>Rok <?= $p2 ?></h2>

                    <p><a href="#">Wybierz inny rocznik</a></p>
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
                    <p class="value diff"><span class="glyphicon glyphicon-arrow-up"></span> <span
                            class="text">5%</span></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Produkt Krajowy Brutto:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok1['pkb']) ?> zł</p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok2['pkb']) ?> zł</p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                            class="text">3%</span></p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Produkt Krajowy Brutto na osobę:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok1['pkb_per_capita']) ?> zł</p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><?= number_format_h($rok2['pkb_per_capita']) ?> zł</p>
                </div>
                <div class="col-sm-2">
                    <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                            class="text">3%</span></p>
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
                    <p class="value diff"><span class="glyphicon glyphicon-arrow-up"></span> <span
                            class="text">2.3</span>%</p>
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
                    <p class="value diff"><span class="glyphicon glyphicon-arrow-up"></span> <span
                            class="text">4%</span></p>
                </div>
            </div>

            <div class="compare-details">
                <div class="row data internal">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h4>Wzrosły wydatki na:</h4>
                    </div>
                </div>
                <?
                $i = 0;
                foreach ($compareData['wydatki']['dzialy']['wzrost'] as $row) {
                    ?>
                    <div class="row subdata <? if ($i > 2) { ?>hidden<? }?>">
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
                            <p class="value diff"><span class="factor u"></span> <span
                                    class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                        </div>
                    </div>
                    <?
                    $i++;
                } ?>
                <div><a>Pokaż więcej</a></div>
                <div class="row data internal">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h4>Spadły wydatki na:</h4>
                    </div>
                </div>
                <?
                $i = 0;
                foreach ($compareData['wydatki']['dzialy']['spadek'] as $row) {
                    ?>
                    <div class="row subdata <? if ($i > 2) { ?>hidden<? }?>">
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
                            <p class="value diff"><span class="factor d"></span> <span
                                    class="text"><?= round($row['zmiana'], 2) ?>%</span></p>
                        </div>
                    </div>
                    <?
                    $i++;
                } ?>
                <div><a>Pokaż więcej</a></div>
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
                    <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                            class="text">4%</span></p>
                </div>
            </div>

            <div class="compare-details">
                <div class="row data internal">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h4>Wzrost wpływów z:</h4>
                    </div>
                </div>
                <div class="row subdata">
                    <div class="col-sm-2 _label">
                        <p>Waciki:</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">25%</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">35%</p>
                    </div>
                    <div class="col-sm-2">
                        <p class="value diff"><span class="glyphicon glyphicon-arrow-up"></span> <span
                                class="text">15%</span></p>
                    </div>
                </div>
                <div class="row subdata">
                    <div class="col-sm-2 _label">
                        <p>Waciki:</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">25%</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">35%</p>
                    </div>
                    <div class="col-sm-2">
                        <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                                class="text">4%</span></p>
                    </div>
                </div>
                <div class="row subdata">
                    <div class="col-sm-2 _label">
                        <p>Waciki:</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">25%</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">35%</p>
                    </div>
                    <div class="col-sm-2">
                        <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                                class="text">4%</span></p>
                    </div>
                </div>
                <div class="row data internal">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h4>Spadek wpływów z:</h4>
                    </div>
                </div>
                <div class="row subdata">
                    <div class="col-sm-2 _label">
                        <p>Waciki:</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">25%</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">35%</p>
                    </div>
                    <div class="col-sm-2">
                        <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                                class="text">4%</span></p>
                    </div>
                </div>
                <div class="row subdata">
                    <div class="col-sm-2 _label">
                        <p>Waciki:</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">25%</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">35%</p>
                    </div>
                    <div class="col-sm-2">
                        <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                                class="text">4%</span></p>
                    </div>
                </div>
                <div class="row subdata">
                    <div class="col-sm-2 _label">
                        <p>Waciki:</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">25%</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="value">35%</p>
                    </div>
                    <div class="col-sm-2">
                        <p class="value diff"><span class="glyphicon glyphicon-arrow-down"></span> <span
                                class="text">4%</span></p>
                    </div>
                </div>
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
                    <p class="value">5%</p>
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
                    <p class="value">5%</p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Kurs roczny USD:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['usd'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok1['usd'] . " PLN";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['usd'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok2['usd'] . " PLN";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value">5%</p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Kurs roczny EUR:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['eur'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok1['eur'] . " PLN";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['eur'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok2['eur'] . " PLN";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value">5%</p>
                </div>
            </div>
            <div class="row data">
                <div class="col-sm-2 _label">
                    <h3>Kurs roczny DEM:</h3>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok1['dem'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok1['dem'] . " PLN";
                        } ?></p>
                </div>
                <div class="col-sm-4">
                    <p class="value"><? if ($rok2['dem'] == 0) {
                            echo "b.d.";
                        } else {
                            echo $rok2['dem'] . " PLN";
                        } ?></p>
                </div>
                <div class="col-sm-2">
                    <p class="value">5%</p>
                </div>
            </div>


            <? //debug($dataBrowser); ?>


        </div>



