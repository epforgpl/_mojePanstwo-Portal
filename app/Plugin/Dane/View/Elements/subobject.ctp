<?
$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

if (in_array($object->getDataset(), array('krakow_posiedzenia'))) {
    $object_content_sizes = array(3, 9);
} else {
    $object_content_sizes = array(2, 10);
}

$this->Dataobject->setObject($object);
?>
<div class="objectRender col-md-12 <?php echo $object->getDataset(); ?>" oid="<?php echo $item['data']['id'] ?>">
    <div class="row">
        <? if ($this->Dataobject->getDate()) { ?>
            <div class="formatDate col-md-1">
                <?php echo($this->Dataobject->getDate()); ?>
            </div>
        <? } ?>
        <div class="data col-md-<?= $this->Dataobject->getDate() ? '11' : '12' ?>">
            <div class="row">

                <? if ($object->getThumbnailUrl($thumbSize)) { ?>
                <div class="attachment col-md-<?= $object_content_sizes[0] ?> text-center">

                    <?php if ($object->getUrl() != false) { ?><a class="thumb_cont"
                                                                 href="<?= $object->getUrl() ?>"><?php } ?>
                        <img class="thumb" onerror="imgFixer(this)" src="<?= $object->getThumbnailUrl($thumbSize) ?>"
                             alt="<?= strip_tags($object->getTitle()) ?>"/>
                        <?php if ($object->getUrl() != false) { ?></a><?php } ?>

                </div>
                <div class="content col-md-<?= $object_content_sizes[1] ?>">

                    <? if ($object->getShortTitle()) { ?>
                    <<?= $titleTag ?> class="title trimTitle<? if ($bigTitle) { ?> big<? } ?>"
                    title="<?= htmlspecialchars($object->getShortTitle()) ?>"
                    data-trimlength="200">

                    <?php if (($object->getUrl() != false) && !empty($this->request)) { ?>
                    <a href="<?= $object->getUrl() ?>" title="<?= strip_tags($object->getTitle()) ?>">
                        <?php } ?>

                        <?= $object->getShortTitle() ?>

                        <?php if (($object->getUrl() != false) && !empty($this->request)) { ?>
                    </a>

                <? if ($object->getTitleAddon()) {
                    echo '<small>' . $object->getTitleAddon() . '</small>';
                }
                } ?>

                </<?= $titleTag ?>>
            <? } ?>

                <?
                if ($file_exists) {
                    echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
                        'item' => $item,
                        'object' => $object
                    ));
                } else {
                    echo $this->Dataobject->highlights($hlFields);
                    if ($object->getDescription()) {
                        ?>
                        <div class="description">
                            <?= $object->getDescription() ?>
                        </div>
                    <?
                    }
                }
                ?>
            </div>

            <? } else { ?>
            <div class="content">

                <<?= $titleTag ?> class="title<? if ($bigTitle) { ?> big<? } ?>">
                <?php if ($object->getUrl() != false){ ?>
                <a class="trimTitle" href="<?= $object->getUrl() ?>"
                   title="<?= strip_tags($object->getTitle()) ?>">
                    <?php } ?>
                    <?= $object->getShortTitle() ?>
                    <?php if ($object->getUrl() != false){ ?>
                </a> <? if ($object->getTitleAddon()) {
                echo '<small>' . $object->getTitleAddon() . '</small>';
            } ?>
            <?php } ?>
            </<?= $titleTag ?>>
            <?
            if ($file_exists) {
                echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
                    'item' => $item,
                    'object' => $object
                ));
            } else {
                echo $this->Dataobject->highlights($hlFields);
                if ($object->getDescription()) {
                    ?>
                    <div class="description">
                        <?= $object->getDescription() ?>
                    </div>
                <?
                }
            }
            ?>

        </div>
    <? } ?>
    </div>
</div>
</div>
</div>