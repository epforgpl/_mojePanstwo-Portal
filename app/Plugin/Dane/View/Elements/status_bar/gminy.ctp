<? if (false && ($szef = $object->getLayer('szef'))) { ?>
    <ul class="dataHighlights col-xs-12">

        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label"><?= $szef['stanowisko'] ?></p>

            <p class="_value"><?= $szef['kandydat_nazwa'] ?></p>
        </li>

        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Komitet</p>

            <p class="_value"><?= $szef['komitet_nazwa'] ?></p>
        </li>

        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Liczba głosów</p>

            <p class="_value"><?= number_format_h($szef['liczba_glosow']); ?></p>
        </li>

        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Poparcie</p>

            <p class="_value"><?= round($szef['procent_glosow'], 1) ?>%</p>
        </li>

    </ul>
<? } ?>
<ul class="dataHighlights col-xs-12">
    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Typ gminy</p>

        <p class="_value"><?= $object->getData('typ_nazwa'); ?></p>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Liczba ludności</p>

        <p class="_value"><?= number_format_h($object->getData('liczba_ludnosci')); ?></p>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Powierzchnia</p>

        <p class="_value"><?= number_format($object->getData('powierzchnia'), 0); ?> km<sup>2</sup></p>
    </li>
</ul>