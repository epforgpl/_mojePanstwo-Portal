<?

$objectRenderOptions = array(
    'forceLabel' => (isset($dataBrowserObjectRender) && isset($dataBrowserObjectRender['forceLabel'])) ? (boolean)$dataBrowserObjectRender['forceLabel'] : false,
);


$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

$shortTitle = (isset($options['forceTitle'])) ?
    $options['forceTitle'] :
    $object->getShortTitle();

$object_content_sizes = array(2, 10);

// debug( $object->getData() ); 

$this->Dataobject->setObject($object);
?>
<div class="objectRender<? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?><? if ($classes = $object->getClasses()) {
    echo " " . implode(' ', $classes);
} ?>"
     oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <div class="row">

        <div class="data col-xs-12">

            <? if ($sentence = $object->getSentence()) { ?>
                <p class="sentence"><?= $sentence ?></p>
            <? } ?>

            <div>


                <div
                    class="attachment col-xs-6 nopadding text-center">
                    <?php if ($object->getUrl() != false) { ?>
                    <a class="thumb_cont" href="<?= $object->getUrl() ?>">
                        <?php } ?>
                        <img class="thumb pull-right"
                             src="<?= $object->getThumbnailUrl($thumbSize) ?>"
                             alt="<?= strip_tags($object->getTitle()) ?>" onerror="imgFixer(this)"/>
                        <?php if ($object->getUrl() != false) { ?>
                    </a>
                <?php } ?>

                </div>
                <div class="content col-xs-6">


                    <p class="title">
                        <?php if ($object->getUrl() != false) { ?>
                        <a href="<?= $object->getUrl() ?>" title="<?= strip_tags($object->getTitle()) ?>">
                            <?php } ?>
                            <?= $this->Text->truncate($shortTitle, 150) ?>
                            <?php if ($object->getUrl() != false) { ?>
                        </a> <?
                    }
                    if ($object->getTitleAddon()) {
                        echo '<small>' . $object->getTitleAddon() . '</small>';
                    } ?>
                    </p>

                    <? if ($metaDesc = $object->getMetaDescription()) { ?>
                        <p class="meta meta-desc"><?= $metaDesc ?></p>
                    <? } ?>

                    <?
                    if ($file_exists) {
                        echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
                            // 'item' => $item,
                            'object' => $object,
                            'hlFields' => $hlFields,
                            'hlFieldsPush' => $hlFieldsPush,
                            'defaults' => $defaults,
                        ));
                    } else {

                        // echo $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults);
                    }
                    ?>

                    <? if (
                        ($object->hasHighlights()) &&
                        ($highlight = $object->getLayer('highlight'))
                    ) { ?>
                        <? if ($highlight[0] != '<em>' . $object->getShortTitle() . '</em>') { ?>
                            <div class="description highlight">
                                <?= $highlight[0] ?>
                            </div>
                        <? } ?>
                    <? } elseif ($object->getDescription()) { ?>
                        <div class="description">
                            <?= $object->getDescription() ?>
                        </div>
                    <? } ?>

                </div>

            </div>
        </div>
    </div>
</div>