<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $jednostka,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    ),
));

echo $this->Element('Dane.DataBrowser/browser');
echo $this->Element('dataobject/pageEnd');
