<?
echo $this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
echo $this->Combinator->add_libs('js', 'Dane.view-gminy-posiedzenie');
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
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

echo $this->Element('Dane.DataBrowser/browser', array(
	'searcher' => false,
	'class' => 'panel',
	'displayAggs' => false,
));

echo $this->Element('dataobject/pageEnd');