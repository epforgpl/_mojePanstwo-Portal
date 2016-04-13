<? 
	if( $isAdmin ) {
		$this->Combinator->add_libs('css', $this->Less->css('tables-admin', array('plugin' => 'Finanse')));
		$this->Combinator->add_libs('js', 'Finanse.tables-admin.js');	
?>
<div id="btn-switchers" class="text-center margin-bottom-20">
	<div class="btn-group">
		<a href="#" data-mode="browse" class="btn btn-success">Przeglądanie</a>
		<a href="#" data-mode="edit" class="btn btn-default">Edycja</a>
	</div>
</div>
<? } ?>

<? $first = true; ?>
<ul class="nav nav-tabs">
<? foreach( $tables as $table ) { ?>
	<li<? if($first) {?> class="active"<? } ?>><a aria-expanded="<?= $first ? 'true' : 'false' ?>" href="#<?= $table['table']['table'] ?>" data-toggle="tab"><?= $table['table']['name'] ?></a></li>
<? $first = false; } ?>
</ul>

<div id="tables" class="tab-content">
<?	
	$first = true;
	foreach( $tables as $table ) {
		
		echo $this->element('Finanse.table', array(
			'table' => $table,
			'active' => $first,
		));
		
		$first = false;
		
	}
?>
</div>