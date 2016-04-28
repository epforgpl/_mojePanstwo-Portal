<? if($neighboors) { ?>
<p class="neighboors">
	
	<? if($neighboors['prev']) { ?>
	<a href="<?= $neighboors['prev']['url'] ?>" title="<?= htmlentities( $neighboors['prev']['label'] ) ?>">&laquo; Poprzednia debata</a>
	<? } ?>
	
	<? if( $neighboors['prev'] && $neighboors['next'] ) { ?> &middot; <? } ?>
		
	<? if($neighboors['next']) { ?>
	<a href="<?= $neighboors['next']['url'] ?>" title="<?= htmlentities( $neighboors['next']['label'] ) ?>">Następna debata &raquo;</a>
	<? } ?>

</p>
<? } ?>