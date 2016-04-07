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

<?= $this->Element('Dane.DataBrowser/browser') ?>

<?
echo $this->Element('dataobject/pageEnd');