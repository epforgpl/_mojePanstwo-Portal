<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">		
		
		<div class="container">

			<div class="header-wrap">
				<h1 class="pull-left smaller">Powiadomienia</h1>
	            <a href="/moje-powiadomienia/obserwuje"
	               class="btn btn-primary btn-icon submit width-auto pull-right margin-top-20">
			        <i aria-hidden="true" class="icon glyphicon glyphicon-cog"></i>
			        Sprawy, które obserwuję
			    </a>
			</div>
								
		</div>
		
		<?
			$count = (int) @$dataBrowser['aggs']['subscribtions']['doc_count'];
			$phrase = 'Sprawy, które obserwujesz nie wygenerowały jeszcze nowych danych';
		?>

        <?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'noResultsPhrase' => $phrase,
			'paginatorPhrases' => array('powiadomienie', 'powiadomienia', 'powiadomień'),
		)); ?>
		
    </div>
</div>
