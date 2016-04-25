<div class="objectRender">

	<p class="title">
    	<a href="<?= $object->getUrl() ?>" title="<?= htmlentities( $object->getTitle() ) ?>"><?= $this->Text->truncate($object->getTitle(), 185) ?></a>
	</p>
	<? if( $object->getData('liczba_wystapien') ) { ?>
	<a href="<?= $object->getUrl() ?>" title="<?= htmlentities( $object->getTitle() ) ?>"><img src="http://resources.sejmometr.pl/stenogramy/subpunkty/<?= $object->getId() ?>.jpg" /></a>
	<? } ?>
	<p class="meta meta-desc"><?= $object->getMetaDescription('dzien'); ?></p>
		
</div>