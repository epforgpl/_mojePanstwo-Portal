<?

echo $this->Element('dataobject/pageBegin');
$params = array(
	'paginatorPhrases' => array('pismo','pisma','pism'),
);

echo $this->Element('Dane.DataBrowser/browser', $params);

echo $this->Element('dataobject/pageEnd');
