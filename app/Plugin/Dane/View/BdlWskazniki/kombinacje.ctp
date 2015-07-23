<?php $this->Combinator->add_libs('css', $this->Less->css('view-bdl-wskazniki', array('plugin' => 'Dane'))); ?>

<? $this->Combinator->add_libs('js', 'Bdl.bdlapp'); ?>

<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>

<?= $this->Element('Bdl.leftsideaccordion', array('tree' => $tree)); ?>

<?= $this->Element('bdl_select', array(
    'expand_dimension' => $expand_dimension,
    'dims' => $dims,
    'redirect' => true
)); ?>

<?= $this->Element('Bdl.item'); ?>

<?= $this->Element('dataobject/pageEnd'); ?>