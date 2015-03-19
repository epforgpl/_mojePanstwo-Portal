<?
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
?>

<div id="browser_columns_horizontal"></div>
<script type="text/javascript">
    if(_columns_horizontal_data === undefined)
        var _columns_horizontal_data = <?= json_encode($data); ?>
</script>