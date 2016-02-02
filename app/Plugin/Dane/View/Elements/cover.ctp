<?
	echo $this->Combinator->add_libs('css', $this->Less->css('view', array('plugin' => 'Dane')));
?>
<div class="col-xs-12">
    
    <div class="appBanner">
        <h1 class="appTitle">Dane publiczne</h1>
        <p class="appSubtitle">Zbiory danych publicznych dostępnych na portalu mojePaństwo</p>        
    </div>
    
    <?
	    if( $datasets = @$dataBrowser['aggs']['top']['hits']['hits'] ) {
	?>
	<div class="datasets">
		<div class="row">
			<?
				foreach( $datasets as $d ) {
					$d = $d['_source']['data']['zbiory'];
			?>
			<div class="col-md-4 col-sm-6">
				<a href="/dane/<?= $d['slug'] ?>" class="dataset">
					<p class="objectRender <?=$d['slug']?>">
						<span class="object-icon icon-datasets-<?= $d['slug'] ?>"></span>
					</p>
					<p class="nazwa"><?= $d['nazwa'] ?></p>
					<div class="opis"><?= $d['opis'] ?></div>
					<p class="liczba"><?= pl_dopelniacz($d['liczba_dokumentow'], 'dokument', 'dokumenty', 'dokumentów') ?></p>
				</a>
			</div>
			<? } ?>
		</div>
	</div>
	<? } ?>
    
</div>