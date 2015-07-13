<ul class="dataHighlights col-xs-12">

    <?
    $date = $object->getDate();
    if (isset($date) && !empty($date)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wniesienia</p>

            <p class="_value"><?= dataSlownie($date); ?></p>
        </li>
    <? } ?>


    <?
    $poslowie_str = $object->getData('poslowie_str');
    if (isset($poslowie_str) && !empty($poslowie_str)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Autor</p>

            <p class="_value"><?= $poslowie_str; ?></p>
        </li>
    <? } ?>

    <?
    $adresaci_str = $object->getData('adresaci_str');
    if (isset($adresaci_str) && !empty($adresaci_str)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Adresat</p>

            <p class="_value"><?= $adresaci_str; ?></p>
        </li>
    <? } ?>
</ul>