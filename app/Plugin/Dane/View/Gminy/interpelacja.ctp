<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-interpelacja', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>

<? echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $interpelacja,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));
?>
    <h2 class="light">Interpelacja</h2>

 	<div class="row">
        <div class="col-md-9">

            <?

echo $this->Document->place($interpelacja->getData('dokument_id'), array('toolbar' => false));

if ($interpelacja->getData('odp1_dokument_id')) {
    echo "<h2 class=\"light\">Odpowiedź</h2>";
    echo $this->Document->place2($interpelacja->getData('odp1_dokument_id'), array('toolbar' => false));
}

if ($interpelacja->getData('odp2_dokument_id')) {
    echo "<h2 class=\"light\">Odpowiedź</h2>";
    echo $this->Document->place2($interpelacja->getData('odp2_dokument_id'), array('toolbar' => false));
}
?>

	 	</div>
 	</div>

<? echo $this->Element('dataobject/pageEnd');
