<ul class="dataHighlights col-xs-12">
    <?php
    $sejm_kluby_nazwa = $object->getData('sejm_kluby.nazwa');
    if (isset($sejm_kluby_nazwa) && !empty($sejm_kluby_nazwa)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Klub parlamentarny</p>

            <p class="_value"><?= $sejm_kluby_nazwa ?></p>
        </li>
    <?php } ?>

    <?php
    $zawod = $object->getData('zawod');
    if (isset($zawod) && !empty($zawod)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Zawód</p>

            <p class="_value"><?= $zawod; ?></p>
        </li>
    <?php } ?>

    <?php
    $data_urodzenia = $object->getData('data_urodzenia');
    if (isset($data_urodzenia) && !empty($data_urodzenia)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data urodzenia</p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_urodzenia); ?></p>
        </li>
    <?php } ?>

    <?php
    $miejsce_zamieszkania = $object->getData('miejsce_zamieszkania');
    if (isset($miejsce_zamieszkania) && !empty($miejsce_zamieszkania)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Miejsce zamieszkania</p>

            <p class="_value"><?= $miejsce_zamieszkania ?></p>

        </li>
    <?php } ?>

    <?
    $data_wygasniecia_mandatu = $object->getData('data_wygasniecia_mandatu');
    if (isset($data_wygasniecia_mandatu) && !empty($data_wygasniecia_mandatu) && ($data_wygasniecia_mandatu != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <span class="label label-default">Ta osoba nie jest już posłem</span>
        </li>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wygaśnięcia mandatu</p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_wygasniecia_mandatuł); ?></p>
        </li>
    <? } ?>

    <?
    $data_slubowania = $object->getData('data_slubowania');
    if (isset($data_slubowania) && !empty($data_slubowania) && ($data_slubowania != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data ślubowania</p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_slubowania); ?></p>
        </li>
    <? } ?>
</ul>