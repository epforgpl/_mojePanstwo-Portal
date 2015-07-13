<div class="content">

    <? echo $this->element('dataobjectSlider/_header', array(
        'object' => $object,
        'options' => $options,
    )); ?>

    <p class="title">
        <a href="/dane/sejm_glosowania/<?= $object->getData('sejm_glosowania.id') ?>"
           title="<?= strip_tags($object->getTitle()) ?>"><?= $this->Text->truncate($object->getData('sejm_glosowania.tytul'), 130) ?></a>
    </p>

    <div data-glos="<?= $object->getData('glos_id') ?>"
         class="voted btn btn-default btn-glos-<?= $object->getData('glos_id') ?>"><?= $this->Dataobject->voted($object->getData('glos_id')) ?></div>

</div>
