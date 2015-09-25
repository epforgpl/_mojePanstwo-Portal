<?= $this->element('Start.pageBegin'); ?>

<? $this->Combinator->add_libs('css', $this->Less->css('collections-index', array('plugin' => 'Start'))); ?>

<div class="appBanner bottom-border">
	<h1 class="appTitle">Kolekcje</h1>
	<p class="appSubtitle">Organizuj swoje dane</p>
</div>

<?= $this->element('Dane.DataBrowser/browser-content', array(
	'displayAggs' => false,
	'app_chapters' => false,
	'forceHideAggs' => true,
	'noResultsPhrase' => 'Nie stworzyłeś jeszcze żadnych kolekcji',
)); ?>

<div class="text-center margin-bottom-30">
    <a href="/moje-kolekcje/nowe" class="btn btn-primary btn-icon submit auto-width">
        <i aria-hidden="true" class="icon glyphicon glyphicon-plus"></i>
        Stwórz nową kolekcję
    </a>
</div>

<?= $this->element('Start.pageEnd'); ?>
