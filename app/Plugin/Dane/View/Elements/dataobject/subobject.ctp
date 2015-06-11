<div class="objectPageHeaderContainer subobjectContainer">
    <div class="container" style="width: inherit;">
        <? if (isset($back)) { ?>
            <div class="col-md-1 btn-back-cont">
                <a class="btn-back glyphicon glyphicon-circle-arrow-left" href="<?= $back['href'] ?>"
                   title="<?= addslashes($back['title']) ?>"></a>
            </div>
        <? } ?>
        <div class="col-md-8">
            <? if (isset($_submenu) && !empty($_submenu)) { ?>
                <div class="menuTabsCont col-md-12">
                    <?
                    if (!isset($_submenu['base']))
                        $_submenu['base'] = $object->getUrl();
                    echo $this->Element('Dane.dataobject/menuTabs', array(
                        'menu' => $_submenu,
                    ));
                    ?>
                </div>
            <? } ?>
            <p class="header">
                <?= $object->getShortLabel(); ?>
            </p>

            <div class="objectPageHeader">
                <?php
                echo $this->Dataobject->render($object, 'subobject', $objectOptions);
                ?>
            </div>
        </div>
    </div>
</div>