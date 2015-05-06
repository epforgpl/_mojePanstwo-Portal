<style>
	#_wrapper {
		background: #FAFAFA;
	}
</style>
<? echo $this->Element('dataobject/pageBegin'); ?>

    <div class="prawo row">
        	
    	<div objectSide">

            <? echo $this->Element('Dane.sides/' . $this->request->params['controller'] . '-top'); ?>

        </div>
    	
        <div class="object">
            <?= $this->Document->place( $object->getData('dokument_id') ) ?>
        </div>
        

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>