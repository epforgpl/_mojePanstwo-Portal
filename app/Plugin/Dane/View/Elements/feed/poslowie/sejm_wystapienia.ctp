<?

$hlFields = array('sejm_debaty.tytul');

?>

<div class="content<? if ($object->getPosition()) { ?> col-md-11<? } ?>">


    <p class="title smaller">
        <?php if ($object->getUrl() != false){ ?>
        <a href="<?= $object->getUrl() ?>" title="<?= strip_tags($object->getData('skrot')) ?>">
            <?php } ?>
            <?= $object->getData('skrot') ?>
            <?php if ($object->getUrl() != false){ ?>
        </a> <?
    }
    ?>
    </p>

    <?= $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults) ?>

</div>
