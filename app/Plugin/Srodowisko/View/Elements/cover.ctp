<?php

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('css', $this->Less->css('srodowisko', array('plugin' => 'Srodowisko')));
$this->Combinator->add_libs('js', 'Srodowisko.view.js');

$this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock'));

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.22&libraries=geometry&language=' . $lang, array('block' => 'scriptBlock'));
?>

<div class="col-xs-12">

    <div class="appBanner">

        <h1 class="appTitle">Środowisko naturalne</h1>
        <p class="appSubtitle">Informacje o jakości powietrza w Polsce</p>

		<form action="/srodowisko" method="get">
	        <div class="appSearch form-group">
	            <div class="input-group">
	                <input class="form-control" placeholder="Szukaj stacji pomiarowych..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
	                        <span class="glyphicon glyphicon-search"></span>
	                    </button>
					</span>
	            </div>
	        </div>
		</form>
    </div>
	
	<div class="row">
		<div class="col-md-6">
			
			<div id="mapBrowser">
				<div class="map"></div>
			</div>
			
		</div>
		<div class="col-md-6">
			<div class="stationContent"></div>
		</div>
	</div>
	
	<div class="row margin-top-30">
		<div class="col-md-12">
			<div class="ranking-buttons">
				<ul class="nav nav-tabs">
					<?php foreach(array(
						'latest' => 'Bieżące odczyty',
						'1d' => 'Ostatnie 3 dni',
						'1w' => 'Ostatni tydzień',
						'1m' => 'Ostatni miesiąc') as $option => $name) { ?>
						<li<? if($option == 'latest') echo ' class="active"'; ?>>
							<a href="#<?= $option ?>" data-option-value="<?= $option ?>" data-toggle="tab"><?= $name ?></a>
						</li>
					<? } ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="row margin-top-10">
		<div class="col-md-6">
			
			<div id="worst-places" class="block places">
				<header>Najbardziej zanieczyszone miejsca:</header>
				<section class="content">
					
				</section>
			</div>
			
		</div><div class="col-md-6">
			
			<div id="best-places" class="block places">
				<header>Najmniej zanieczyszone miejsca:</header>
				<section class="content">
					
				</section>
			</div>
			
		</div>
	</div>

	<div class="row margin-top-20">
		<div class="col-md-12 text-center">
			<p class="text-muted">
				Aplikacja powstaje we współpracy z <a href="/fundacja-clientearth-poland" title="Fundacja ClientEarth Poland">Fundacją ClientEarth Poland</a>
				<br/>
				<a href="/fundacja-clientearth-poland" title="Fundacja ClientEarth Poland">
					<img class="image margin-top-5" src="/img/partnerzy/client-earth-logo.png" alt="Fundacja ClientEarth Poland"/>
				</a>
			</p>
		</div>
	</div>
	
	
    <script type="text/javascript">
	    var stations = <?= json_encode(array_column(array_column(array_column($dataBrowser['aggs']['stacje']['top']['hits']['hits'], '_source'), 'data'), 'srodowisko_stacje_pomiarowe')) ?>;
    </script>

</div>

<div class="modal fade bs-example-modal-sm" id="dateRangeChartModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeChartModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 id="exampleModalLabel">Wybierz zakres</h4>
			</div>
			<div class="modal-body">
				<div class="input-daterange input-group" id="datepicker">
					<input type="text" value="<?= date('Y-m-d', time() - 2592000) ?>" class="input-sm form-control" name="start" />
					<span class="input-group-addon">do</span>
					<input type="text" value="<?= date('Y-m-d') ?>" class="input-sm form-control" name="end" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
				<button type="button" class="btn btn-primary applyDateRange">Zastosuj</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-sm" id="morePlacesModal" tabindex="-1" role="dialog" aria-labelledby="morePlacesModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="margin-top-0"></h3>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
			</div>
		</div>
	</div>
</div>
