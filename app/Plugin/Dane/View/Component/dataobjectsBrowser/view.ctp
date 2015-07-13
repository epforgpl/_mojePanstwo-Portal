<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', 'Dane.filters');


$__mode = false;
if (isset($object) && method_exists($object, 'getId') && $object->getId()) {
    $__mode = 'object';
}


if ($__mode == 'object') {
    echo $this->element('Dane.dataobject/pageBegin');
}

if (isset($originalViewPath)) {
    include($originalViewPath);
}

echo $this->Element('Dane.DataobjectsBrowser/view', array(
    'page' => $page,
    'pagination' => $pagination,
    'filters' => $filters,
    'switchers' => $switchers,
    'facets' => $facets,
    'renderFile' => $renderFile,
));

if ($__mode == 'object') {
    echo $this->Element('Dane.dataobject/pageEnd');
}

?>