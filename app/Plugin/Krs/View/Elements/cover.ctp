<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>

<div class="col-xs-12 col-md-3 col-sm-4 dataAggsContainer">
    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

	    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>

    </div>
</div>


<div class="col-xs-12 col-md-9 col-sm-8">

    <div class="dataWrap">
        <div class="appBanner bottom-border">
            <h1 class="appTitle">Krajowy Rejestr Sądowy</h1>

            <p class="appSubtitle">Przeglądaj informacje o organizacjach gospodarczych.</p>
        </div>
    </div>

    <div class="block col-xs-12">
        <header>Formy prawne organizacji</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.forma_prawna_id]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['typ_id'])) ?>">
                    <div class="chart">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Kapitalizacja spółek handlowych</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-ColumnsVertical"
                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.wartosc_kapital_zakladowy]="
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['kapitalizacja'])) ?>">
                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>

    <div class="block col-xs-12">
        <header>Rejestracje nowych organizacji w czasie</header>

        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-DateHistogram"
                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['date'])) ?>">

                    <div class="chart"></div>
                </div>
            </div>
        </section>
    </div>
</div>
