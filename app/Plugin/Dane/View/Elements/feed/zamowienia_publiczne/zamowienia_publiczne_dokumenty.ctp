<?

	$forceLabel = false;
		
?>

<div class="content<? if ($object->getPosition()) { ?> col-md-11<? } ?>">


    <? if ($object->force_hl_fields || $forceLabel) { ?>
        <p class="header">
            <?= $object->getLabel(); ?>
        </p>
    <? } ?>
	
	<? if( $object->getData('typ_id')=='6' ) { ?>
	
	<p class="col-lg-12 pull-top-right">
		<a href="<?= $object->getUrl() ?>">Szczegóły &raquo;</a>
	</p>
	
	<? } else { ?>
	
		<p class="col-lg-12">
			<a href="<?= $object->getUrl() ?>">Szczegóły &raquo;</a>
		</p>
	
	<? } ?>
	
	<? /*
    <p class="title">
        <?php if ($object->getUrl() != false){ ?>
        <a href="<?= $object->getUrl() ?>/tresc" title="<?= strip_tags($object->getTitle()) ?>">
            <?php } ?>
            <?= $object->getShortTitle() ?>
            <?php if ($object->getUrl() != false){ ?>
        </a> <?
    }
    if ($object->getTitleAddon()) {
        echo '<small>' . $object->getTitleAddon() . '</small>';
    } ?>
    </p>

    <?= $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults) ?>

    <? if ($object->getDescription()) { ?>
        <div class="description">
            <?= $this->Text->truncate($object->getDescription(), 250) ?>
        </div>
    <? } ?>
    */ ?>

</div>