<?= $this->element('Start.pageBegin'); ?>

<div class="appBanner">
	<h1 class="appTitle">Powiadomienia</h1>
	<p class="appSubtitle">Otrzymuj powiadomienia o danych, które Cię interesują</p>
</div>

<div class="alert alert-default text-center">
	<p>Obserwujesz 13 rzeczy. <a href="/moje-powiadomienia/obserwuje">Zobacz &raquo;</a></p>
</div>

<?= $this->element('Dane.DataBrowser/browser-content', array(
	'displayAggs' => false,
	'app_chapters' => false,
	'forceHideAggs' => true,
)); ?>

<?= $this->element('Start.pageEnd'); ?>
