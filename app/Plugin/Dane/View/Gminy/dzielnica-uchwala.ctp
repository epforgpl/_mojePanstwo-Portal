<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

/*
echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => $_submenu,
    'object' => $dzielnica,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));
*/

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => false,
    'object' => $uchwala,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    ),
    'back' => array(
	    'href' => $dzielnica->getUrl(),
		'title' => 'Dzielnica ' . $dzielnica->getTitle(),
    ),
));

if( $pagination['total'] ) {
	echo $this->Element('Dane.DataobjectsBrowser/view', array(
	    'page' => $page,
	    'pagination' => $pagination,
	    'filters' => $filters,
	    'switchers' => $switchers,
	    'facets' => $facets,
	    'renderFile' => 'krakow_dzielnice_uchwaly-glosy',
	));
}

if( isset($document) )
	echo $this->Document->place($document);


echo $this->Element('dataobject/pageEnd');