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