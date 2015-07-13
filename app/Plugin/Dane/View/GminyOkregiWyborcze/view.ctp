<?php
// $this->Combinator->add_libs('css', $this->Less->css('view-kolejestacje', array('plugin' => 'Dane')));

// echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
// echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
// $this->Combinator->add_libs('js', 'Dane.view-kolejestacje');
?>

<?php echo $this->Element('dataobject/pageBegin'); ?>
<?php echo $this->Element('dataobject/objects/gminy_okregi_wyborcze/page', array(
    'object' => $object,
)); ?>;
<?php echo $this->Element('dataobject/pageEnd'); ?>
