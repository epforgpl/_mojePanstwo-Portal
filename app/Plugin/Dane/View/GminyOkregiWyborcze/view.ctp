<?php
// $this->Combinator->add_libs('css', $this->Less->css('view-kolejestacje', array('plugin' => 'Dane')));

//switch (Configure::read('Config.language')) { case 'pol': $lang = "pl-PL"; break; case 'eng': $lang = "en-EN"; break; };
// echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language='.$lang, array('block' => 'scriptBlock'));
// echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
// $this->Combinator->add_libs('js', 'Dane.view-kolejestacje');
?>

<?php echo $this->Element('dataobject/pageBegin'); ?>
<?php echo $this->Element('dataobject/objects/gminy_okregi_wyborcze/page', array(
    'object' => $object,
)); ?>;
<?php echo $this->Element('dataobject/pageEnd'); ?>
