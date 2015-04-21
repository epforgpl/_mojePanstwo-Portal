<?
$this->Combinator->add_libs('css', $this->Less->css('view-msig', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

<?= $this->Document->place($object->getData('dokument_id')) ?>

<?= $this->Element('dataobject/pageEnd'); ?>