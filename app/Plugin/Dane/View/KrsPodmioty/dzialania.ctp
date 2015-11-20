<?
echo $this->Element('dataobject/pageBegin');

echo $this->Element('Dane.DataBrowser/browser', array(
	'paginatorPhrases' => array('działanie', 'działania', 'działań'),
));

echo $this->Element('dataobject/pageEnd');