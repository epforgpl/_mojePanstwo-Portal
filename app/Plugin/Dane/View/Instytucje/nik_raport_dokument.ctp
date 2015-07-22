<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $dokument,
    'objectOptions' => array(
	    'truncate' => 1000,
	    'mode' => 'subobject',
	    'routes' => array(
		    'titleAddon' => false,
	    ),
	),
));

?><div class="prawo row">

    <div class="col-md-12">
        <div class="object">
            <?= $this->Document->place($dokument->getData('dokument_id')) ?>
        </div>
    </div>


</div><?

echo $this->Element('dataobject/pageEnd');