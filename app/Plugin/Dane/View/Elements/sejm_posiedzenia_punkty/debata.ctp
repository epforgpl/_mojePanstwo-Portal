<div class="objectRender">

	<p class="title">
    	<a href="<?= $object->getUrl() ?>">Debata &mdash; <?= dataSlownie( $object->getDate() ) ?></a>
	</p>
	<? if( $object->getData('liczba_wystapien') ) { ?>
	<a href="<?= $object->getUrl() ?>"><img src="http://resources.sejmometr.pl/stenogramy/subpunkty/<?= $object->getId() ?>.jpg" /></a>
	<? } ?>
	<p class="meta meta-desc"><?= $object->getMetaDescription('dzien'); ?></p>
		
</div>