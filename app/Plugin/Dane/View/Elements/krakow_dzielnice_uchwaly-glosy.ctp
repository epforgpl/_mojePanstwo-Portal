<div class="objectRender <? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?>" oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <?

    // debug( $object->getData() );

    $dictionary = array(
        'z' => array('Za', '1'),
        'p' => array('Przeciw', '2'),
        'w' => array('Wstrzymanie', '3'),
        'n' => array('Nieobecność', '4'),
    );

    $glos = $dictionary[$object->getData('glos')];

    ?>

    <div class="row">

    <div class="col-md-9">

            <p class="title"><a
                    href="/dane/gminy/903,krakow/dzielnice/<?= $object->getData('krakow_dzielnice_uchwaly.dzielnica_id') ?>/radni/<?= $object->getData('radny_id') ?>"><?= $object->getData('radni_dzielnic.imie') ?> <?= $object->getData('radni_dzielnic.nazwisko') ?></a>
            </p>

        </div>
        <div class="col-md-3 text-right">

            <div class="voted btn btn-default btn-glos-<?= $glos[1] ?>"
                 data-glos="<?= $object->getData('glos') ?>"><?= $glos[0] ?></div>

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