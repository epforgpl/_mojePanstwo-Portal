<?

echo $this->Element('dataobject/pageBegin');

$params = array();

if(isset($object_editable) && in_array('logo', $object_editable)) {
    $params = array(
        'sideElement' => 'Dane.KrsPodmioty/dodaj_dzialanie'
    );
}

echo $this->Element('Dane.DataBrowser/browser', $params);

echo $this->Element('dataobject/pageEnd');