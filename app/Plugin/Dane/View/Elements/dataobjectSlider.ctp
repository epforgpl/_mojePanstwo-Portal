<?

$path = App::path('Plugin');

$element = (isset($file) && $file) ?
    $file :
    $object->getDataset();

$element_exists = $element ?
    file_exists($path[0] . '/Dane/View/Elements/' . $theme . '/' . $element . '.ctp') :
    false;

?>
<div class="objectRender col-md-12 <?php echo $object->getDataset() ?>" oid="<?php echo $object->getId() ?>">
    <div class="row">

        <?
        if ($element_exists) {
            echo $this->element('Dane.' . $theme . '/' . $element, array(
                'object' => $object,
                'options' => $options,
            ));
        } else {
            ?>

            <? if ($object->getThumbnailUrl()) { ?>


                <? if ($object->getDate()) { ?>
                    <div class="slide_header">
                        <p class="label label-default"><?= dataSlownie($object->getDate()) ?></p>
                    </div>
                <? } ?>

                <div class="attachment col-md-4">
                    <a href="<?= $object->getUrl() ?>">
                        <object data="/img/error/brak.gif" type="image/png">
                            <img src="<?= $object->getThumbnailUrl('1') ?>"
                                 alt="<?= strip_tags($object->getTitle()) ?>"/>
                        </object>
                    </a>
                </div>
                <div class="content col-md-8">

                    <?php echo $this->element('Dane.dataobjectSlider/_content', array(
                        'object' => $object,
                        'options' => $options,
                    )); ?>

                </div>
            <? } else { ?>

                <? if ($object->getDate()) { ?>
                    <div class="slide_header">
                        <p class="label label-default"><?= dataSlownie($object->getDate()) ?></p>
                    </div>
                <? } ?>

                <div class="content col-md-12">

                    <?php echo $this->element('Dane.dataobjectSlider/_content', array(
                        'object' => $object,
                        'options' => $options,
                    )); ?>

                </div>
            <? } ?>


        <? } ?>

    </div>
</div>