<ul class="dataHighlights col-xs-12">
    <? if ($object->getData('data')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data wydania</p>

            <p class="_value"><?= dataSlownie($object->getData('data')); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('str_numer')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Numer</p>

            <p class="_value"><?= $object->getData('str_numer'); ?></p>
        </li>
    <? } ?>

    <? if ($druki = $object->getLayer('druki')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <a href="/dane/gminy/903,krakow/druki/<?= $druki[0] ?>"><span class="icon icon-moon">&#xe611;</span>Przebieg
                procesu legislacyjnego <span class="glyphicon glyphicon-chevron-right"></span></a>
        </li>
    <? } ?>
</ul>