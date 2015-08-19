<ul class="dataHighlights col-xs-12 oneline">
    <?
    $struktura = $object->getData('sygnatura');
    if (isset($struktura) && !empty($struktura)) { ?>
        <li class="dataHighlight col-sm-12 col-sm-12">
            <p class="_label">Sygnatura</p>

            <p class="_value"><?= $struktura; ?></p>
        </li>
    <? } ?>      
    
</ul>