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