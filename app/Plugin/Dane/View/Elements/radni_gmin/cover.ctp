<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

$okreg = $radny->getLayer('okreg');

if ($okreg) {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okregi', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-okregi');
    switch (Configure::read('Config.language')) {
        case 'pol':
            $lang = "pl-PL";
            break;
        case 'eng':
            $lang = "en-EN";
            break;
    };
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
}

?>
<div class="col-md-9">
    <div class="databrowser-panels">

        <? if (@$dataBrowser['aggs']['glosowania']['top']['hits']['hits']) { ?>
            <div class="databrowser-panel margin-top-10">

                <h2>Wyniki głosowań:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['glosowania']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['glosowania']['top']['hits']['hits'] as $doc) { ?>
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($doc, 'rady_gmin_glosowania');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="buttons">
                                    <a href="<?= $radny->getUrl() ?>/glosowania" class="btn btn-primary btn-sm">Zobacz
                                        więcej</a>
                                </div>
                            <? } ?>

                        </div>
                    </div>

                </div>
            </div>
        <? } ?>

        <? if (@$dataBrowser['aggs']['interpelacje']['top']['hits']['hits']) { ?>
            <div class="databrowser-panel">
                <h2>Najnowsze interpelacje:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits'] as $doc) { ?>
                                        <li>
                                            <?
                                            echo $this->Dataobject->render($doc, 'default');
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="buttons">
                                    <a href="<?= $radny->getUrl() ?>/interpelacje" class="btn btn-primary btn-sm">Zobacz
                                        więcej</a>
                                </div>
                            <? } ?>

                        </div>
                    </div>

                </div>
            </div>
        <? } ?>

        <? if (@$dataBrowser['aggs']['komisje']['komisje']['kadencja']['top']['hits']['hits']) { ?>
            <div class="databrowser-panel">
                <h2>Komisje, w których zasiada radny:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['komisje']['komisje']['kadencja']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['komisje']['komisje']['kadencja']['top']['hits']['hits'] as $doc) { ?>
                                        <li>
                                            <div class="objectRender readed docdataobject objclass">

                                                <div class="row">

                                                    <div class="data col-xs-12">


                                                        <div>


                                                            <div class="content">


                                                                <i class="object-icon icon-datasets-krakow_rada_komisje"></i>

                                                                <div class="object-icon-side ">


                                                                    <p class="title">
                                                                        <a href="/dane/gminy/903/komisje/<?= $doc['fields']['komisja_id'][0] ?>"><?= $doc['fields']['komisja_nazwa'][0] ?>                                                                                                                                                    </a>
                                                                    </p>

                                                                    <p class="meta meta-desc"><?= $doc['fields']['stanowisko_nazwa'][0] ?></p>


                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                    <? } ?>
                                </ul>
                            <? } ?>

                        </div>
                    </div>

                </div>
            </div>
        <? } ?>


        <? if (isset($osoba) && ($organizacje = $osoba->getLayer('organizacje'))) { ?>
            <div class="databrowser-panel">
                <h2>Powiązania w KRS:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <ul class="dataobjects">
                                <? foreach ($organizacje as $organizacja) {
                                    $kapitalZakladowy = (float)$organizacja['kapital_zakladowy'];
                                    ?>
                                    <li>
                                        <?

                                        $organizacja['firma'] = $organizacja['nazwa'];
                                        $role = $organizacja['role'];
                                        unset($organizacja['role']);

                                        $doc = array(
                                            'fields' => array(
                                                'dataset' => array(
                                                    'krs_podmioty'
                                                ),
                                                'source' => array(
                                                    array(
                                                        'data' => $organizacja,
                                                    ),
                                                ),
                                                'id' => array(
                                                    array(
                                                        $organizacja['id'],
                                                    ),
                                                ),
                                            ),
                                            '_id' => false,

                                        );


                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>

                                        <? if ($role) { ?>
                                            <ul class="list-group less-borders role">
                                                <? foreach ($role as $rola) {
                                                    ?>
                                                    <li class="list-group-item">
                                                        <p><span
                                                                class="label label-primary"><?= $rola['label'] ?></span> <? if (isset($rola['params']['subtitle']) && $rola['params']['subtitle']) { ?>
                                                                <span
                                                                    class="sublabel normalizeText"><?= $rola['params']['subtitle'] ?></span><? } ?>
                                                        </p>
                                                    </li>
                                                <?
                                                }
                                                ?>
                                            </ul>
                                        <? } ?>

                                    </li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        <? } ?>

        <? if (@$dataBrowser['aggs']['oswiadczenia']['top']['hits']['hits']) { ?>
            <div class="databrowser-panel">
                <h2>Oświadczenia majątkowe:</h2>

                <div class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['oswiadczenia']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['oswiadczenia']['top']['hits']['hits'] as $doc) { ?>
                                        <div
                                            class="objectRender readed docdataobject objclass radni_gmin_oswiadczenia_majatkowe">
                                            <div class="row">
                                                <div class="data col-xs-12">
                                                    <div>
                                                        <div class="content">
                                                            <i class="object-icon icon-datasets-radni_gmin_oswiadczenia_majatkowe"></i>

                                                            <div class="object-icon-side  ">
                                                                <p class="title">
                                                                    <a href="<?= $radny->getUrl() ?>/oswiadczenia/<?= $doc['fields']['source'][0]['data']['krakow_oswiadczenia.id'] ?>"
                                                                       title="<?= $doc['fields']['source'][0]['data']['krakow_oswiadczenia.rok'] ?>">
                                                                        <?= $doc['fields']['source'][0]['data']['krakow_oswiadczenia.rok'] ?>
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                </ul>
                                <div class="buttons">
                                    <a href="<?= $radny->getUrl() ?>/oswiadczenia" class="btn btn-primary btn-sm">Zobacz
                                        więcej</a>
                                </div>
                            <? } ?>

                        </div>
                    </div>

                </div>
            </div>
        <? } ?>

    </div>
