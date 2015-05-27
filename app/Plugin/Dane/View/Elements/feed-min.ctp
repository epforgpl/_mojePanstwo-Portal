<?

$this->Combinator->add_libs('css', $this->Less->css('feed', array('plugin' => 'Dane')));

$file_exists = false;
if (isset($file)) {
    $path = App::path('Plugin');
    $file_exists = file_exists($path[0] . '/Dane/View/Elements/' . $file . '-min.ctp');
}

$shortTitle = (isset($options['forceTitle'])) ? $options['forceTitle'] : $object->getShortTitle();

if (in_array($object->getDataset(), array(
    'krakow_posiedzenia_punkty',
    'rady_gmin_debaty',
    'rady_gmin_wystapienia'
))) {
    $object_content_sizes = array(3, 9);
} else {
    $object_content_sizes = array(2, 10);
}

$this->Dataobject->setObject($object);
?>

<div class="objectRender<? if ($classes = $object->getClasses()) {
    echo " " . implode(' ', $classes);
} ?>"
     oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <div class="row">
        <div class="data col-xs-11">
            <div class="feed-header">
                <? if ($object->getCreator('url')) { ?>
                    <div class="thumb_cont">
                        <object data="/error/brak.gif" type="image/png">
                            <img alt="<?= addslashes($object->getCreator('name')) ?>"
                                 src="<?= $object->getCreator('url') ?>" class="thumb"/>
                        </object>
                    </div>
                <? } ?>

                <div class="inner">
                    <? if ($sentence = $object->getSentence()) { ?>

                        <p class="date"><?= $this->Czas->dataSlownie($object->getDate()) ?></p>
                        <p class="title">
                            <?php if ($object->getUrl() != false) { ?>
                            <a href="<?= $object->getUrl() ?>" title="<?= strip_tags($object->getTitle()) ?>">
                                <?php } ?>
                                <?= $this->Text->truncate($shortTitle, 200) ?>
                                <?php if ($object->getUrl() != false) { ?>
                            </a> <?
                        }
                        if ($object->getTitleAddon()) {
                            echo '<small>' . $object->getTitleAddon() . '</small>';
                        } ?>
                        </p>

                    <? } ?>
                </div>
            </div>

            <?
            if ($file_exists) {
                echo $this->element('Dane.' . $file, array(
                    'object' => $object,
                    'hlFields' => $hlFields,
                    'hlFieldsPush' => $hlFieldsPush,
                    'defaults' => $defaults,
                ));
            }
            ?>

        </div>
    </div>
    <?php if ($object->hasHighlights() && $object->getHlText()) { ?>
        <div class="row">
            <div class="text-highlights alert alert-info">
                <?php echo(closetags($object->getHlText())); ?>
            </div>
        </div>
    <?php } ?>
</div>