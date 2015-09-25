<?= $this->element('Start.pageBegin'); ?>

<h1>Obserwujesz:</h1>

<?= $this->element('Dane.DataBrowser/browser-content', array(
	'displayAggs' => false,
	'app_chapters' => false,
	'forceHideAggs' => true,
	'paginatorPhrases' => array('sprawa', 'sprawy', 'spraw'),
)); ?>

<?= $this->element('Start.pageEnd'); ?>
