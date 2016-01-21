<?
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Dane.view-gminy-posiedzenie');
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-posiedzenie-punkty', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));


echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
        'routes' => array(
            'shortTitle' => 'pageTitle'
        ),
        'thumbWidth' => 2,
    ),
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $posiedzenie->getUrl();

echo $this->Element('Dane.DataBrowser/browser', array(
    'class' => 'margin-top--5',
    'menu' => $_submenu,
));

echo $this->Element('dataobject/pageEnd');
