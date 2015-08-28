<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="col-xs-12 col-md-8">
    <div class="block col-xs-12">
        <header>Ostatnie posiedzenie Sejmu</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['posiedzenia']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['posiedzenia']['top']['hits']['hits'] as $doc) { ?>
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
    </div>

    <div class="block col-xs-12">
        <header>Najnowsze projekty w Sejmie</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['druki']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['druki']['top']['hits']['hits'] as $doc) { ?>
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
    </div>

    <div class="block col-xs-12">
        <header>Zawody posłów</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.forma_prawna_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['poslowie']['zawod'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Kluby sejmowe</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-ColumnsHorizontal"
                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.wartosc_kapital_zakladowy]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['poslowie']['klub_id'])) ?>">
                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Posłowie według płci</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.forma_prawna_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['poslowie']['plec'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Najnowsze interpelacje</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['interpelacje']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits'] as $doc) { ?>
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
    </div>

    <div class="block col-xs-12">
        <header>Najnowsze komunikaty Kancelarii Sejmu</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['komunikaty']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['komunikaty']['top']['hits']['hits'] as $doc) { ?>
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
    </div>
</div>
