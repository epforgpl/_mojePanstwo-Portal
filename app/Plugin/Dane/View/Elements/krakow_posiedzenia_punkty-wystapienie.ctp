<div class="objectRender sejm_wystapienia sejm_debata_wystapienie<?= ($alertsStatus) ? " unreaded" : " readed"; ?>"
     oid="<?php echo $object->getId() ?>"
     gid="<?php echo $object->getGlobalId() ?>"<? if (isset($object->options['html']) && $object->options['html']) {
    printf(' data-html="%s"', htmlspecialchars($object->getData('skrot'), ENT_QUOTES, 'UTF-8'));
} ?>>

    <?
	    
	    $mowca = array(
		    'nazwa' => $object->getData('krakow_posiedzenia_wystapienia.mowca_imie') . ' ' . $object->getData('krakow_posiedzenia_wystapienia.mowca_nazwisko'),
		    'stanowisko' => $object->getData('krakow_posiedzenia_wystapienia.mowca_stanowisko'),
		    'href' => false,
		    'thumb' => false,
		    'przewodniczacy' => false,
	    );
	    
	    if( $object->getData('krakow_posiedzenia_wystapienia.radny_id') ) {
		    
		    $mowca['nazwa'] = $object->getData('radni_gmin.nazwa');
		    $mowca['href'] = '/dane/gminy/903,krakow/radni/' . $object->getData('krakow_posiedzenia_wystapienia.radny_id');
		    $mowca['thumb'] = 'http://resources.sejmometr.pl/avatars/3/' . $object->getData('radni_gmin.avatar_id') . '.jpg';
		    
	    }
	    
	    if( stripos($mowca['stanowisko'], 'przewodniczący')!==false )
	    	$mowca['przewodniczacy'] = true;
	    
    ?>

    <div class="row<? if( $mowca['przewodniczacy'] ) { ?> porzadek<? } else { ?> wystapienie<? } ?>">

        <div class="sw_avatar">
            <p>
                <? if ($mowca['href']) { ?>
                <a href="<?= $mowca['href'] ?>">
                    <? } ?>
                    <? if ($mowca['thumb']) { ?><img src="<?= $mowca['thumb'] ?>" /><? } ?>
                    <? if ($mowca['href']){ ?></a><? } ?>
            </p>
        </div>
        <div class="sw_content<? if (isset($object->options['html']) && $object->options['html']) { ?> expanded<? } ?>">
			
            <?
	            
	        $label_class = $mowca['przewodniczacy'] ? 'danger' : 'default';
	           
	        /* 
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
            */
            ?>


            <p class="mowca"><? if ($mowca['href']) { ?><a
                    href="<?= $mowca['href'] ?>"><? } ?><?= $mowca['nazwa'] ?><? if ($mowca['href']){ ?></a><? } ?>
                <span class="label label-<?= $label_class ?>"><?= $mowca['stanowisko'] ?></span></p>

            <? if ($html = $object->getLayer('html')) { ?>

                <div class="text"><?= $html ?></div>

            <? } else { ?>

                <div class="text">
                    <?
                    if (isset($object->options['html']) && $object->options['html'])
                        echo $object->options['html'];
                    else
                        echo $object->getData('krakow_posiedzenia_wystapienia.skrot');
                    ?>
                </div>

                <p class="link link-expand">
                    <a class="load" href="<?= $object->getUrl() ?>">Pokaż pełną treść wystąpienia</a>
                </p>

                <p class="link link-collapse">
                    <a class="unload" href="#" onclick="return false;">Ukryj pełną treść wystąpienia</a>
                </p>

                <div class="loader">
                    <div class="spinner grey">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</div>
