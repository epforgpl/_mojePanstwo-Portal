<div class="col-md-10">
    <?
    if ($object->getData('typ_id') == '2') {
        ?>
        <p style="color: green; margin: 5px;"><?= $object->getData('autor_str') ?></p>
    <?
    } else {
        ?>
        <p style="margin: 5px;"><?= $object->getData('html') ?></p>
    <?
    }
    ?>
</div>
<div class="col-md-2">
    <a class="btn btn-sm btn-primary" href="<?= $object->getUrl() ?>">Przeczytaj &raquo;</a>
</div>

