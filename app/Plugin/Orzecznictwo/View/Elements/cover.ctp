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
        <header>Przeglądaj według tematów</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg">
	                <ul class="row">
	                <? foreach( $dataBrowser['aggs']['sa_orzeczenia']['hasla']['id']['buckets'] as $item ) { ?>
	                	<li class="col-sm-6"><?= $item['label']['buckets'][0]['key'] ?></li>
	                <? } ?>
	                </ul>
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
                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.forma_prawna_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['sa_orzeczenia']['wyniki']['id'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>    
</div>