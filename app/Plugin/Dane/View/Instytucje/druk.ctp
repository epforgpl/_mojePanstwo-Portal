<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $druk,
    'objectOptions' => array(
	    'truncate' => 1000,
	    'mode' => 'subobject',
	),
));
?><div class="prawo row">

    <div class="col-md-9">
        <div class="object">
            <?= $this->Document->place($druk->getData('dokument_id')) ?>
        </div>
    </div>


</div><?
echo $this->Element('dataobject/pageEnd');