<ul class="dataHighlights col-xs-12">
    <? if ($nadrzedna = $object->getLayer('instytucja_nadrzedna')) { ?>
        <li class="dataHighlight col-xs-4">
            <p class="_label">Instytucja nadrzędna</p>

            <p class="_value">
                <a href="/dane/instytucje/<?= $nadrzedna['id'] ?><? if ($nadrzedna['slug']) { ?>,<?= $nadrzedna['slug'] ?><? } ?>"><?= $nadrzedna['nazwa'] ?></a>
            </p>
        </li>
    <? } ?>
    <? if ($object->getData('budzet_plan')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label" data-toggle="tooltip" data-placement="top"
               title="Budżet roczny organizacji, finansowany z budżetu państwa">Budżet roczny</p>

            <p class="_value">
                <a href="/dane/instytucje/<?= $object->getId() ?>/budzet"><?= number_format_h($object->getData('budzet_plan') * 1000) ?>
                    PLN</a>
            </p>
        </li>
    <? } ?>

    <? if ($www = $object->getData('www')) {
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