<div class="content">

    <? echo $this->element('dataobjectSlider/_header', array(
        'object' => $object,
        'options' => $options,
    )); ?>

    <p class="title">
        <a href="<?= $object->getUrl() ?>"
           title="<?= strip_tags($object->getTitle()) ?>"><?= $this->Text->truncate($object->getData('skrot'), 130) ?></a>
    </p>

</div>
