<ul class="dataHighlights col-xs-12">
    <?php $data_wplywu = $object->getData('data_wplywu');
    if (isset($data_wplywu) && !empty($data_wplywu)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label"><?= __d('dane', 'LC_DANE_DATA_WPLYWU') ?></p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_wplywu) ?></p>
        </li>
    <?php } ?>

    <?php $data_orzeczenia = $object->getData('data_orzeczenia');
    if (isset($data_orzeczenia) && !empty($data_orzeczenia)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label"><?= __d('dane', 'LC_DANE_DATA_ORZECZENIA') ?></p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_orzeczenia) ?></p>
        </li>
    <?php } ?>

    <?php $dlugosc_rozpatrywania = $object->getData('dlugosc_rozpatrywania');
    if (isset($dlugosc_rozpatrywania) && !empty($dlugosc_rozpatrywania)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label"><?= __d('dane', 'LC_DANE_DLUGOSC_ROZPATRYWANIA') ?></p>

            <p class="_value"><?= pl_dopelniacz($dlugosc_rozpatrywania, 'dzień', 'dni', 'dni') ?></p>
        </li>
    <?php } ?>
</ul>