<div class="objectPageHeaderContainer subobjectContainer">
    <div class="container" style="width: inherit;">
        <?
        $col_width = '11';
        if (isset($back)) {
            $col_width = '10';
            ?>
            <div class="col-md-1 btn-back-cont">
                <a class="btn-back glyphicon glyphicon-circle-arrow-left" href="<?= $back['href'] ?>"
                   title="<?= addslashes($back['title']) ?>"></a>
            </div>
        <? } ?>
        <div class="col-md-<?= $col_width ?>">
	        <p class="header">
		        <?= $object->getShortLabel(); ?>
		    </p>
            <div class="objectPageHeader">
                <?php
                echo $this->Dataobject->render($object, 'subobject', $objectOptions);
                ?>
            </div>
        </div>
        <div class="col-md-1 pull-right">

            <? if ($neighbours = $object->getLayer('neighbours')) { ?>
                <ul class="pagination pagination-sm pagination-neighbours">
                    <? if ($neighbours['previous']) { ?>
                        <li><a title="<?= addslashes($neighbours['previous']['title']) ?>"
                               href="<?= $neighbours['previous']['id'] ?>">←</a></li><? } ?>
                    <? if ($neighbours['next']) { ?>
                        <li><a title="<?= addslashes($neighbours['next']['title']) ?>"
                               href="<?= $neighbours['next']['id'] ?>">→</a></li><? } ?>
                </ul>
            <? } ?>
        </div>
    </div>
</div>

<?
/*
if (isset($menu) && !empty($menu)) {
    echo $this->Element('Dane.dataobject/menuTabs', array(
        'menu' => $menu,
    ));
}
*/
?>