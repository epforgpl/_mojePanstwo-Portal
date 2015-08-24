<?

$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);


$okreg = $radny->getLayer('okreg');

if ($okreg) {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okregi', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-okregi');
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
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

        <? if ($powiazania = $radny->getLayer('powiazania')) { ?>
            <div class="databrowser-panel">
                <h2>Dane wynikające z oświadczeń majątkowych:</h2>

                <div class="row objectsPage">
                    <div class="objectRender dane_majatkowe">
                    <? if ($powiazania['miejsce_pracy_html'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Miejsce pracy i zajmowane stanowiska:</h5>
                                    <ul class="dane_majatkowe">
                                        <?= $powiazania['miejsce_pracy_html']; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['dg_sc'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Działalność gospodarcza i spółki cywilne:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['dg_sc']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['spolki_handlowe'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Spółki handlowe:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['spolki_handlowe']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['udzialy_w_spolkach_z_udzialem_gminy'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Udziały w spółkach z udziałem gminy:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['udzialy_w_spolkach_z_udzialem_gminy']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['akcje_spolek'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Posiadane akcje spółek:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['akcje_spolek']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['czlonek_zarzadu'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5  class="title">Członek zarządu w spółkach:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['czlonek_zarzadu']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['rady_nadzorcze'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Członek rady nadzorczej w spółkach:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['rady_nadzorcze']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['komisje_rewizyjne'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Członek komisji rewizyjnej w spółkach:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['komisje_rewizyjne']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($powiazania['rada_dzielnicy'] != '') { ?>
                        <div class="row">
                            <div class="data col-xs-12">
                                <div class="content">
                                    <h5 class="title">Radny dzielnicy:</h5>

                                    <p class="dane_majatkowe">
                                        <?= $powiazania['rada_dzielnicy']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? } ?>
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
    <? if ($okreg) { ?>
    	
        <a class="okregiBlock margin-top-10" href="/dane/gminy/903,krakow/okregi/<?= $okreg[2] ?>" target="_self">
            <h2>Okręg nr. <?= $okreg[2] ?></h2>

            <? /*
            <dl class="dl-horizontal margin-top-20">
                <dt>Rok</dt>
                <dd><?= $okreg[1] ?></dd>
                <dt>Dzielnice</dt>
                <dd><?= $okreg[4] ?></dd>
                <dt>Ilość mieszkańców</dt>
                <dd><?= $okreg[5] ?></dd>
                <dt>Liczba mandatów</dt>
                <dd><?= $okreg[6] ?></dd>
            </dl>
            */ ?>

            <div class="row">
                <div class="col-md-12">
                    <div id="okreg_map" style="width: 100%; height: 200px; border-radius: 10px;" class="object"></div>
                    <div data-name="okreg" data-content='<?= json_encode($okreg) ?>'></div>
                </div>
            </div>
        </a>
    <? } ?>
</div>
