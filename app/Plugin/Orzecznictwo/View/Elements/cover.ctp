<?
$this->Combinator->add_libs('css', $this->Less->css('orzecznictwo', array('plugin' => 'Orzecznictwo')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>

<div class="col-xs-12">

    <div class="appBanner">
        <h1 class="appTitle">Orzecznictwo</h1>
        <p class="appSubtitle">Przeglądaj orzeczenia sądów w Polsce.</p>
		
		<form action="" method="get">
	        <div class="appSearch form-group">
				<div class="input-group">
					<input name="q" class="form-control" placeholder="Szukaj orzeczeń..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
	                        <span class="glyphicon glyphicon-search"></span>
	                    </button>
					</span>
				</div>
	        </div>
		</form>
    </div>

</div>







<? /*
<div class="col-xs-12 col-md-3 dataAggsContainer">
    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
</div>

<div class="col-xs-12 col-md-9">
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
*/ ?>
