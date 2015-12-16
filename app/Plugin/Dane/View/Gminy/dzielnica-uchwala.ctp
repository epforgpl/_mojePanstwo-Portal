<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));


echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => false,
    'object' => $uchwala,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    ),
));
?>

<div class="prawo row">

    <div class="col-md-9">
        <div class="object margin-top-20">
            <?= $this->Document->place($uchwala->getData('dokument_id'), array('toolbar' => false)) ?>
        </div>
    </div>


</div>

<?
echo $this->Element('dataobject/pageEnd');
