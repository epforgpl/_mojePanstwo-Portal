<div class="objectRender">
	
	<? if( $punkty = $object->getStatic('punkty') ) {?>
	<ul class="punkty_nr">
		<? foreach( $punkty as $p ) { ?>
		<li><a class="badge" href="/dane/instytucje/3214,sejm/punkty/<?= $p['id'] ?>"><?= $p['nr'] ?></a></li>
		<? } ?>	
	</ul>
	<? } ?>
	
	<div<? if($punkty) {?> class="punkty-offset"<? } ?>>
		<p class="title">
	    	<a href="<?= $object->getUrl() ?>" title="<?= htmlentities( $object->getTitle() ) ?>"><?= $this->Text->truncate($object->getTitle(), 185) ?></a>
		</p>
		<? if( $object->getData('liczba_wystapien') ) { ?>
		<a href="<?= $object->getUrl() ?>" title="<?= htmlentities( $object->getTitle() ) ?>"><img src="http://resources.sejmometr.pl/stenogramy/subpunkty/<?= $object->getId() ?>.jpg" /></a>
		<? } ?>
		<p class="meta meta-desc"><?= $object->getMetaDescription('dzien'); ?></p>
	</div>
		
</div>