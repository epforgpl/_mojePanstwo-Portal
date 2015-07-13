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

                <? /*Głos <? if ($object->getData('radni_gmin.plec') == 'K') { ?>radnej<? } else { ?>radnego<? } ?>:*/?>
                
                <h3 class="label-glos"><span class="label label-md label-<?= $m[1] ?>"><?= $m[0] ?></span></h3>
                

        <? } ?>


    </div>
    <? /*
    <div class="col-md-6">

        <?

        if ($object->getData('krakow_glosowania.wynik_str')) {

            $class = 'default';
            if ($object->getData('krakow_glosowania.wynik_id') == 1) {
                $class = 'success';
            } elseif ($object->getData('krakow_glosowania.wynik_id') == 2) {
                $class = 'danger';
            }

            ?>

                <p class="label label-<?= $class ?>"><?= $object->getData('krakow_glosowania.wynik_str') ?></p>

        <? } ?>

    </div>
    */?>
</div>