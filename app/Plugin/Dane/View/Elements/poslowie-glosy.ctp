<div class="objectRender<?= ($alertsStatus) ? " unreaded" : " readed"; ?>" oid="<?php echo $object->getId() ?>"
     gid="<?php echo $object->getGlobalId() ?>">
    <?
    $dictionary = array(
        '1' => array('Za', 'z'),
        '2' => array('Przeciw', 'p'),
        '3' => array('Wstrzymanie', 'w'),
        '4' => array('Nieobecność', 'n'),
    );

    $glos = $dictionary[$object->getData('glos_id')];
    ?>

    <div class="row">
        <? if ($this->Dataobject->getDate()) { ?>
            <div class="formatDate col-xs-2 col-lg-1 dimmed">
                <?php echo($this->Dataobject->getDate()); ?>
            </div>
        <? } ?>
        <div class="data <?= $this->Dataobject->getDate() ? 'col-xs-6 col-lg-8' : 'col-xs-8 col-lg-9' ?>">

            <div class="content">
                <p class="title">
                    <a href="/dane/sejm_glosowania/<?= $object->getData('glosowanie_id') ?>"><?= $object->getData('sejm_glosowania.tytul') ?></a>
                </p>
            </div>
        </div>
        <div class="col-xs-4 col-lg-3 text-right">

            <div class="voted btn btn-default btn-glos-<?= $object->getData('glos_id') ?>"
                 data-glos="<?= $object->getData('glos_id') ?>"><?= $glos[0] ?></div>
        </div>
    </div>
</div>
