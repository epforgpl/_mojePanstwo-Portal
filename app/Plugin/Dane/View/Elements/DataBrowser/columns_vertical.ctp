<?
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
?>

<div id="browser_columns_vertical"></div>
<script type="text/javascript">
    if(_columns_vertical_data === undefined)
        var _columns_vertical_data = <?= json_encode($data); ?>
</script>