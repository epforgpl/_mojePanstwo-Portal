<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));

$this->Combinator->add_libs('css', $this->Less->css('icon-dzialy', array('plugin' => 'Finanse')));
$this->Combinator->add_libs('css', $this->Less->css('sections', array('plugin' => 'FinanseGmin')));
$this->Combinator->add_libs('css', $this->Less->css('mp-sections', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-finanse', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-finanse');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $object->getUrl();

echo $this->Element('Dane.DataBrowser/browser', array(
    'menu' => $_submenu,
));

echo $this->Element('dataobject/pageEnd', array(
    'titleTag' => 'p',
));
