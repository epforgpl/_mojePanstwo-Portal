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
    'object' => $uchwala,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));

?>
<div class="prawo row">
    <div class="col-md-2 objectSide">

        <? echo $this->Element('Dane.sides/krakow_rada_uchwaly-left', array(
        	'object' => $uchwala,
        )); ?>

    </div>
    <div class="col-md-10 nopadding">
        <div class="object">
            <?= $this->Document->place( $uchwala->getData('dokument_id') ) ?>
        </div>
    </div>

</div>
<?
echo $this->Element('dataobject/pageEnd');