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
    <div class="objectRender col-md-12">
        <div class="data col-md-11">
            <div class="row">
                <div class="content mini">
                    <!--<h1 class="title">Bank danych lokalnych</h1>
                    <p class="header"><?= $object->getData('bdl_wskazniki.kategoria_tytul'); ?></p>
                    <p class="text-muted"><?= $object->getData('bdl_wskazniki.tytul'); ?></p>-->
                    <ul class="tree">
                        <li>
                            <h1 class="title">Bank danych lokalnych</h1>
                            <ul>
                                <li class="e">
                                    <?= $object->getData('bdl_wskazniki.kategoria_tytul'); ?>
                                    <ul>
                                        <li class="e">
                                            <?= $object->getData('bdl_wskazniki.grupa_tytul'); ?>
                                            <ul>
                                                <li class="e"><?= $object->getData('bdl_wskazniki.tytul'); ?></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<? } ?>