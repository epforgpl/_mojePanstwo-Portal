<ul class="dataHighlights col-xs-12">
    <?
    $autorzy_html = $object->getData('autorzy_html');
    if (isset($autorzy_html) && !empty($autorzy_html)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Autor projektu</p>

            <p class="_value"><?= $autorzy_html; ?></p>
        </li>
    <? } ?>

    <?
    $status_str = $object->getData('status_str');
    if (isset($status_str) && !empty($status_str)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Status</p>

            <p class="_value"><?= $object->getData('status_str'); ?></p>
        </li>
    <? } ?>

    <?
    $getDescription = $object->getDescription();
    $strip_tags = strip_tags($getDescription);
    if (isset($strip_tags) && !empty($strip_tags)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p><?= $getDescription ?></p>
        </li>
    <? } ?>

    <?
    $prawo_projekty = $object->getData('prawo_projekty.druk_nr');
    if (isset($prawo_projekty) && !empty($prawo_projekty)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_value">
                <a target="_blank"
                   href="http://sejm.gov.pl/Sejm7.nsf/PrzebiegProc.xsp?nr=<?= $prawo_projekty ?>">Źródło</a>
            </p>
        </li>
    <? } ?>
</ul>