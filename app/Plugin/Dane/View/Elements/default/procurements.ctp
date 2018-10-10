<? if(@$object->inner_hits['announcements']) { ?>
<div class="announcements">
	<ul class="list">
		<? foreach($object->inner_hits['announcements']['hits']['hits'] as $hit) { ?>
			<li>
				<?
					$contractors_names = [];
					foreach ($hit['_source']['contractors'] as $c) {
						if ($v = $c['Nazwa']) {
							$contractors_names[] = $v;
						}
					}
				?>
				<p class="_title">Rozstrzygnięcie z <? echo dataSlownie($hit['_source']['data_udzielenia_zamowienia']) ?></p>
				<p class="meta meta-desc">Wykonawca: <? echo implode(', ', $contractors_names) ?> <span class="sep">—</span> <? echo number_format_h($hit['_source']['wartosc_umowy']); ?> PLN</p>
			</li>
		<? } ?>
	</ul>
</div>
<? } ?>