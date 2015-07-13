<?

$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzenia', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzenia-databrowser-fix', array('plugin' => 'Dane')));

echo $this->Element('Dane.dataobject/pageBegin');

echo $this->Element('Dane.sejmposiedzenie-projekty-cont', array(
    'projekty' => $object->getLayer('projekty'),
));
echo $this->Element('Dane.dataobject/pageEnd');
	