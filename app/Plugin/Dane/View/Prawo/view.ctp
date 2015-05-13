<? echo $this->Element('dataobject/pageBegin'); ?>

    
    <div class="row">
        
        <div class="object col-md-10">
	        
	        <? echo $this->Element('Dane.sides/' . $this->request->params['controller'] . '-top'); ?>
	        
            <?= $this->Document->place( $object->getData('dokument_id') ) ?>
        </div>
    </div>
        

<?= $this->Element('dataobject/pageEnd'); ?>