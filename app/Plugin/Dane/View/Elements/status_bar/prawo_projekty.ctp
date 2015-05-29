<ul class="dataHighlights col-xs-12">
    <? if ($object->getData('autorzy_html')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Autor projektu</p>

            <p class="_value"><?= $object->getData('autorzy_html'); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('status_str')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Status</p>

            <p class="_value"><?= $object->getData('status_str'); ?></p>
        </li>
    <? } ?>

    <? if (strip_tags($object->getDescription())) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p><?= $object->getDescription(); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('prawo_projekty.druk_nr')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_value">
                <a target="_blank"
                   href="http://sejm.gov.pl/Sejm7.nsf/PrzebiegProc.xsp?nr=<?= $object->getData('prawo_projekty.druk_nr') ?>">Źródło</a>
            </p>
        </li>
    <? } ?>
</ul>