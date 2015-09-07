<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/modules/drilldown');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('css', $this->Less->css('view-budzety', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', 'Dane.budzet-view');
?>

<? echo $this->Element('dataobject/pageBegin'); ?>
<div class="row">
    <div class="col-xs-12">
        <?
        $past_dochody = 0;
        $past_wydatki = 0;
        $past_deficyt = 0;
        foreach ($object_aggs['budzety']['top']['hits']['hits'] as $row) {
            if ($row['fields']['source'][0]['data']['prawo.rok'] == $object->getData('rok') - 1) {
                $past_dochody = $row['fields']['source'][0]['data']['budzety.liczba_dochody'];
                $past_wydatki = $row['fields']['source'][0]['data']['budzety.liczba_wydatki'];
                $past_deficyt = $row['fields']['source'][0]['data']['budzety.liczba_deficyt'];
            }
        }
        $dochody = $object->getData('liczba_dochody');
        $wydatki = $object->getData('liczba_wydatki');
        $deficyt = $object->getData('liczba_deficyt');
        $proc_dochody = ($dochody - $past_dochody) / $dochody;
        $proc_wydatki = ($wydatki - $past_wydatki) / $wydatki;
        $proc_deficyt = ($deficyt - $past_deficyt) / $deficyt;
        ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">

        <div class="block block-simple col-xs-12">
            <header>Główne parametry budżetu:</header>
            <section class="aggs-init margin-sides-20">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">

                        <div class="row text-center">
                            <div class="col-xs-4"><strong>Dochody</strong></div>
                            <div class="col-xs-4"><strong>Wydatki</strong></div>
                            <div class="col-xs-4"><strong>Deficyt</strong></div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div
                                class="col-xs-4">
                                <h2><?= number_format_h($dochody * 1000) ?></h2></div>
                            <div
                                class="col-xs-4">
                                <h2><?= number_format_h($wydatki * 1000) ?></h2></div>
                            <div
                                class="col-xs-4">
                                <h2><?= number_format_h($deficyt * 1000) ?></h2></div>
                        </div>
                        <div class="row text-center">
                            <div
                                class="col-xs-4"><span class="factor <? if ($proc_dochody > 0) {
                                    echo 'u';
                                } elseif ($proc_dochody < 0) {
                                    echo 'd';
                                } ?>"><?= round($proc_dochody * 100, 2) ?>%</span><span
                                    class="i"> w stosunku do roku <?= $object->getData('rok') - 1 ?>
                                    .
                           </span></div>
                            <div
                                class="col-xs-4"><span class="factor <? if ($proc_wydatki > 0) {
                                    echo 'u';
                                } elseif ($proc_wydatki < 0) {
                                    echo 'd';
                                } ?>"><?= round($proc_wydatki * 100, 2) ?>%</span><span
                                    class="i"> w stosunku do roku <?= $object->getData('rok') - 1 ?>
                                    .
                                </span></div>
                            <div
                                class="col-xs-4"><span class="factor <? if ($proc_deficyt > 0) {
                                    echo 'u';
                                } elseif ($proc_deficyt < 0) {
                                    echo 'd';
                                } ?>"><?= round($proc_deficyt * 100, 2) ?>%</span><span
                                    class="i"> w stosunku do roku <?= $object->getData('rok') - 1 ?>
                                    .
                                </span></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="block block-simple col-xs-12">

            <? $dane = array(
                'dzialy' => array(),
                'rozdzialy' => array()
            );
            $temp = array();

            $source = $object->getLayers('dzialy');
            if ($source['dzialy']) {
                $i = 0;
                $inne = array(
                    'name' => 'Pozostałe',
                    'y' => 0,
                    'drilldown' => 'Inne'
                );
                foreach ($source['dzialy'] as $czesc) {
                    $ret = array();
                    $ret['name'] = $czesc['pl_budzety_wydatki']['tresc'];
                    $ret['y'] = $czesc[0]['plan'];
                    $ret['drilldown'] = $czesc['pl_budzety_wydatki']['dzial_str'];
                    if ($i > 13) {
                        $inne['y'] += (int)$czesc[0]['plan'];
                        $temp[] = $ret;
                    } else {
                        $dane['dzialy'][] = $ret;
                    }
                    $i++;
                }
                $dane['dzialy'][] = $inne;
                $dane['rozdzialy'][] = array(
                    'name' => 'Pozostałe',
                    'id' => 'Inne',
                    'data' => $temp
                );
                $rozdzialy = array();
                foreach ($source['rozdzialy'] as $rozdzial) {
                    $ret = array();
                    $src = $rozdzial['pl_budzety_wydatki_dzialy']['src'];
                    if (isset($rozdzialy[$src])) {

                        $rozdzialy[$src]['data'][] = array(
                            'name' => $rozdzial['pl_budzety_wydatki']['tresc'],
                            'y' => $rozdzial[0]['plan']
                        );

                    } else {

                        $ret['name'] = $rozdzial['pl_budzety_wydatki_dzialy']['tresc'];
                        $ret['id'] = $src;
                        $ret['data'] = array();
                        $ret['data'][] = array(
                            'name' => $rozdzial['pl_budzety_wydatki']['tresc'],
                            'y' => $rozdzial[0]['plan']
                        );
                        $rozdzialy[$src] = $ret;

                    }
                }

                foreach ($rozdzialy as $rozdzial) {
                    $dane['rozdzialy'][] = $rozdzial;
                }

                $sum = 0;
                foreach ($dane['dzialy'] as $cos) {
                    $sum += $cos['y'];
                }
                ?>
                <div class="hidden highchart_datasource" data-highchart='<? echo json_encode($dane) ?>'
                     data-total='<?= $sum ?>'></div>

                <header>Wydatki według działów:</header>
                <section class="aggs-init margin-sides-20">
                    <small class="subTitle">Kliknij w interesujący wycinek wykresu, aby uzyskać więcej danych</small>
                    <button class="btn btn-primary btn-sm btn-icon auto-width btnDrillUp pull-right hide"
                            data-drill="0"><i class="icon glyphicon glyphicon-chevron-left"></i>Powrót
                    </button>
                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <div id="wydatki_budzetu_wg_czesci"></div>
                        </div>
                    </div>
                    <a href="<?= $object->getData('prawo.id') ?>/wydatki?type=dzialy">Zobacz te dane w formie
                        tabeli </a>
                </section>
            <? } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="block block-simple col-xs-12">
            <?
            $dzialy = array();
            foreach ($object->getLayers('dzialy')['dzialy'] as $dzial) {
                $dzialy[$dzial['pl_budzety_wydatki']['dzial_str']] = array(
                    'tresc' => $dzial['pl_budzety_wydatki']['tresc'],
                    'plan' => $dzial[0]['plan']
                );
            }
            $past_dzialy = array();
            foreach ($object->getLayers('past_dzialy')['dzialy'] as $dzial) {
                $past_dzialy[$dzial['pl_budzety_wydatki']['dzial_str']] = array(
                    'tresc' => $dzial['pl_budzety_wydatki']['tresc'],
                    'plan' => $dzial[0]['plan']
                );
            }
            $porownanie = array(
                'bez_zmian' => array(),
                'wzrost' => array(),
                'spadek' => array(),
            );

            $por = array();
            //ZMIENNA ZAKRESU NEUTRALNOSCI

            $neut = 3;

            foreach ($dzialy as $k => $v) {

                $temp = @round(-(1-$v['plan']/@$past_dzialy[$k]['plan'] / $wydatki * $past_wydatki) * 100,2);
                $por[$k] = array('tresc' => $v['tresc'], 'wart' => $temp, 'plan'=>$v['plan']/ $wydatki*100, 'plan_past'=>@$past_dzialy[$k]['plan']/ $past_wydatki*100);

                if ($temp < (-$neut)) {
                    $porownanie['spadek'][$k] = array('tresc' => $v['tresc'], 'wart' => $temp);
                } elseif ($temp > $neut) {
                    $porownanie['wzrost'][$k] = array('tresc' => $v['tresc'], 'wart' => $temp);
                } else {
                    $porownanie['bez_zmian'][$k] = array('tresc' => $v['tresc'], 'wart' => $temp);
                }
            }

            ?>
            <header>Wydatki, które wzrosły względem <?= $object->getData('rok') - 1 ?> roku</header>
            <section class="aggs-init margin-sides-20">
                <div class="margin-sides-20">
                    <table class="table table-strict table-condensed">
                        <thead>
                        <tr>
                            <th>Dział</th>
                            <th width="70%">Treść</th>
                            <th>Zmiana w proc.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($porownanie['wzrost'] as $key => $val) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $val['tresc'] ?></td>
                                <td><span class="factor u"><?= $val['wart'] ?>%</span>
                                </td>
                            </tr>
                        <? }?>
                    </tbody>
                </table>
                </div>
            </section>
            <header>Wydatki, które zmalały względem <?= $object->getData('rok') - 1 ?> roku</header>
            <section class="aggs-init margin-sides-20">
                <div class="margin-sides-20">
                    <table class="table table-strict table-condensed">
                        <thead>
                        <tr>
                            <th>Dział</th>
                            <th width="70%">Treść</th>
                            <th>Zmiana w proc.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($porownanie['spadek'] as $key => $val) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $val['tresc'] ?></td>
                                <td><span class="factor d"><?= $val['wart'] ?>%</span>
                                </td>
                            </tr>
                        <? }?>
                        </tbody>
                    </table>
                </div>
            </section>
            <header>Wydatki, które pozostały nie zmienione względem <?= $object->getData('rok') - 1 ?> roku</header>
            <section class="aggs-init margin-sides-20">
                <div class="margin-sides-20">
                    <table class="table table-strict table-condensed">
                        <thead>
                        <tr>
                            <th>Dział</th>
                            <th width="70%">Treść</th>
                            <th>Zmiana w proc.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($porownanie['bez_zmian'] as $key => $val) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $val['tresc'] ?></td>
                                <td><span class="factor"><?= $val['wart'] ?>%</span>
                                </td>
                            </tr>
                        <? }?>
                        </tbody>
                    </table>
                </div>
                <small>Wyznaczone zmiany, uwzględniają zmiany całości wydatków budżetowych.</small>
            </section>
        </div>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
