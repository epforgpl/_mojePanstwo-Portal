<div class="objectRender <?= ($alertsStatus) ? " unreaded" : " readed"; ?>" oid="<?php echo $object->getId() ?>"
     gid="<?php echo $object->getGlobalId() ?>">

    <?
    $dictionary = array(
        '1' => array('Za', 'z'),
        '2' => array('Przeciw', 'p'),
        '3' => array('Wstrzymanie', 'w'),
        '4' => array('Brak kworum', 'n'),
    );

    $wynik = $dictionary[$object->getData('wynik_id')];
    ?>

    <div class="row">
        <div class="col-md-9 nopadding">
            <p class="title"><a href="<?= $object->getUrl() ?>"><?= $object->getTitle() ?></a></p>
        </div>
        <div class="col-md-3 text-right nopadding">
            <div class="voted btn btn-default btn-glos-<?= $object->getData('wynik_id') ?>"
                 data-glos="<?= $object->getData('wynik_id') ?>"><?= $wynik[0] ?></div>
        </div>
    </div>
</div>
