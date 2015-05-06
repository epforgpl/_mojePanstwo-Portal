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
			<h2>Formy prawne organizacji</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>" data-choose-request="asd" data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['typ_id'])) ?>">
					    <div class="chart">
					    </div>
					</div>
				</div>
						
			</div>
		</div>
		
		<div class="databrowser-panel">
			<h2>Kapitalizacja spółek handlowych</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-ColumnsVertical" data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['kapitalizacja'])) ?>">
        <div class="chart"></div>
    </div>
				</div>
						
			</div>
		</div>
		
		<div class="databrowser-panel">
			<h2>Rejestracje nowych organizacji w czasie</h2>
			<div class="aggs-init">
				
				<div class="dataAggs">			
					<div class="agg agg-DateHistogram"
				         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['date'])) ?>">
				        
				        <div class="chart"></div>
				    </div>
				</div>
						
			</div>
		</div>
	
	</div>

</div>