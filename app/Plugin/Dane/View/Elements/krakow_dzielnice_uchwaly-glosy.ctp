<div class="objectRender<?= ($alertsStatus) ? " unreaded" : " readed"; ?>" oid="<?php echo $object->getId() ?>"
     gid="<?php echo $object->getGlobalId() ?>">

    <?

    $dictionary = array(
        'z' => array('Za', '1'),
        'p' => array('Przeciw', '2'),
        'w' => array('Wstrzymanie', '3'),
        'n' => array('Nieobecność', '4'),
    );

    $glos = $dictionary[$object->getData('glos')];
    ?>

    <div class="row">
        <div class="col-md-9">
            <p class="title"><a
                    href="/dane/gminy/903,krakow/dzielnice/<?= $object->getData('krakow_dzielnice_uchwaly.dzielnica_id') ?>/radni/<?= $object->getData('radny_id') ?>"><?= $object->getData('radni_dzielnic.imie') ?> <?= $object->getData('radni_dzielnic.nazwisko') ?></a>
            </p>
        </div>
        <div class="col-md-3 text-right">
            <div class="voted btn btn-default btn-glos-<?= $glos[1] ?>"
                 data-glos="<?= $object->getData('glos') ?>"><?= $glos[0] ?></div>
        </div>
    </div>
</div>
