<?= $this->element('Start.pageBegin'); ?>

<div class="appBanner">
	<h1 class="appTitle">Powiadomienia</h1>
	<p class="appSubtitle">Otrzymuj powiadomienia o sprawach, które Cię interesują</p>
</div>

<?
	$count = (int) @$dataBrowser['aggs']['subscribtions']['doc_count'];
	$phrase = 'Sprawy, które obserwujesz nie wygenerowały jeszcze nowych danych';
?>

<div class="alert alert-default text-center">
	<? if( $count ) {?>
	<p>Obserwujesz <?= pl_dopelniacz($count, 'sprawę', 'sprawy', 'spraw') ?>. <a href="/moje-powiadomienia/obserwuje">Zobacz &raquo;</a></p>
	<? } else { ?>
	<p>Aby zacząć obserwować, znajdź sprawy, które Cię interesują i kliknij na nich przycisk "Obserwuj".</p>
	<? } ?>
</div>

<?= $this->element('Dane.DataBrowser/browser-content', array(
	'displayAggs' => false,
	'app_chapters' => false,
	'forceHideAggs' => true,
	'noResultsPhrase' => $phrase,
)); ?>

<?= $this->element('Start.pageEnd'); ?>
