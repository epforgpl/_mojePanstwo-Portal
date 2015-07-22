<ul class="dataHighlights col-xs-12">
    <?
    $nadrzedna = $object->getLayer('instytucja_nadrzedna');
    if (isset($nadrzedna) && !empty($nadrzedna)) { ?>
        <li class="dataHighlight col-xs-4">
            <p class="_label">Instytucja nadrzędna</p>

            <p class="_value">
                <a href="/dane/instytucje/<?= $nadrzedna['id'] ?><? if ($nadrzedna['slug']) { ?>,<?= $nadrzedna['slug'] ?><? } ?>"><?= $nadrzedna['nazwa'] ?></a>
            </p>
        </li>
    <? } ?>
    <?
    $budzet_plan = $object->getData('budzet_plan');
    if (isset($budzet_plan) && !empty($budzet_plan)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label" data-toggle="tooltip" data-placement="top"
               title="Budżet roczny organizacji, finansowany z budżetu państwa">Budżet roczny</p>

            <p class="_value">
                <a href="/dane/instytucje/<?= $object->getId() ?>/budzet"><?= number_format_h($budzet_plan * 1000) ?>
                    PLN</a>
            </p>
        </li>
    <? } ?>

    <?
    $www = $object->getData('www');
    if (isset($www) && !empty($www)) {
        $url = (stripos($www, 'http') === false) ? 'http://' . $www : $www;
        ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Adres WWW</p>

            <p class="_value">
                <a target="_blank" title="<?= addslashes($object->getTitle()) ?>"
                   href="<?= $url ?>"><?= $www; ?></a>
            </p>
        </li>
    <? } ?>
</ul>