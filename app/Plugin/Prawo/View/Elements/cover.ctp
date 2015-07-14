<?
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="col-xs-12 col-md-8">
    <div class="block col-xs-12">
        <header>Typy obowiązujących aktów prawnych</header>
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="dane/prawo?conditions[prawo.typ_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['prawo_obowiazujace']['typ_id'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Akty prawne, które wejdą niedługo w życie</header>
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['prawo']['wejda']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['prawo']['wejda']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                    <div class="objectRender-addons">
									<span
                                        class="">Wchodzi w życie <?= dataSlownie($doc['fields']['source'][0]['data']['prawo.data_wejscia_w_zycie']); ?>
                                    </div>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Autorzy obowiązujących aktów prawnych</header>
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-ColumnsHorizontal" data-choose-request="dane/prawo?conditions[prawo.autor_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['prawo_obowiazujace']['autor_id'])) ?>">
                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Akty prawne, które weszły niedawno w życie</header>
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['prawo']['weszly']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['prawo']['weszly']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                    <div class="objectRender-addons">
									<span
                                        class="">Data wejścia w życie: <?= dataSlownie($doc['fields']['source'][0]['data']['prawo.data_wejscia_w_zycie']); ?>
                                    </div>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Nowe akty prawne w czasie</header>
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-DateHistogram"
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['prawo']['date'])) ?>">

                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>
</div>