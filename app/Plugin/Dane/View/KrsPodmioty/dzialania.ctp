<?

echo $this->Element('dataobject/pageBegin');
echo $this->Element('Dane.DataBrowser/browser', array(
	'sideElement' => 'Dane.KrsPodmioty/dodaj_dzialanie',
));
echo $this->Element('dataobject/pageEnd');
