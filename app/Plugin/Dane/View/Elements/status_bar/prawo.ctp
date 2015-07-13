<ul class="dataHighlights col-xs-12">
    <?
    $struktura = $object->getData('sygnatura');
    if (isset($struktura) && !empty($struktura)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Sygnatura</p>

            <p class="_value"><?= $struktura; ?></p>
        </li>
    <? } ?>

    <?
    $isap_status_str = $object->getData('isap_status_str');
    if (isset($isap_status_str) && !empty($isap_status_str)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Status</p>

            <p class="_value"><?= $isap_status_str; ?></p>
        </li>
    <? } ?>

    <?
    $data_wydania = $object->getData('data_wydania');
    if (isset($data_wydania) && !empty($data_wydania) && ($data_wydania != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wydania</p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_wydania); ?></p>
        </li>
    <? } ?>

    <?
    $data_wejscia_w_zycie = $object->getData('data_wejscia_w_zycie');
    if (isset($data_wejscia_w_zycie) && !empty($data_wejscia_w_zycie) && ($data_wejscia_w_zycie != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wejścia w życie</p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_wejscia_w_zycie); ?></p>
        </li>
    <? } ?>
    
    <?
    if ( $organ = $object->getData('isap_organ_wydajacy_str') ) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Organ wydający</p>

            <p class="_value"><?= $organ ?></p>
        </li>
    <? } ?>    
    
</ul>