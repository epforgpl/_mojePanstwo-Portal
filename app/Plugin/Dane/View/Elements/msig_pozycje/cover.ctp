<?
	
	$this->Combinator->add_libs('css', $this->Less->css('view-msig_pozycje', array('plugin' => 'Dane')));
	//$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
	//$this->Combinator->add_libs('js', '../plugins/highstock/locals');
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	$this->Combinator->add_libs('js', 'Dane.view-msig.js');
		
?>

<div id="msig_browser" data-id="<?= $object->getId(); ?>" class="row margin-top-20">
	<div class="col-md-9 margin-top-3">
		
		<div class="appBanner margin-top--50">
			<form method="get" action="">
		        <div class="appSearch form-group">
					<div class="input-group">
						<input name="q" class="form-control" placeholder="Szukaj w ogłoszeniach..." type="text">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary input-md">
		                        <span class="glyphicon glyphicon-search"></span>
		                    </button>
						</span>
					</div>
		        </div>
			</form>
		</div>
					
		<? if( $dzialy = @$dataBrowser['aggs']['dzialy']['buckets'] ) {?>
		<ul class="chapters_ul margin-bottom-20">
		<? foreach( $dzialy as $dzial ) {?>
			<li class="chapter" data-id="<?= $dzial['key'] ?>">
				
				<a class="link" href="#dzial-<?= $dzial['key'] ?>">
					<p class="title"><span class="glyphicon glyphicon-menu-right"></span><?= $dzial['nazwa']['buckets'][0]['key'] ?></p>
					<p class="count" title="<?= strip_tags(pl_dopelniacz($dzial['nazwa']['buckets'][0]['doc_count'], 'ogłoszenie', 'ogłoszenia', 'ogłoszeń')) ?>"><span class="glyphicon glyphicon-menu-hamburger"></span> <?= $dzial['nazwa']['buckets'][0]['doc_count'] ?></p>
				</a>
				
				<div class="results_cont">
					<ul class="results">
						
					</ul>
				</div>
				
				<div class="spinner_cont">
					<div class="spinner grey">
			            <div class="bounce1"></div>
			            <div class="bounce2"></div>
			            <div class="bounce3"></div>
			        </div>
				</div>
			
			</li>
		<? } ?>
		</ul>
		<? } ?>
		
	</div>
</div>