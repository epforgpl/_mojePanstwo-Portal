<?
if ($object->getData('typ_id') == '2') {
    ?>
    <p style="color: green; margin: 5px;"><?= $object->getData('autor_str') ?></p>
<?
}
if( $object->getData('html') ) {
?>
    <p style="margin: 5px;"><?= $object->getData('html') ?></p>
<?
}
?>
<p style="margin-left: 5px;">
    <a href="<?= $object->getUrl() ?>">Przeczytaj &raquo;</a>
</p>

