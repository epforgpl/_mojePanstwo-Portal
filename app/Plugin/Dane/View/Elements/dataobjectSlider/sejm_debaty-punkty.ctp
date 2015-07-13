<p class="title">
    <a href="<?= $object->getUrl() ?>"
       title="<?= strip_tags($object->getTitle()) ?>">Część <?= $object->getData('punkt_i') ?></a>
</p>

<div class="header">
    <div class="dataHighlight">
        <p class="_date"><?= $this->Czas->dataSlownie($object->getDate()) ?></p>
    </div>
    <?
    if (isset($options['dfFields']) && !empty($options['dfFields'])) {
        $fields = $object->getHiglightedFields($options['dfFields']);
        foreach ($fields as $field) {

            echo $this->Dataobject->getHTMLForField(false, $field, array(
                'col_width' => false,
            ));

        }
    }
    ?>
</div>