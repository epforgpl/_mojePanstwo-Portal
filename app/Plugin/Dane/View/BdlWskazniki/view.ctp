<? echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('js', 'Bdl.bdlapp');
echo $this->Element('Bdl.leftsideaccordion', array('tree' => $tree));
echo $this->Element('Bdl.item');

echo $this->Element('dataobject/pageEnd');