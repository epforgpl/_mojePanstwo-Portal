<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $komisja_opinia,
    'objectOptions' => array(
        'bigTitle' => true,
        'truncate' => 1024,
    )
));

?>
    <div class="prawo margin-sides-10">


        <div class="row">

            <div class="col-md-9">
				<div class="margin-top-20">
	                <?= $this->Document->place($komisja_opinia->getData('dokument_id'), array('toolbar' => false)) ?>
				</div>
            </div>


        </div>


    </div>
<?
echo $this->Element('dataobject/pageEnd');
