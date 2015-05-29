<ul class="dataHighlights col-xs-12">
    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Klub parlamentarny</p>

        <p class="_value"><?= $object->getData('sejm_kluby.nazwa'); ?></p>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Zawód</p>

        <p class="_value"><?= $object->getData('zawod'); ?></p>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Data urodzenia</p>

        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_urodzenia')); ?></p>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Miejsce zamieszkania</p>

        <p class="_value"><?= $object->getData('miejsce_zamieszkania'); ?></p>

    </li>

    <? if ($object->getData('data_wygasniecia_mandatu') && ($object->getData('data_wygasniecia_mandatu') != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <span class="label label-default">Ta osoba nie jest już posłem</span>
        </li>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wygaśnięcia mandatu</p>

            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wygasniecia_mandatu')); ?></p></div>
        </li>
    <? } ?>

    <? if ($object->getData('data_slubowania') && ($object->getData('data_slubowania') != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data ślubowania</p>

            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_slubowania')); ?></p>
        </li>
    <? } ?>
</ul>