</div>
<div class="col-md-3">
    <? if ($powiazania = $radny->getLayer('powiazania')) { ?>
        <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
            <li class="dataHighlight col-xs-12 dane_radnego">
                <p class="_label">Data urodzenia</p>

                <p class="_value"><?= dataSlownie($powiazania['data_urodzenia']); ?></p>
            </li>

            <li class="dataHighlight col-xs-12 dane_radnego">
                <p class="_label">Miejsce urodzenia</p>

                <p class="_value"><?= $powiazania['miejsce_urodzenia']; ?></p>
            </li>
        </ul>
    <? } ?>

    <? if ($powiazania = $radny->getLayer('powiazania')) { ?>

        <?

        $fields = array(
            'miejsce_pracy_html',
            'dg_sc',
            'spolki_handlowe',
            'udzialy_w_spolkach_z_udzialem_gminy',
            'akcje_spolek',
            'czlonek_zarzadu',
            'rady_nadzorcze',
            'komisje_rewizyjne',
            'rada_dzielnicy'
        );

        $show = false;
        foreach ($fields as $field) {
            if ($powiazania[$field] != '')
                $show = true;
        }

        if ($show) { ?>

            <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                <li class="dataHighlight col-xs-12 dane_radnego">
                    <p class="_label">Data urodzenia</p>

                    <p class="_value"><?= dataSlownie($powiazania['data_urodzenia']); ?></p>
                </li>

                <li class="dataHighlight col-xs-12 dane_radnego">
                    <p class="_label">Miejsce urodzenia</p>

                    <p class="_value"><?= $powiazania['miejsce_urodzenia']; ?></p>
                </li>
            </ul>

            <? if ($powiazania['miejsce_pracy_html'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">
                            Miejsce pracy i zajmowane stanowiska:</p>

                        <ul class="_value">
                            <?= $powiazania['miejsce_pracy_html']; ?>
                        </ul>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['dg_sc'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Działalność gospodarcza i spółki cywilne:</p>

                        <p class="_value">

                            <?= $powiazania['dg_sc']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['spolki_handlowe'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Spółki handlowe:</p>

                        <p class="_value">

                            <?= $powiazania['spolki_handlowe']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['udzialy_w_spolkach_z_udzialem_gminy'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Udziały w spółkach z udziałem gminy:</p>

                        <p class="_value">
                            <?= $powiazania['udzialy_w_spolkach_z_udzialem_gminy']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['akcje_spolek'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Posiadane akcje spółek:</p>

                        <p class="_value">
                            <?= $powiazania['akcje_spolek']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['czlonek_zarzadu'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Członek zarządu w spółkach:</p>

                        <p class="_value">
                            <?= $powiazania['czlonek_zarzadu']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['rady_nadzorcze'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Członek rady nadzorczej w spółkach:</p>

                        <p class="_value">
                            <?= $powiazania['rady_nadzorcze']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['komisje_rewizyjne'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Członek komisji rewizyjnej w spółkach:</p>

                        <p class="_value">
                            <?= $powiazania['komisje_rewizyjne']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>
            <? if ($powiazania['rada_dzielnicy'] != '') { ?>
                <ul class="dataHighlights rightColumn dane_radnego margin-top-10">
                    <li class="dataHighlight col-xs-12 dane_radnego">
                        <p class="_label">Radny dzielnicy:</p>

                        <p class="_value">
                            <?= $powiazania['rada_dzielnicy']; ?>
                        </p>
                    </li>
                </ul>
            <? } ?>


        <? } ?>
    <? } ?>


    <? if ($okreg) { ?>
        <a class="okregiBlock margin-top-10" href="/dane/gminy/903,krakow/okregi/<?= $okreg[2] ?>" target="_self">
            <h2>Okręg nr. <?= $okreg[2] ?></h2>

            <div class="row">
                <div class="col-md-12">
                    <div id="okreg_map" style="width: 100%; height: 200px; border-radius: 10px;" class="object"></div>
                    <div data-name="okreg" data-content='<?= json_encode($okreg[3]) ?>'></div>
                </div>
            </div>
        </a>
    <? } ?>
</div>
