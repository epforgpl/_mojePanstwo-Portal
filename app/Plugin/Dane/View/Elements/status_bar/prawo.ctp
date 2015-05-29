<ul class="dataHighlights col-xs-12">
    <? if ($object->getData('sygnatura')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Sygnatura</p>

            <p class="_value"><?= $object->getData('sygnatura'); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('isap_status_str')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Status</p>

            <p class="_value"><?= $object->getData('isap_status_str'); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('data_wydania') && ($object->getData('data_wydania') != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wydania</p>

            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wydania')); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('data_wejscia_w_zycie') && ($object->getData('data_wejscia_w_zycie') != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wejścia w życie</p>

            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wejscia_w_zycie')); ?></p>
        </li>
    <? } ?>
</ul>