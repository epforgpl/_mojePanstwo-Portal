<?= $this->element('Start.pageBegin'); ?>

<div class="row">
	<div class="col-md-12">

		<h1>Sprawy, które obserwuję:</h1>
		
		<?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'paginatorPhrases' => array('sprawa', 'sprawy', 'spraw'),
			'nopaging' => true,
		)); ?>

	</div>
</div>

<?= $this->element('Start.pageEnd'); ?>
