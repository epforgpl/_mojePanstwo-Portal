<?
	$this->Combinator->add_libs('css', $this->Less->css('highstock_browser', array('plugin' => 'Dane')));
    $this->Combinator->replace_lib_or_add('js', '../plugins/highcharts/js/highcharts', '../plugins/highstock/js/highstock');
$this->Combinator->replace_lib_or_add('js', '../plugins/highcharts/locals', '../plugins/highstock/locals');
	$this->Combinator->add_libs('js', 'Dane.highstock_browser');

	$output = array();
	foreach( $histogram as $b )
		$output[] = array($b['key'], (float) $b['suma']['value']);

	if( !isset($mode) )
		$mode = false;

?>
<div class="mp-highstock_browser" <?= printf('data-histogram="%s"', htmlspecialchars(json_encode($output), ENT_QUOTES, 'UTF-8')) ?>>

	<div class="highstock"></div>
    <div class="dataAggs">
    	<?= $this->element('Dane.highstock_browser/' . $preset, array(
    		'options' => $options,
    	)); ?>
    </div>

</div>
