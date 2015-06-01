<ul class="dataHighlights col-xs-12">
    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label"><?= __d('dane', 'LC_DANE_DATA_WPLYWU') ?></p>

        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wplywu')) ?></p>
    </li>
    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label"><?= __d('dane', 'LC_DANE_DATA_ORZECZENIA') ?></p>

        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_orzeczenia')) ?></p>
    </li>
    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label"><?= __d('dane', 'LC_DANE_DLUGOSC_ROZPATRYWANIA') ?></p>

        <p class="_value"><?= pl_dopelniacz($object->getData('dlugosc_rozpatrywania'), 'dzień', 'dni', 'dni') ?></p>
    </li>
</ul>