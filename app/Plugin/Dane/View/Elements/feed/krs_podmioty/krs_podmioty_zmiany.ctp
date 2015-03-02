<div class="object_feed_element"><?= $this->element('Dane.objects/krs_podmioty_zmiany/' . $object->getData('typ_id'), array(
	'data' => $object->getStatic(),
	'mode' => 'short',
)); ?>
</div>
<p class="text-left col-lg-12"><a href="<?= $object->getUrl() ?>">Więcej &raquo;</a></p>