<?php
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('css', $this->Less->css('srodowisko', array('plugin' => 'Srodowisko')));
$this->Combinator->add_libs('js', 'Srodowisko.view.js');

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
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
		<div class="col-md-7">
			
			<div id="mapBrowser">
				<div class="map"></div>
			</div>
			
		</div>
		<div class="col-md-5">
			<div class="stationContent"></div>
		</div>
	</div>
	
    <script type="text/javascript">
	    var stations = <?= json_encode(array_column(array_column(array_column($dataBrowser['aggs']['stacje']['top']['hits']['hits'], '_source'), 'data'), 'srodowisko_stacje_pomiarowe')) ?>;
    </script>

</div>
