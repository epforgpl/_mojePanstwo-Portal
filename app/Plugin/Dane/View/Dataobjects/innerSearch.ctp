<?php echo $this->Element('dataobject/pageBegin'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php echo $this->Element('dataobject/innerSearch', array(
    'searchTitle' => $searchTitle,
    'dataset' => $dataset,
    'filters' => $filters,
    'facets' => $facets,
    'pagination' => $pagination,
    'dataobjects' => $dataobjects,
    'object' => $object
)); ?>
<?php echo $this->Element('dataobject/pageEnd'); ?>