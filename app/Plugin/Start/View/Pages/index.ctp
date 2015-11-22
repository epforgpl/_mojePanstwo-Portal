<?= $this->element('Start.pageBegin'); ?>

<div class="row">
	<div class="col-md-12">

		<h1>Strony, którymi zarządzam</h1>
		
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

<?= $this->element('Start.pageEnd'); ?>
