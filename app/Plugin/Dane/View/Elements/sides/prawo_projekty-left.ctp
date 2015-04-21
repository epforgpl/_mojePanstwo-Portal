<?
	$this->Combinator->add_libs('css', $this->Less->css('view-legislacja', array('plugin' => 'Dane')));	
?>

<div class="objectSideInner">

    <div class="block">
        <ul class="dataHighlights side">
									
            <? if ($object->getData('autorzy_html')) { ?>
                <li class="dataHighlight">
                    <p class="_label">Autor projektu</p>

                    <p class="_value"><?= $object->getData('autorzy_html'); ?></p>
                </li>
            <? } ?>
            
            <? if ($object->getData('status_str')) { ?>
                <li class="dataHighlight">
                    <p class="_label">Status</p>

                    <p class="_value"><?= $object->getData('status_str'); ?></p>
                </li>
            <? } ?>
            
            <? if (strip_tags($object->getDescription())) { ?>
                <li class="dataHighlight">
                    <p><?= $object->getDescription(); ?></p>
                </li>
            <? } ?>
            
        </ul>
    </div>    
	
	<? if( $object->getData('prawo_projekty.druk_nr') ) { ?>
	<div class="block">
        <ul class="dataHighlights side">

            <li class="dataHighlight">
                <p class="_value">
                    <a target="_blank" href="http://sejm.gov.pl/Sejm7.nsf/PrzebiegProc.xsp?nr=<?= $object->getData('prawo_projekty.druk_nr') ?>">Źródło</a>
                </p>
            </li>

        </ul>
    </div>
    <? } ?>

</div>