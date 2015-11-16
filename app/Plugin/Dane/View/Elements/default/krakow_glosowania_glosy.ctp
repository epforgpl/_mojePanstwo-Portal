<div class="row">
    <div class="col-md-12">
        <?
        $_map = array(
            '1' => array('Za', 'success'),
            '2' => array('Przeciw', 'danger'),
            '3' => array('Wstrzymanie', 'primary'),
            '4' => array('Nieobecność', 'default'),
        );

        if (array_key_exists($object->getData('glos_id'), $_map)) {
            $m = $_map[$object->getData('glos_id')];
            ?>
            <h3 class="label-glos"><span class="label label-md label-<?= $m[1] ?>"><?= $m[0] ?></span></h3>
        <? } ?>
    </div>
</div>
