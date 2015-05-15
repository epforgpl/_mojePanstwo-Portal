<?
$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

if (in_array($object->getDataset(), array('rady_posiedzenia'))) {
    $object_content_sizes = array(3, 9);
} else {
    $object_content_sizes = array(2, 10);
}

$this->Dataobject->setObject($object);

if (($object->getDataset() == 'gminy') && ($object->getId() == '903')) {

    echo $this->element('Dane.przejrzystykrakow_header', array(
        'object' => $object,
        'object_content_sizes' => $object_content_sizes,
        'titleTag' => $titleTag,
        'bigTitle' => $bigTitle,
        'thumbSize' => $thumbSize,
    ));

} else { ?>
    <div class="objectRender col-md-12 <?php echo $object->getDataset(); ?>" oid="<?php echo $object->getId() ?>">
        <div class="data col-md-<?= $this->Dataobject->getDate() ? '11' : '12' ?>">
            <div class="row">
                <? if ($object->getHeaderThumbnailUrl($thumbSize)) { ?>
    <div class="attachment col-md-<?= $object_content_sizes[0] ?> text-center">
        <?php if ($object->getUrl() != false) { ?>
        <a class="thumb_cont" href="<?= $object->getUrl() ?>">
            <?php } ?>
            <img itemprop="image" class="thumb" onerror="imgFixer(this)"
                 src="<?= $object->getHeaderThumbnailUrl($thumbSize) ?>"
                 alt="<?= strip_tags($object->getTitle()) ?>"/>
            <?php if ($object->getUrl() != false) { ?>
        </a>
    <?php } ?>
    </div>
<div class="content col-md-<?= $object_content_sizes[1] ?>">
    <p class="header"><?= $object->getLabel(); ?></p>
    <? if ($object->getTitle()) { ?>
        <<?= $titleTag ?> class="title trimTitle<? if ($bigTitle) { ?> big<? } ?>"
                                        title="<?= htmlspecialchars($object->getTitle()) ?>"
                                        data-trimlength="200">
                                        <?php if (($object->getUrl() != false) && !empty($this->request)) { ?>
            <a href="<?= $object->getUrl() ?>" title="<?= strip_tags($object->getTitle()) ?>">
                <?php } ?>
                                        <span<? if ($microdata['titleprop']) { ?> itemprop="<?= $microdata['titleprop'] ?>"<? } ?>><?= $object->getTitle() ?></span>
                                        <?php if (($object->getUrl() != false) && !empty($this->request)) { ?>
            </a> <? if ($object->getTitleAddon()) {
                echo '<small>' . $object->getTitleAddon() . '</small>';
            } ?>
        <?php } ?>
                                    </<?= $titleTag ?>>
                                <? } ?>

    <? if ($file_exists) {
        echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
            'object' => $object
        ));
    } ?>
    </div>
<? } else { ?>
    <div class="content mini">
    <p class="header"><?= $object->getLabel(); ?></p>
    <<?= $titleTag ?> class="title<? if ($bigTitle) { ?> big<? } ?>">
    <?php if ($object->getUrl() != false){ ?>
    <a class="trimTitle" href="<?= $object->getUrl() ?>"
       title="<?= strip_tags($object->getTitle()) ?>">
<?php } ?>
    <span<? if ($microdata['titleprop']) { ?> itemprop="<?= $microdata['titleprop'] ?>"<? } ?>><?= $object->geticon() . $object->getTitle() ?></span>
    <?php if ($object->getUrl() != false){ ?>
    </a> <? if ($object->getTitleAddon()) {
    echo '<small>' . $object->getTitleAddon() . '</small>';
} ?>
<?php } ?>
    </<?= $titleTag ?>>
    <? if ($file_exists) {
        echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
            'object' => $object
        ));
    } ?>
    </div>
<? } ?>
            </div>
        </div>
    </div>
<? } ?>