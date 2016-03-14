<?
$this->Combinator->add_libs('css', $this->Less->css('view-msig', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<?= $this->Document->place($object->getData('dokument_id')) ?>
	</div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>