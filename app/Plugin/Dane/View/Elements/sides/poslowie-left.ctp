<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
?>

<div class="objectSideInner">

    <div class="block">
        <ul class="dataHighlights side">
						
			<li class="dataHighlight">
                <p class="_label">Klub parlamentarny</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('sejm_kluby.nazwa'); ?></p>
                </div>
            </li>
			
            <li class="dataHighlight">
                <p class="_label">Zawód</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('zawod'); ?></p>
                </div>
            </li>

            <li class="dataHighlight">
                <p class="_label">Data urodzenia</p>

                <div>
                    <p class="_value pull-left"><?= $this->Czas->dataSlownie($object->getData('data_urodzenia')); ?></p>
                </div>
            </li>
            
            <li class="dataHighlight">
                <p class="_label">Miejsce zamieszkania</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('miejsce_zamieszkania'); ?></p>
                </div>
            </li>

            <? if ($object->getData('data_wygasniecia_mandatu') && ($object->getData('data_wygasniecia_mandatu') != '0000-00-00')) { ?>
                <li class="dataHighlight">
                    <span class="label label-default">Ta osoba nie jest już posłem</span>
                </li>
                <li class="dataHighlight">
                    <p class="_label">Data wygaśnięcia mandatu</p>

                    <div>
                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wygasniecia_mandatu')); ?></p>
                    </div>
                </li>
            <? } ?>

            <? if ($object->getData('data_slubowania') && ($object->getData('data_slubowania') != '0000-00-00')) { ?>
                <li class="dataHighlight">
                    <p class="_label">Data ślubowania</p>

                    <div>
                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_slubowania')); ?></p>
                    </div>
                </li>
            <? } ?>

        </ul>
    </div>

</div>