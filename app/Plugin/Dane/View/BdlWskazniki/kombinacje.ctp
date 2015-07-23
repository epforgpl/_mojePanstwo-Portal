<?php $this->Combinator->add_libs('css', $this->Less->css('view-bdl-wskazniki', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-map'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-highmap'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki'); ?>

<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>

<?= $this->Element('Bdl.leftsideaccordion', array('tree' => $tree)); ?>

<?= $this->Element('bdl_select', array(
    'expand_dimension' => $expand_dimension,
    'dims' => $dims,
    'redirect' => true
)); ?>

<?= $this->Element('Bdl.subitem'); ?>

<?= $this->Element('dataobject/pageEnd'); ?>