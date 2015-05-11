<?php
$this->Combinator->add_libs('css', $this->Less->css('moja_gmina', array('plugin' => 'MojaGmina')));

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/src/scriptaculous', array('block' => 'scriptBlock'));

echo $this->Html->script('/MojaGmina/js/moja_gmina', array('block' => 'scriptBlock'));
?>


<div class="col-md-9">
	<div class="databrowser-panels">
		<div class="databrowser-panel">
			
			<h2>Znajdź swoją gminę</h2>
			
			<div id="mojaGmina">
			    <div class="locationBrowser dataContent">
			        <div class="mapsContent">
			            <div id="PLBrowser"></div>
			        </div>
			    </div>
			</div>
	
		</div>
	</div>
</div>