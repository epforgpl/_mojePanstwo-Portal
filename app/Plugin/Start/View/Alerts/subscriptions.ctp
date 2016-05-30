<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">		
		
		<div class="container">
			
			<div class="overflow-auto">
				<h1 class="pull-left">Sprawy, które obserwuję</h1>
			</div>
			
			<div class="app-banner banner-alert">
				<p>Zarządzaj sprawmi, które obserwujesz, aby dostawać powiadomienia na podstawie swoich zainteresowań.</p>
				<p><a href="/moje-powiadomienia">Zobacz swoje powiadomienia &raquo;</a></p>
			</div>
			
		</div>
		
		<?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'paginatorPhrases' => array('sprawa', 'sprawy', 'spraw'),
			'nopaging' => true,
		)); ?>
		
    </div>
</div>