<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>

<? /*= $this->Element('bdl_select', array(
    'expand_dimension' => $expand_dimension,
    'dims' => $dims,
    'redirect' => true
)); */ ?>

<?
$this->Combinator->add_libs('js', 'Bdl.bdlapp');
echo $this->Element('Bdl.leftsideaccordion', array('tree' => $tree));
echo $this->Element('Bdl.item');
?>

<?= $this->Element('dataobject/pageEnd'); ?>