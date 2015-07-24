<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $okreg,
    'objectOptions' => array(
        'truncate' => 1000,
        'mode' => 'subobject',
    ),
));
?>

<?
echo $this->Element('dataobject/pageEnd');