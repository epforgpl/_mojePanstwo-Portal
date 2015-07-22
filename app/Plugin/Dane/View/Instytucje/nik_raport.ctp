<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $raport,
    'objectOptions' => array(
	    'truncate' => 1000,
	    'mode' => 'subobject',
	),
));
?>

<div class="col-md-12"><?= $this->Element('Dane.DataBrowser/browser') ?></div>

<?
echo $this->Element('dataobject/pageEnd');