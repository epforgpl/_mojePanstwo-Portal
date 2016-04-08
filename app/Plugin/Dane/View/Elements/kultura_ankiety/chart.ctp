<div class="tab-pane fade<? if(isset($active)) {?>  active in<? } ?>" id="<?= $param ?>">
	
	<div class="block nobg block-captions">
		<section class="content">
			<table cellpadding="0" cellspacing="0" border="0">
				
				<tr>
					<th></th>
					<? foreach( $columns as $col ) {?>
					<th><?= $col ?></th>
					<? } ?>
				</tr>
				
				<? foreach( $captions as $c ) { ?>
				<tr data-caption_id="<?= $c['id'] ?>">
					<td class="cap"><?= $c['title'] ? $c['title'] : "&nbsp;" ?></td>
					<?
						foreach( $columns as $col_id => $col ) {
							$filter_query = http_build_query(array(
								$param => $col_id,
							));
					?>
					<td>
						<?= round($data[ $filter_query ][ $c['id'] ], 1); ?>%
					</td>
					<?
						}
					?>					
				</tr>
				<? } ?>
				
			</table>
		</section>
	</div>

</div>