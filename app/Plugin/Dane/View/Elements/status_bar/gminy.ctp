<? if (false && ($szef = $object->getLayer('szef'))) { ?>
    <ul class="dataHighlights col-xs-12">
        <?php if (isset($szef['kandydat_nazwa']) && !empty($szef['kandydat_nazwa'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label"><?= $szef['stanowisko'] ?></p>

                <p class="_value"><?= $szef['kandydat_nazwa'] ?></p>
            </li>
        <?php } ?>

        <?php if (isset($szef['komitet_nazwa']) && !empty($szef['komitet_nazwa'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label">Komitet</p>

                <p class="_value"><?= $szef['komitet_nazwa'] ?></p>
            </li>
        <?php } ?>

        <?php if (isset($szef['liczba_glosow']) && !empty($szef['liczba_glosow'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label">Liczba głosów</p>

                <p class="_value"><?= number_format_h($szef['liczba_glosow']); ?></p>
            </li>
        <?php } ?>

        <?php if (isset($szef['procent_glosow']) && !empty($szef['procent_glosow'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label">Poparcie</p>

                <p class="_value"><?= round($szef['procent_glosow'], 1) ?>%</p>
            </li>
        <?php } ?>
    </ul>
<? } ?>
<ul class="dataHighlights oneline col-xs-12">
    <?php $typ_nazwa = $object->getData('typ_nazwa');
    if (isset($typ_nazwa) && !empty($typ_nazwa)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">

            <p class="_value"><?= $typ_nazwa; ?></p>
        </li>
    <?php } ?>
	
	<? /*
    <?php
    $liczba_ludnosci = $object->getData('liczba_ludnosci');
    if (isset($liczba_ludnosci) && !empty($liczba_ludnosci)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Liczba ludności</p>

            <p class="_value"><?= number_format_h($liczba_ludnosci); ?></p>
        </li>
    <?php } ?>

    <?php
    $powierzchnia = $object->getData('powierzchnia');
    if (isset($powierzchnia) && !empty($powierzchnia)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Powierzchnia</p>

            <p class="_value"><?= number_format($powierzchnia, 0); ?> km<sup>2</sup></p>
        </li>
    <?php } ?>
    */ ?>
</ul>