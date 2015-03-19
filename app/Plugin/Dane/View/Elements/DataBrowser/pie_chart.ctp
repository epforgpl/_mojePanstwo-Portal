<?
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
?>

<div id="browser_pie_chart"></div>
<script type="text/javascript">
    if(_pie_chart_data === undefined)
        var _pie_chart_data = <?= json_encode($data); ?>
</script>