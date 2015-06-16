<div class="subobjectPage nopadding">
    <div class="objectPageHeaderContainer subobjectContainer">

        <div class="row">
            <div class="col-md-12">

                <p class="header">

                    <? if ($bcs = $object->getBreadcrumbs()) {
                    if (isset($addBreadcrumbs))
                        $bcs = array_merge($bcs, $addBreadcrumbs);
                    ?>
                <ul class="breadcrumb">
                    <? foreach ($bcs as $bc) {
                        if (!isset($bc['id']))
                            $bc['id'] = false;
                        ?>
                        <li><? if ($bc['id']) { ?><a target="_self"
                                                     href="<?= $bc['id'] ?>"><? } ?><?= $bc['label'] ?><? if ($bc['id']) { ?></a><? } ?>
                        </li>
                    <? } ?>
                </ul>
                <? } else { ?>
                    <?= $object->getShortLabel(); ?>
                <? } ?>

                </p>

                <div class="objectPageHeader">
                    <?php
                    echo $this->Dataobject->render($object, 'subobject', $objectOptions);
                    ?>
                </div>
            </div>
        </div>

        <? if (isset($menu) && !empty($menu)) { ?>
            <div class="menuTabsCont">
                <?
                if (!isset($_submenu['base']))
                    $_submenu['base'] = $object->getUrl();
                echo $this->Element('Dane.dataobject/menuTabs', array(
                    'menu' => $_submenu,
                ));
                ?>
            </div>
        <? } ?>

    </div>
</div>