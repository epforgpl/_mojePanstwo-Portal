<div class="content<? if ($object->getPosition()) { ?> col-md-11<? } ?>">

    <p class="title smaller">
        <? if ($object->getUrl()) { ?><a href="<?= $object->getUrl() ?>"><? } ?>
            <?= strip_tags($object->getData('html')) ?>
            <? if ($object->getUrl() != false){ ?></a><? } ?>
    </p>

</div>
