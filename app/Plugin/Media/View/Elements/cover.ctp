<?
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="col-md-8">

    <div class="databrowser-panels">

        <div class="databrowser-panel">
            <h2>Akty prawne, które wejdą niedługo w życie</h2>

            <div class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['prawo']['wejda']['doc_count']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['prawo']['wejda']['top']['hits']['hits'] as $doc) { ?>
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

            </div>
        </div>

        <div class="databrowser-panel">
            <h2>Typy obowiązujących aktów prawnych</h2>

            <div class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                         data-choose-request="dane/prawo?conditions[prawo.typ_id]="
                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['prawo_obowiazujace']['typ_id'])) ?>">
                        <div class="chart">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="databrowser-panel">
            <h2>Nowe akty prawne w czasie</h2>

            <div class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-DateHistogram"
                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['prawo']['date'])) ?>">

                        <div class="chart"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="databrowser-panel">
            <h2>Akty prawne, które weszły niedawno w życie</h2>

            <div class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['prawo']['weszly']['doc_count']) { ?>
                            <ul class="dataobjects">
                                <? foreach ($dataBrowser['aggs']['prawo']['weszly']['top']['hits']['hits'] as $doc) { ?>
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

            </div>
        </div>

        <div class="databrowser-panel">
            <h2>Autorzy obowiązujących aktów prawnych</h2>

            <div class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-ColumnsHorizontal" data-choose-request="asd"
                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['prawo_obowiazujace']['autor_id'])) ?>">
                        <div class="chart"></div>
                    </div>
                </div>

            </div>
        </div>


    </div>

</div>