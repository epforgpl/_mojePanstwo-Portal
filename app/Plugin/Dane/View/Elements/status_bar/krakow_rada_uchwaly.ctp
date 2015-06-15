<ul class="dataHighlights">
    <?
    $data = $object->getData('data');
    if (isset($data) && !empty($data)) { ?>
        <li class="dataHighlight">
            <p class="_label">Data wydania</p>

            <p class="_value"><?= dataSlownie($data); ?></p>
        </li>
    <? } ?>

    <?
    $str_numer = $object->getData('str_numer');
    if (isset($str_numer) && !empty($str_numer)) { ?>
        <li class="dataHighlight">
            <p class="_label">Numer</p>

            <p class="_value"><?= $str_numer ?></p>
        </li>
    <? } ?>

    <?
    $druki = $object->getLayer('druki');
    if (isset($druki) && !empty($druki)) { ?>
        <li class="dataHighlight">
            <a href="/dane/gminy/903,krakow/druki/<?= $druki[0] ?>"><span class="icon icon-moon">&#xe611;</span>Przebieg
                procesu legislacyjnego <span class="glyphicon glyphicon-chevron-right"></span></a>
        </li>
    <? } ?>
</ul>