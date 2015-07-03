<?
	$this->Combinator->add_libs('css', $this->Less->css('zamowienia_publiczne', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
	$this->Combinator->add_libs('js', '../plugins/highstock/locals');
	$this->Combinator->add_libs('js', 'Dane.zamowienia_publiczne');
	
	$output = array();
	foreach( $histogram as $b ) {
										
		if( 
			isset($b['wykonawcy']['waluty']) && 
			isset($b['wykonawcy']['waluty']['buckets']) && 
			!empty($b['wykonawcy']['waluty']['buckets'])
		) {
			
			$waluty = array();
			foreach( @$b['wykonawcy']['waluty']['buckets'] as $w )
				$waluty[ $w['key'] ] = $w['suma']['value'];
			
			if( isset($waluty['PLN']) )						
				$output[] = array(
					$b['key'], $waluty['PLN'],
				);						
			
		}
						
	}	
?>
<div class="mp-zamowienia_publiczne" data-url="<?= urlencode($url) ?>" <?= printf('data-histogram="%s"', htmlspecialchars(json_encode($output), ENT_QUOTES, 'UTF-8')) ?> <?= printf('data-request="%s"', htmlspecialchars(json_encode($request), ENT_QUOTES, 'UTF-8')) ?>>	
	
	<div class="highstock"></div>
    <div class="dataAggs">
        <div class="agg" data-agg_id="dokumenty"></div>
    </div>

</div>