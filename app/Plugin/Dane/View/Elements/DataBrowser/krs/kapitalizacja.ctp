<?
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
?>

<div class="agg agg-ColumnsVertical" data-chart="<?= htmlentities(json_encode($data)) ?>">
	<div class="chart"></div>
</div>