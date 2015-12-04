<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $dzielnica,
    'objectOptions' => array(
        'bigTitle' => true,
        'hlFields' => array(),
    )
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $dzielnica->getUrl();

$options = array(
	'menu' => $_submenu,
	'class' => 'margin-top--5',
);

if(isset($cadences))
    $options['pills'] = $cadences;

echo $this->Element('Dane.DataBrowser/browser', $options);

echo $this->Element('dataobject/pageEnd', array(
    'titleTag' => 'p',
));
?>
