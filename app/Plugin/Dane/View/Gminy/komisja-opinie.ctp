<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    // 'menu' => $_submenu,
    'object' => $komisja,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $komisja->getUrl();

echo $this->Element('Dane.DataBrowser/browser', array(
    'menu' => $_submenu,
    'class' => 'margin-top--5',
));
echo $this->Element('dataobject/pageEnd');
