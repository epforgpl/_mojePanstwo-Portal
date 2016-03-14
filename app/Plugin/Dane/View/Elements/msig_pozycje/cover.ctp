<?
	
	$this->Combinator->add_libs('css', $this->Less->css('view-msig_pozycje', array('plugin' => 'Dane')));
	//$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
	//$this->Combinator->add_libs('js', '../plugins/highstock/locals');
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	
?>

<div class="row margin-top-20">
	<div class="col-md-9 margin-top-3">
		
		<div class="appBanner margin-top--35 margin-bottom-50">
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
					
		<? if( $_dzialy ) {?>
		<ul class="list-group toc">
			<? foreach( $_dzialy as $dzial ) { ?>
			<li class="list-group-item">
				<h2><a href="?conditions[msig_dzialy.typ_id]=<?= $dzial['id'] ?>"><?= $dzial['title'] ?> <span class="badge"><?= $dzial['count'] ?></span></a></h2>
				<? if( $formy = $dzial['formy'] ) { ?>
				<ul class="list-group">
					<? foreach( $formy as $forma ) {?>
					<li class="list-group-item">
						<h3><a href="?conditions[msig_dzialy.typ_id]=<?= $dzial['id'] ?>&conditions[msig_pozycje.krs_forma_prawna_id]=<?= $forma['id'] ?>"><?= $forma['title'] ?> <span class="badge"><?= $forma['count'] ?></span></a></h3>
					</li>
					<? } ?>
				</ul>
				<? } ?>
			</li>
			<? } ?>
		</ul>
		<? } ?>
		
		<? if( $formy = @$dataBrowser['aggs']['formy']['buckets'] ) {?>
		<ul>
			<? foreach( $formy as $forma ) { ?>
			<li>
				<h2><?= $forma['title'] ?> <span class="badge"><?= $forma['doc_count'] ?></span></h2>
				<? if( $dzialy = $forma['dzialy']['buckets'] ) { ?>
				<ul>
					<? foreach( $dzialy as $dzial ) {?>
					<li>
						<h3><?= $dzial['title'] ?> <span class="badge"><?= $dzial['doc_count'] ?></span></h3>
					</li>
					<? } ?>
				</ul>
				<? } ?>
			</li>
			<? } ?>
		</ul>
		<? } ?>
		
	</div>
</div>