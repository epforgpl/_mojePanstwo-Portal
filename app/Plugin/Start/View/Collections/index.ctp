<? $this->Combinator->add_libs('css', $this->Less->css('collections-index', array('plugin' => 'Start'))); ?>

<?= $this->element('Start.pageBegin'); ?>

<div class="overflow-auto">
	<h1 class="pull-left">Moje Kolekcje</h1>
	<a href="/moje-kolekcje/nowe" class="btn btn-primary btn-icon submit auto-width pull-right margin-top-20">
        <i aria-hidden="true" class="icon glyphicon glyphicon-plus"></i>
        Stwórz nową kolekcję
    </a>
</div>

<?= $this->element('Dane.DataBrowser/browser-content', array(
	'displayAggs' => false,
	'app_chapters' => false,
	'forceHideAggs' => true,
	'noResultsPhrase' => 'Nie stworzyłeś jeszcze żadnych kolekcji',
)); ?>

<?= $this->element('Start.pageEnd'); ?>
