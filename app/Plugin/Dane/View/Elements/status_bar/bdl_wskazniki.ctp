<ul class="dataHighlights oneline col-xs-12">
    <?
    $data_aktuakizacji = $object->getData('data_aktualizacji');
    if (isset($data_aktuakizacji) && !empty($data_aktuakizacji) && ($data_aktuakizacji != '0000-00-00')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-6">
            <p class="_label">Data aktualizacji</p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_aktuakizacji); ?></p>
        </li>
    <? } ?>
    
    <li class="dataHighlight col-sm-6 col-sm-6">
            <p class="_label">Szczegółowość danych</p>

            <p class="_value"><?= $object->getData('poziom_str') ?></p>
        </li>
    
</ul>