<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">
	<div class="col-sm-9">
		<?= $this->Document->place( $object->getData('prawo.dokument_id') ) ?>
	</div>
</div>

<? echo $this->Element('dataobject/pageEnd'); ?>