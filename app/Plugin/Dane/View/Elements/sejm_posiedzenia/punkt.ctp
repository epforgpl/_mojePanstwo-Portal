<div class="objectRender" data-id="<?= $object->getId() ?>">
	
	<? if($object->getData('numer')) { ?>
	<div class="number-div">
		
		<span><?= $object->getData('numer') ?></span>
		
	</div>
	<? } ?>
	
	<div class="number-div-content">
		
		<p class="title">
	    	<a href="<?= $object->getUrl() ?>" title="<?= htmlentities( $object->getTitle() ) ?>"><?= $this->Text->truncate( $object->getTitle(), 185 ) ?></a>
		</p>
		<p class="meta meta-desc"><?= $object->getMetaDescription('posiedzenie'); ?></p>
		
		<? if( $glosowania = $object->getOptions('glosowania') ) { ?>
		<ul class="glosowania">
			<? foreach( $glosowania as $g ) {
				echo $this->Dataobject->render($g, 'default', array(
        			'truncate' => 185,
    			));
			} ?>
		</ul>
		<? } ?>
		
	</div>
</div>