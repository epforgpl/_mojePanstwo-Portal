<div class="content col-xs-12">

    <p class="title"><a href="<?= $object->getUrl() ?>">Debata</a></p>
	
	<? if( $object->getData('liczba_wystapien') ) {?>
		<div class="aoverflow">
			<p class="pull-left margin-sides-5 margin-right-10"><a href="<?= $object->getUrl() ?>"><img src="http://resources.sejmometr.pl/stenogramy/subpunkty/<?= $object->getId() ?>.jpg" /></a></p>
			
			<p class="meta meta-desc">
				<?= $object->getMetaDescription('dzien') ?>
			</p>
		</div>
		
	<? } else { ?>
		
		<p class="meta meta-desc">
			<?= $object->getMetaDescription('dzien') ?>
		</p>
		
	<? } ?>
	
	


</div>
