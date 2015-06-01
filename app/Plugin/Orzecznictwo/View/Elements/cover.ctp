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
        <header>Najczęściej skarżone organy przed sądami administracyjnymi</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-ColumnsHorizontal" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="orzecznictwo/sa?conditions[sa_orzeczenia.skarzony_organ_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['sa_orzeczenia']['skarzone_organy'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>    
</div>

<div class="col-xs-12 col-md-8">
    <div class="block col-xs-12">
        <header>Wyniki orzeczeń sądów administracyjnych</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="orzecznictwo/sa?conditions[sa_orzeczenia.wynik_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['sa_orzeczenia']['wyniki']['id'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>    
</div>