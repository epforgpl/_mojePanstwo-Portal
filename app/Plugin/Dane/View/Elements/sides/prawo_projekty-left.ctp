<?
	$this->Combinator->add_libs('css', $this->Less->css('view-legislacja', array('plugin' => 'Dane')));	
?>

<div class="objectSideInner">

    <div class="block">
        <ul class="dataHighlights side">
			
			<? if ($object->getDescription()) { ?>
                <li class="dataHighlight">
                    <p><?= $object->getDescription(); ?></p>
                </li>
            <? } ?>
			
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
            
        </ul>
    </div>    
	
	<? /*
	<div class="block">
        <ul class="dataHighlights side">

            <li class="dataHighlight">
                <p class="_label">Źródło</p>

                <p class="_value sources">
                    <?
                    $isap_str = 'W';
                    if ($object->getData('zrodlo') == 'DzU') {
                        $isap_str .= 'DU';
                    } elseif ($object->getData('zrodlo') == 'MP') {
                        $isap_str .= 'MP';
                    }

                    $isap_str .= $object->getData('rok');
                    $isap_str .= str_pad($object->getData('nr'), 3, "0", STR_PAD_LEFT);
                    $isap_str .= str_pad($object->getData('poz'), 4, "0", STR_PAD_LEFT);
                    ?>
                    <a itemprop="sameAs" href="http://isap.sejm.gov.pl/DetailsServlet?id=<?= $isap_str ?>"
                       target="_blank">ISAP</a>
                </p>
            </li>



        </ul>
    </div>
    <? */ ?>

</div>