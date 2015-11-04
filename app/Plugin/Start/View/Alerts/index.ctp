<?= $this->element('Start.pageBegin'); ?>

<div class="row">
	<div class="col-md-12">
		
		<div class="overflow-auto">
			<h1 class="pull-left">Powiadomienia</h1>
			<a href="/moje-powiadomienia/obserwuje" class="btn btn-primary btn-icon submit auto-width pull-right margin-top-20">
		        <i aria-hidden="true" class="icon glyphicon glyphicon-cog"></i>
		        Sprawy, które obserwuję
		    </a>
		</div>
		
		<?
			$count = (int) @$dataBrowser['aggs']['subscribtions']['doc_count'];
			$phrase = 'Sprawy, które obserwujesz nie wygenerowały jeszcze nowych danych';
		?>
		
		<? /*
		<div class="alert alert-default text-center">
			<? if( $count ) {?>
			<p>Obserwujesz <?= pl_dopelniacz($count, 'sprawę', 'sprawy', 'spraw') ?>. <a href="/moje-powiadomienia/obserwuje">Zobacz &raquo;</a></p>
			<? } else { ?>
			<p>Aby zacząć obserwować, znajdź sprawy, które Cię interesują i kliknij na nich przycisk "Obserwuj".</p>
			<? } ?>
		</div>
		*/ ?>
		
		<?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'noResultsPhrase' => $phrase,
			'paginatorPhrases' => array('powiadomienie', 'powiadomienia', 'powiadomień'),
		)); ?>

	</div>
</div>

<?= $this->element('Start.pageEnd'); ?>
