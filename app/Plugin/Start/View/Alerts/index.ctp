<?
	echo $this->Html->css($this->Less->css('app'));
    $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
	
	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">		
		
		<div class="container">
			
			<div class="overflow-auto">
				<h1 class="pull-left">Moje powiadomienia</h1>
			</div>
			
			<div class="app-banner banner-alert">
				<p>Dzięki tej usłudze możesz być powiadomiany o nowych danych związanych ze sprawami, które obserwujesz. Poniżej widzisz powiadomienia o nowych danych na podstawie Twoich zainteresowań.</p>
				<p><a href="/moje-powiadomienia/obserwuje">Zarządzaj sprawami, które obserwujesz &raquo;</a></p>
			</div>
			
			<? /*
			<div class="header-wrap">
				<h1 class="pull-left smaller">Moje powiadomienia</h1>
	            <a href="/moje-powiadomienia/obserwuje"
	               class="btn btn-primary btn-icon submit width-auto pull-right margin-top-20">
			        <i aria-hidden="true" class="icon glyphicon glyphicon-cog"></i>
			        Sprawy, które obserwuję
			    </a>
			</div>
			*/ ?>
			
			<? echo $this->Element('Dane.dataobject/feed'); ?> 
							
		</div>
				
    </div>
</div>
