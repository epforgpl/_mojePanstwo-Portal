<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>

<div class="col-md-8">
    <? if (isset($_submenu) && !empty($_submenu)) { ?>
        <div class="menuTabsCont col-xs-8">
            <?
            if (!isset($_submenu['base']))
                $_submenu['base'] = $object->getUrl();
            echo $this->Element('Dane.dataobject/menuTabs', array(
                'menu' => $_submenu,
            ));
            ?>
        </div>
    <? } ?>
    <? if ($object->getId() == 903) { ?>

        <div class="block block-default col-xs-12">
            <header>Najnowsze projekty legislacyjne pod obrady rady</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['rada_projekty']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['rada_projekty']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['all']['rada_projekty']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons text-center">
                        <a href="<?= $object->getUrl() ?>/druki" class="btn btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>

        <div class="block block-default col-xs-12">
            <header>Najnowsze uchwały Rady</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['krakow_rada_uchwaly']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['krakow_rada_uchwaly']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['all']['krakow_rada_uchwaly']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons text-center">
                        <a href="<?= $object->getUrl() ?>/rada_uchwaly" class="btn btn-primary btn-sm">Zobacz
                            więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>

        <div class="block block-default col-xs-12">
            <header>Najnowsze interpelacje radnych</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons text-center">
                        <a href="<?= $object->getUrl() ?>/interpelacje" class="btn btn-primary btn-sm">Zobacz
                            więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>


    <? } else { ?>

        <div class="block block-default col-xs-12">
            <header>Najnowsze prawo lokalne</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons text-center">
                        <a href="<?= $object->getUrl() ?>/prawo" class="btn btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>

    <? } ?>

    <div class="block block-default col-xs-12">
        <header>Najnowsze zamówienia publiczne</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </div>
            </div>
        </section>
        <? if ($dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits']) { ?>
            <footer>
                <div class="buttons text-center">
                    <a href="<?= $object->getUrl() ?>/zamowienia" class="btn btn-primary btn-sm">Zobacz
                        więcej</a>
                </div>
            </footer>
        <? } ?>
    </div>

    <div class="block block-default col-xs-12">
        <header>Najwięcej zamówień publicznych otrzymali</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">

                    <ul class="wykonawcy">
                        <?
                        foreach ($dataBrowser['aggs']['all']['dokumenty']['wykonawcy']['id']['buckets'] as $doc) {
                            $wykonawca = array(
                                'id' => $doc['key'],
                                'nazwa' => $doc['nazwa']['buckets'][0]['key'],
                                'cena' => $doc['cena']['value'],
                            );
                            ?>
                            <li>

                                <h2 class="smaller">
                                    <a class="nazwa pull-left"
                                       href="#"><?= $this->Text->truncate($wykonawca['nazwa'], 70) ?></a>
                                    <span class="cena pull-right"><?= number_format_h($wykonawca['cena']) ?> PLN</span>
                                </h2>

                                <p class="stats"><?= pl_dopelniacz($doc['dokumenty']['doc_count'], 'zamówienie', 'zamówienia', 'zamówień') ?></p>

                                <div style="display: none;">
                                    <ul class="dataobjects smaller">
                                        <?
                                        foreach ($doc['dokumenty']['top']['hits']['hits'] as $hit) {

                                            $czesc = false;

                                            if (
                                                isset($hit['fields']['source'][0]['static']['wykonawcy']) &&
                                                $hit['fields']['source'][0]['static']['wykonawcy']
                                            ) {
                                                foreach ($hit['fields']['source'][0]['static']['wykonawcy'] as $w)
                                                    if ($w['id'] == $wykonawca['id'])
                                                        $czesc = $w;
                                            }

                                            echo $this->Dataobject->render($hit, 'zamowienia_publiczne_dokumenty', array(
                                                'czesc' => $czesc,
                                            ));
                                        }
                                        ?>
                                    </ul>

                                    <? if ($doc['dokumenty']['doc_count'] > 5) { ?>
                                        <div class="buttons">
                                            <a href="#" class="btn btn-primary btn-sm">Więcej</a>
                                        </div>
                                    <? } ?>
                                </div>

                            </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        </section>
        <footer>
            <div class="buttons text-center">
                <a href="<?= $object->getUrl() ?>/zamowienia" class="btn btn-primary btn-sm">Zobacz więcej</a>
            </div>
        </footer>
    </div>

    <div class="block block-simple col-xs-12">
        <header>Typy zarejestrowanych organizacji<? if ($object->getId() == 903) { ?> w Krakowie<? } ?></header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="<?= $object->getUrl() ?>/organizacje?conditions[krs_podmioty.forma_prawna_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['all']['krs_podmioty']['typ_id'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="block block-simple col-xs-12">
        <header>Kapitalizacja spółek handlowych</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-ColumnsVertical"
                     data-choose-request="<?= $object->getUrl() ?>/organizacje?conditions[krs_podmioty.wartosc_kapital_zakladowy]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['all']['krs_podmioty']['kapitalizacja'])) ?>">
                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>

    <div class="block block-simple col-xs-12">
        <header>Rejestracje nowych organizacji w czasie</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-DateHistogram"
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['all']['krs_podmioty']['date'])) ?>">

                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>


</div>
<div class="col-md-4 sidebar">

    <? if ($object->getId() == 903) { ?>

        <div class="block block-simple col-md-12">

            <header>Najnowsze posiedzenie Rady Miasta</header>

            <section class="aggs-init nopadding">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['rada_posiedzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['rada_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'krakow_posiedzenia');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['all']['rada_posiedzenia']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons pull-right">
                        <a href="<?= $object->getUrl() ?>/posiedzenia" class="btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>
        <div class="block block-simple col-md-12">

            <header>Najnowsze nagrania posiedzeń komisji</header>

            <section class="aggs-init nopadding">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['rada_komisje_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'krakow_rada_posiedzenia');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['all']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons pull-right">
                        <a href="<?= $object->getUrl() ?>/komisje_posiedzenia"
                           class="btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>
        <div class="block block-simple col-md-12">

            <header>Najnowsze nagrania posiedzeń rad dzielnic</header>

            <section class="aggs-init nopadding">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['all']['dzielnice_posiedzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['all']['dzielnice_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li>
                                        <?
                                        echo $this->Dataobject->render($doc, 'dzielnice_posiedzenia');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>

                    </div>
                </div>
            </section>
            <? if ($dataBrowser['aggs']['all']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
                <footer>
                    <div class="buttons pull-right">
                        <a href="<?= $object->getUrl() ?>/dzielnice"
                           class="btn-primary btn-sm">Zobacz więcej</a>
                    </div>
                </footer>
            <? } ?>
        </div>

    <? } ?>

</div>