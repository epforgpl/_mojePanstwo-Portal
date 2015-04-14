<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $druk,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));
?>

<h2 class="light"><a class="btn-back glyphicon glyphicon-circle-arrow-left" href="<?= $druk->getUrl() ?>"></a> <?= $druk_dokument->getTitle() ?></h2>

<?

echo $this->Document->place($druk_dokument->getData('dokument_id'));
echo $this->Element('dataobject/pageEnd');