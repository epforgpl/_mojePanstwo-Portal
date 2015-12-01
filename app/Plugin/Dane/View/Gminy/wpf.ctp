<?
$this->Combinator->add_libs('js', 'Dane.view-gminy-wpf');
echo $this->Element('dataobject/pageBegin');

echo $this->Element('Dane.DataBrowser/browser');

echo $this->Element('dataobject/pageEnd');