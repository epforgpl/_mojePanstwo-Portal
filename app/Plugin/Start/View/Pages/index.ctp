<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">		
		<?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'noResultsPhrase' => 'Nie zarządzasz żadnymi stronami',
			'paginatorPhrases' => array('strona', 'strony', 'stron'),
			'nopaging' => true,
		)); ?>
    </div>
</div>