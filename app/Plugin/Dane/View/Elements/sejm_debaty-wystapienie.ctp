<div class="objectRender sejm_wystapienia sejm_debata_wystapienie<? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?>" oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>"<? if( isset($object->options['html']) && $object->options['html'] ) { printf(' data-html="%s"', htmlspecialchars($object->getData('skrot'), ENT_QUOTES, 'UTF-8')); } ?>>

    <?

    // debug( $object->getData() );

    $mowca_href = $object->getData('ludzie.posel_id') ? '/dane/poslowie/' . $object->getData('ludzie.posel_id') : false;
    $stanowisko_id = $object->getData('stanowisko_id');
    $stanowisko_nazwa = $object->getData('stanowiska.nazwa');
    $thumbnailUrl = 'http://resources.sejmometr.pl/mowcy/a/1/' . $object->getData('ludzie.id') . '.jpg';
		
    ?>

    <div class="row<? if (in_array($stanowisko_id, array(3, 4, 130))) { ?> porzadek<? } else { ?> wystapienie<? } ?>">

        <div class="sw_avatar">
            <p>
            <? if ($mowca_href) { ?>
            	<a href="<?= $mowca_href ?>">
	        <? } ?>
                <? if($object->getData('ludzie.avatar')) {?><img src="<?= $thumbnailUrl ?>" onerror="imgFixer(this)"/><? } ?>
            <? if ($mowca_href){ ?></a><? } ?>
            </p>
        </div>
        <div class="sw_content<? if( isset($object->options['html']) && $object->options['html'] ) {?> expanded<? } ?>">

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

                <div class="text"><?= $html ?></div>

            <? } else { ?>

                <div class="text">
	            <?	
		            if( isset($object->options['html']) && $object->options['html'] )
		            	echo $object->options['html'];
		            else
			            echo $object->getData('sejm_wystapienia.skrot');
		        ?>
	           </div>

                <p class="link link-expand">
                    <a class="load" href="<?= $object->getUrl() ?>">Pokaż pełną treść wystąpienia</a>
                </p>
                
                <p class="link link-collapse">
                    <a class="unload" href="#" onclick="return false;">Ukryj pełną treść wystąpienia</a>
                </p>
                
                <div class="loader">
	                <div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
                </div>

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