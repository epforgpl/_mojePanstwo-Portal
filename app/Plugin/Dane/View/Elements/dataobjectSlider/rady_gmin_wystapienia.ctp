<div class="attachment col-md-12">
    <a href="<?= $object->getUrl() ?>">
        <img src="<?= $object->getThumbnailUrl('1') ?>" alt="<?= strip_tags($object->getTitle()) ?>"
             onerror="imgFixer(this)"/>
    </a>
</div>
<div class="content col-md-12">

    <?
    $title_truncate_length = 120;

    echo $this->element('Dane.dataobjectSlider/_header', array(
        'object' => $object,
        'options' => $options,
    ));
    ?>

    <p class="title">
        <a href="<?= $object->getUrl() ?>"
           title="<?= strip_tags($object->getData('rady_gmin_debaty.tytul')) ?>"><?= $this->Text->truncate($object->getData('rady_gmin_debaty.tytul'), $title_truncate_length) ?></a>
    </p>

</div>