<?= $this->element('Start.pageBegin'); ?>

<div class="appBanner bottom-border">
	<h1 class="appTitle">Strony, którymi zarządzam</h1>
</div>

<?= $this->element('Dane.DataBrowser/browser-content', array(
	'displayAggs' => false,
	'app_chapters' => false,
	'forceHideAggs' => true,
	'noResultsPhrase' => 'Nie zarządzasz żadnymi stronami',
	'paginatorPhrases' => array('strona', 'strony', 'stron'),
	'nopaging' => true,
)); ?>

<?= $this->element('Start.pageEnd'); ?>
