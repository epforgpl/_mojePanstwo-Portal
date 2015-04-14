<div class="objectRender sejm_debata_wystapienie<? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?>" oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <?

    // debug( $object->getData() );

    $mowca_href = $object->getData('ludzie.posel_id') ? '/dane/poslowie/' . $object->getData('ludzie.posel_id') : false;
    $stanowisko_id = $object->getData('stanowisko_id');
    $stanowisko_nazwa = $object->getData('stanowiska.nazwa');
    $thumbnailUrl = 'http://resources.sejmometr.pl/mowcy/a/1/' . $object->getData('ludzie.id') . '.jpg';
		
    ?>

    <div class="row<? if (in_array($stanowisko_id, array(3, 4, 130))) { ?> porzadek<? } else { ?> wystapienie<? } ?>">

        <div class="sw_avatar">
            <p><? if ($mowca_href) { ?><a href="<?= $mowca_href ?>"><? } ?><img
                        src="<?= $thumbnailUrl ?>"><? if ($mowca_href){ ?></a><? } ?></p>
        </div>
        <div class="sw_content">

            <?
            if (in_array($stanowisko_id, array(3, 4, 130)))
                $label_class = 'default';
            elseif (
                (stripos($stanowisko_nazwa, 'sekretarz') !== false) ||
                (stripos($stanowisko_nazwa, 'przewo') !== false) ||
                (stripos($stanowisko_nazwa, 'prez') !== false) ||
                (stripos($stanowisko_nazwa, 'minis') !== false)
            )
                $label_class = 'danger';
            elseif (
            (stripos($stanowisko_nazwa, 'sprawozd') !== false)
            )
                $label_class = 'primary';
            else
                $label_class = 'warning';
            ?>


            <p class="mowca"><? if ($mowca_href) { ?><a
                    href="<?= $mowca_href ?>"><? } ?><?= $object->getData('ludzie.nazwa') ?><? if ($mowca_href){ ?></a><? } ?>
                <span class="label label-<?= $label_class ?>"><?= $object->getData('stanowiska.nazwa') ?></span></p>

            <? if ($html = $object->getLayer('html')) { ?>

                <div class="full-text"><?= $html ?></div>

            <? } else { ?>

                <p class="text"><?= $object->getData('sejm_wystapienia.skrot') ?></p>

                <p class="link">
                    <a href="<?= $object->getUrl() ?>">Czytaj całe wystąpienie &raquo;</a>
                </p>

            <? } ?>
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