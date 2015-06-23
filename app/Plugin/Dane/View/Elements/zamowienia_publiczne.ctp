<?
	$this->Combinator->add_libs('css', $this->Less->css('zamowienia_publiczne', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
	$this->Combinator->add_libs('js', '../plugins/highstock/locals');
	$this->Combinator->add_libs('js', 'Dane.zamowienia_publiczne');
?>
<div class="mp-zamowienia_publiczne" data-url="<?= urlencode($url) ?>">
	
	<div class="highstock"></div>
	
</div>