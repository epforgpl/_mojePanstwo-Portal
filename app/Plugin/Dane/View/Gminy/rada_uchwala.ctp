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
        'truncate' => 1024,
    )
));

?>
    <div class="prawo row">

        <div class="col-md-12">
            <div class="object">
                <?= $this->Document->place($uchwala->getData('dokument_id')) ?>
            </div>
        </div>


    </div>
<?
echo $this->Element('dataobject/pageEnd');