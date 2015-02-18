<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy-interpelacja', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $interpelacja,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));
?>
<h2 class="light">Interpelacja</h2>
<?

echo $this->Element('docsBrowser/doc', array(
    'document' => $document,
    'documentPackage' => $documentPackage,
));

if( isset($document1) ) {
	echo "<h2 class=\"light\">Odpowiedź</h2>";
	echo $this->Element('docsBrowser/doc', array(
	    'document' => $document1,
	    'documentPackage' => $documentPackage,
	));
}

if( isset($document2) ) {
	echo "<h2 class=\"light\">Odpowiedź</h2>";
	echo $this->Element('docsBrowser/doc', array(
	    'document' => $document2,
	    'documentPackage' => $documentPackage,
	));
}

echo $this->Element('dataobject/pageEnd');