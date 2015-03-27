<?
$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

if (in_array($object->getDataset(), array('rady_posiedzenia'))) {
    $object_content_sizes = array(3, 9);
} else {
    $object_content_sizes = array(2, 10);
}

$this->Dataobject->setObject($object);

if (($object->getDataset() == 'gminy') && ($object->getId() == '903')) {

    echo $this->element('Dane.przejrzystykrakow_header', array(
        'item' => $item,
        'object_content_sizes' => $object_content_sizes,
        'titleTag' => $titleTag,
        'bigTitle' => $bigTitle,
        'thumbSize' => $thumbSize,
    ));

} else {
    ?>
    <div class="objectRender col-md-12 <?php echo $object->getDataset(); ?>" oid="<?php echo $object->getId(); ?>">
        <div class="row">
            <div class="tree">
                <ul>
                    <li class="active noparent">
                        <a class="title">Bank danych lokalnych</a>
                        <ul>
                            <li class="noparent" id="k<?= $object->getData('kategoria_id'); ?>">
                                <a class="title"><?= $object->getData('bdl_wskazniki.kategoria_tytul'); ?></a>
                                <ul class="insertHere"></ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <input type="hidden" id="kid" value="<?= $object->getData('kategoria_id'); ?>"/>
            <input type="hidden" id="wid" value="<?= $object->getData('bdl_wskazniki.id'); ?>"/>
            <input type="hidden" id="gid" value="<?= $object->getData('grupa_id'); ?>"/>
    </div>
    </div>
<? } ?>