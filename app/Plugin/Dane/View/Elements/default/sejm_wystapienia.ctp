<?
	
	$mowca_href = $object->getData('ludzie.posel_id') ? '/dane/poslowie/' . $object->getData('ludzie.posel_id') : false;
    $stanowisko_id = $object->getData('stanowisko_id');
    $stanowisko_nazwa = $object->getData('stanowiska.nazwa');
    $thumbnailUrl = 'http://resources.sejmometr.pl/mowcy/a/1/' . $object->getData('ludzie.id') . '.jpg';
			
?>

    <div class="<? if (in_array($stanowisko_id, array(3, 4, 130))) { ?> porzadek<? } else { ?> wystapienie<? } ?>">

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
			            ?><a class="link-discrete" href="<?= $object->getUrl() ?>"><?= $object->getData('sejm_wystapienia.skrot') ?></a><?
		        ?>
	           </div>


            <? } ?>
        </div>

    </div>