<?

$this->Combinator->add_libs('css', $this->Less->css('view-prawo_projekty', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $projekt,
    'objectOptions' => array(
        'bigTitle' => true,
        'truncate' => 1024,
    )
));

?>
    <div class="prawo margin-sides-20">

		<? echo $this->Element('Dane.dataobject/feed'); ?>            

    </div>
<?
echo $this->Element('dataobject/pageEnd');
