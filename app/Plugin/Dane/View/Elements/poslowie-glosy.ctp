<div class="objectRender <? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?>" oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <?

    // debug( $object->getData() );

    $dictionary = array(
        '1' => array('Za', 'z'),
        '2' => array('Przeciw', 'p'),
        '3' => array('Wstrzymanie', 'w'),
        '4' => array('Nieobecność', 'n'),
    );

    $glos = $dictionary[$object->getData('glos_id')];

    ?>


    <div class="row">
        <? if ($this->Dataobject->getDate()) { ?>
            <div class="formatDate col-md-1 dimmed">
                <?php echo($this->Dataobject->getDate()); ?>
            </div>
        <? } ?>
        <div class="data col-md-<?= $this->Dataobject->getDate() ? '8' : '8' ?>">

            <div class="content">
                <p class="title">
                    <a href="/dane/sejm_glosowania/<?= $object->getData('glosowanie_id') ?>"><?= $object->getData('sejm_glosowania.tytul') ?></a>
                </p>
            </div>


        </div>
        <div class="col-md-3 text-right">

            <div class="voted btn btn-default btn-glos-<?= $object->getData('glos_id') ?>"
                 data-glos="<?= $object->getData('glos_id') ?>"><?= $glos[0] ?></div>

        </div>
    </div>






    <?php /* if ( $object->hasHighlights() && $object->getHlText() ) { ?>
		<div class="row">
			<div class="text-highlights alert alert-info">
				<?php echo( closetags( $object->getHlText() ) ); ?>
			</div>
		</div>
	<?php } */
    ?>


</div>