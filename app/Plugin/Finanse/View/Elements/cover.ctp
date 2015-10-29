<?
$this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/themes/dark-unica');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Finanse.budzety');
// $this->Combinator->add_libs('js', 'Finanse.budzety-tiles');
?>
<div class="col-xs-12">
    <div class="appBanner">
        <h1 class="appTitle">Finanse publiczne</h1>

        <p class="appSubtitle">Poznaj stan finansów publicznych Polski.</p>
    </div>
</div>
</div>
</div>
<div class="col-xs-12 finanseBlock">

    <div class="chart"
         data-json='<?php echo json_encode($dataBrowser['aggs']['budzety']['top']['hits']['hits']); ?>'></div>

    <div class="mid-chart"></div>
    <div class="chart2"></div>

</div>

<div class="container">
<div class="row dataBrowserContent">

	<div id="compare" class="col-xs-12">
	
		<div class="appBanner">
	        <p class="appSubtitle">Porównaj stan finansów publicznych w wybranych latach.</p>
	    </div>
		
		
		<div class="row head">
			<div class="col-sm-2">
			</div><div class="col-sm-4">
				<h2>Rok 2015</h2>
				<p><a href="#">Wybierz inny rocznik</a></p>
			</div><div class="col-sm-4">
				<h2>Rok 2014</h2>
				<p><a href="#">Wybierz inny rocznik</a></p>
			</div>
		</div>
		
		
		
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Premier w chwili uchwalania budżetu:</h3>
			</div>
			<div class="col-sm-4">
				<img width="30" alt="" src="//resources.sejmometr.pl/mowcy/a/1/396.jpg">
				<p>Donald Tusk</p>
			</div><div class="col-sm-4">
				<img width="30" alt="" src="//resources.sejmometr.pl/mowcy/a/1/138.jpg">
				<p>Jarosław Kaczyński</p>
			</div>
		</div>
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Zadłużenie na koniec roku:</h3>
			</div>
			<div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-2">
				<p class="value">5%</p>
			</div>
		</div>
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Produkt Krajowy Brutto:</h3>
			</div>
			<div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-2">
				<p class="value">5%</p>
			</div>
		</div>
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Inflacja:</h3>
			</div>
			<div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-2">
				<p class="value">5%</p>
			</div>
		</div>
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Wydatki budżetu państwa:</h3>
			</div>
			<div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-2">
				<p class="value">5%</p>
			</div>
		</div>
		<div class="row data internal">
			<div class="col-sm-8 col-sm-offset-2">
				<h4>Wzrosły wydatki na:</h4>
			</div>
		</div>
		<div class="row data internal">
			<div class="col-sm-8 col-sm-offset-2">
				<h4>Spadły wydatki na:</h4>
			</div>
		</div>
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Dochody budżetu państwa:</h3>
			</div>
			<div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-2">
				<p class="value">5%</p>
			</div>
		</div>
		<div class="row data internal">
			<div class="col-sm-8 col-sm-offset-2">
				<h4>Wzrosły wpływy z:</h4>
			</div>
		</div>
		<div class="row data internal">
			<div class="col-sm-8 col-sm-offset-2">
				<h4>Spadły wpływy z:</h4>
			</div>
		</div>
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Deficyt budżetu państwa:</h3>
			</div>
			<div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-2">
				<p class="value">5%</p>
			</div>
		</div>
		<div class="row data">
			<div class="col-sm-2 _label">
				<h3>Stopa bezrobocia:</h3>
			</div>
			<div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-4">
				<p class="value">345.32 mld zł</p>
			</div><div class="col-sm-2">
				<p class="value">5%</p>
			</div>
		</div>
		
		
		
	
	</div>

	

