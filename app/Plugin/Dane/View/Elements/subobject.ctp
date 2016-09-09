<?
$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);
$this->Dataobject->setObject($object);
$width = 12;

?>

<div class="objectRender col-md-12 <?php echo $object->getDataset(); ?>" oid="<?php echo $object->getId(); ?>">
    <div class="row">
        <?
        if ($object->getThumbnailUrl()) {
            $width = $width - $thumbWidth; ?>
            <div class="col-sm-<?= $thumbWidth ?>">
                <div class="attachment text-center">
                    <?php if ($object->getUrl() != false) { ?>
                    <a class="thumb_cont" href="<?= $object->getUrl() ?>">
                        <?php } ?>
                        <img class="thumb pull-right" src="<?
                        $img_link = $object->getThumbnailUrl($thumbSize);
                        $str = preg_replace('#^https?:#', '', $img_link);
                        echo $img_link;
                        ?>" alt="<?= strip_tags($object->getTitle()) ?>" onerror="imgFixer(this)"/>
                        <?php if ($object->getUrl() != false) { ?>
                    </a>
                <? } ?>
                </div>
            </div>
        <? } elseif ($object->getIcon()) {
            $width = 11; ?>

            <div class="col-sm-1 icon-cont">
                <?= $object->getIcon() ?>
            </div>

        <? } ?>
		
        <div class="data col-sm-<?= $width ?>">
            <div class="row">
                <div class="content">
                    <<?= $titleTag ?> class="title<? if ($bigTitle) { ?> big<? } ?>">
                    <?php if ($show_link && ($object->getUrl() != false)){ ?>
                    <a data-trimlength="<?= $truncate ?>" class="trimTitle" href="<?= $object->getUrl() ?>"
                       title="<?= strip_tags($object->getTitle()) ?>">
                        <?php } ?>
                        <?= $object->getShortTitle('subobject') ?>
                        <?php if ($show_link && ($object->getUrl() != false)){ ?>
                    </a> <? if ($object->getTitleAddon()) {
                    echo '<small>' . $object->getTitleAddon() . '</small>';
                } ?>
                <?php } ?>
                </<?= $titleTag ?>>
                <?
                if ($file_exists) {
                    echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
                        'object' => $object
                    ));
                } else {
                    if ($metaDesc = $object->getMetaDescription()) { ?>
                        <p class="meta meta-desc"><?= $metaDesc ?></p>
                    <? }
                    if ($object->getDescription()) { ?>
                        <div class="description">
                            <?= $object->getDescription() ?>
                        </div>
                    <? }
                }
                ?>
            </div>
            </div>
        </div>
    </div>
</div>