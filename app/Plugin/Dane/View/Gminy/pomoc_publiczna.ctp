<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin');

if (!isset($_submenu['base']))
	$_submenu['base'] = $object->getUrl();

echo $this->Element('Dane.DataBrowser/browser', array(
	'menu' => $_submenu,
    'class' => 'margin-top--5',
));
echo $this->Element('dataobject/pageEnd');
