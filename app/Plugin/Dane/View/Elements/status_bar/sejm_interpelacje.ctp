<ul class="dataHighlights col-xs-12">

    <? if ($object->getDate()) { ?>
        <li class="dataHighlight col-xs-3">
            <p class="_label">Data wniesienia</p>

            <p class="_value"><?= dataSlownie($object->getDate()); ?></p>
        </li>
    <? } ?>


    <? if ($object->getData('poslowie_str')) { ?>
        <li class="dataHighlight col-xs-3">
            <p class="_label">Autor</p>

            <p class="_value"><?= $object->getData('poslowie_str'); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('adresaci_str')) { ?>
        <li class="dataHighlight col-xs-3">
            <p class="_label">Adresat</p>

            <p class="_value"><?= $object->getData('adresaci_str'); ?></p>
        </li>
    <? } ?>
</ul>