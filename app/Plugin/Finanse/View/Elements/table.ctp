<?
	$meta_fields = array('id', 'parent_id');
?>
<div class="tab-pane fade<? if($active) {?>  active in<? } ?>" id="<?= $table['table']['table'] ?>">
	
	<? if( $table['table']['unit'] ) {?>
		<p class="unit">Jednostka: <b><?= $table['table']['unit'] ?></b></p>
	<? } ?>
	
	<table class="table-data margin-top-20" border="0" cellpadding="0" cellspacing="0">
		<tr class="header">
			<? foreach( $table['columns'] as $col ) { if( !in_array($col['field'], $meta_fields) ) { ?>
			<th data-rowspan="<?= @$col['rowspan'] ?>"><?= $col['title'] ? $col['title'] : 'no title' ?></th>
			<? } } ?>
		</tr>
		<? foreach( $table['data'] as $d ) {?>
		<tr<? if( $d['parent_id'] ) {?> class="child"<? } ?> data-depth="0" data-id="<?= $d['id'] ?>" data-parent_id="<?= $d['parent_id'] ?>">
			<? foreach( $table['columns'] as $col ) { if( !in_array($col['field'], $meta_fields) ) { ?>
			<td><?= $this->FVal->val($d[ $col['field'] ], $col['type']) ?></td>
			<? } } ?>
		</tr>
		<? } ?>
	</table>
	
	<p class="text-center margin-top-50 margin-bottom-30">
		<a href="/finanse/<?= $this->request->params['action'] ?>-<?= $table['table']['name'] ?>.csv"><span class="glyphicon glyphicon-download" style="font-size: 17px; position: relative; top: 2px;"></span> Pobierz dane (csv)</a> <span class="margin-sides-10">&middot;</span> <a href="/docs/<?= $table['table']['document_id'] ?>" target="_blank"><span class="glyphicon glyphicon-new-window"></span> Dokument źródłowy</a>
	</p>
	
</div>