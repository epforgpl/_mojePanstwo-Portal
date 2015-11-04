<div class="collections-note">
	<? if( isset($object->collection['note']) && $object->collection['note'] ) { ?>
		<div class="alert alert-info"><?= htmlspecialchars($object->collection['note']) ?></div>
	<? } ?>
</div>