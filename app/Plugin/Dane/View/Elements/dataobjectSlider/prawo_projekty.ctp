<div class="attachment col-md-3">
    <a href="<?= $object->getUrl() ?>">
        <img src="<?= $object->getThumbnailUrl('1') ?>" alt="<?= strip_tags($object->getTitle()) ?>"
             onerror="imgFixer(this)"/>
    </a>
</div>
<div class="content col-md-9">

    <?
    $title_truncate_length = 120;

    echo $this->element('Dane.dataobjectSlider/_header', array(
        'object' => $object,
        'options' => $options,
    ));
    ?>

    <p class="title">
        <a href="<?= $object->getUrl() ?>"
           title="<?= strip_tags($object->getTitle()) ?>"><?= $this->Text->truncate($object->getShortTitle(), $title_truncate_length) ?></a>
    </p>

    <?
    if ($object->getData('typ_id') != '6') {
    ?>
</div>
</div>

<div class="row description">
    <?= $object->getData('autorzy_html') ?>
</div>

<div>
    <div>
        <? } ?>

        <?
        if ($object->getDescription()) {
        if (isset($options['descriptionMode']) && ($options['descriptionMode'] == 'none')) {
        } else {
        ?>
    </div>
</div>


<div class="row description">
    <?
    $desc = strip_tags(preg_replace('/\<br(\s*)?\/?\>/i', "\n", $object->getDescription()));
    echo nl2br($this->Text->truncate($desc, 200));
    ?>
</div>

<div>
    <div>
        <?
        }
        }
        ?>

    </div>