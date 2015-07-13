<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));

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

echo $this->Element('Dane.DataobjectsFeed/view', array());

if ($__mode == 'object') {
    echo $this->Element('Dane.dataobject/pageEnd');
}