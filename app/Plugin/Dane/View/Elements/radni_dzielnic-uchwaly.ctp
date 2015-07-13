<div class="objectRender <? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?>" oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <?

    // debug( $object );

    $temp = '<span>{day}</span><p>{month} {year}</p>';
    $ts = strtotime($object->getDate());

    $formatting = array(
        'day' => date('j', $ts),
        'year' => date('Y', $ts),
        'month' => __(date('M', $ts), true),
    );

    foreach ($formatting as $key => $partial) {
        $temp = preg_replace('/\{' . $key . '\}/', $partial, $temp);
    }

    $dictionary = array(
        'z' => array('Za', '1'),
        'p' => array('Przeciw', '2'),
        'w' => array('Wstrzymanie', '3'),
        'n' => array('Nieobecność', '4'),
    );

    $glos = $dictionary[$object->getData('glos')];
    $this->Dataobject->setObject($object);

    ?>

    <div class="row">

        <div class="formatDate col-xs-2 col-lg-1 dimmed">
            <?= $temp ?>
        </div>

        <div class="col-xs-6 col-lg-8">
            <p class="title"><a
                    href="/dane/gminy/903,krakow/dzielnice/<?= $object->getData('krakow_dzielnice_uchwaly.dzielnica_id') ?>/uchwaly/<?= $object->getData('krakow_dzielnice_uchwaly.id') ?>"><?= $object->getData('krakow_dzielnice_uchwaly.nazwa') ?></a>
            </p>
        </div>
        <div class="col-xs-4 col-lg-3 text-right">

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