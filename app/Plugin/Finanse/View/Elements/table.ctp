<?
	$meta_fields = array('id', 'parent_id');
?>
<div class="tab-pane fade<? if($active) {?>  active in<? } ?>" id="<?= $table['table']['table'] ?>">
	
	<table class="table-data margin-top-20" border="0" cellpadding="0" cellspacing="0">
		<tr class="header">
			<? foreach( $table['columns'] as $col ) { if( !in_array($col['field'], $meta_fields) ) { ?>
			<th><?= $col['title'] ? $col['title'] : 'no title' ?></th>
			<? } } ?>
		</tr>
		<? foreach( $table['data'] as $d ) {?>
		<tr<? if( $d['parent_id'] ) {?> class="child"<? } ?> data-depth="0" data-id="<?= $d['id'] ?>" data-parent_id="<?= $d['parent_id'] ?>">
			<? foreach( $table['columns'] as $col ) { if( !in_array($col['field'], $meta_fields) ) { ?>
			<td><?= $d[ $col['field'] ] ?></td>
			<? } } ?>
		</tr>
		<? } ?>
	</table>
	
	<p class="text-center margin-top-30 margin-bottom-30">
		<a href="/docs/<?= $table['table']['document_id'] ?>" target="_blank">Dokument</a>
	</p>
	
</div>