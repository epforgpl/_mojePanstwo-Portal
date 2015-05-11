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
			<h2>Ostatnie posiedzenie Sejmu</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['posiedzenia']['doc_count'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['posiedzenia']['top']['hits']['hits'] as $doc ) {?>
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
			<h2>Najnowsze projekty w Sejmie</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['druki']['doc_count'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['druki']['top']['hits']['hits'] as $doc ) {?>
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
			<h2>Zawody posłów</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>" data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.forma_prawna_id]=" data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['poslowie']['zawod'])) ?>">
					    <div class="chart">
					    </div>
					</div>
				</div>
						
			</div>
		</div>
		
		<div class="databrowser-panel">
			<h2>Kluby sejmowe</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-ColumnsHorizontal" data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.wartosc_kapital_zakladowy]=" data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['poslowie']['klub_id'])) ?>">
        <div class="chart"></div>
    </div>
				</div>
						
			</div>
		</div>
		
		<div class="databrowser-panel">
			<h2>Posłowie według płci</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>" data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.forma_prawna_id]=" data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['poslowie']['plec'])) ?>">
					    <div class="chart">
					    </div>
					</div>
				</div>
						
			</div>
		</div>
		
		<div class="databrowser-panel">
			<h2>Najnowsze interpelacje</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['interpelacje']['doc_count'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['interpelacje']['top']['hits']['hits'] as $doc ) {?>
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
			<h2>Najnowsze komunikaty Kancelarii Sejmu</h2>
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['komunikaty']['doc_count'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['komunikaty']['top']['hits']['hits'] as $doc ) {?>
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
	
	</div>

</div>