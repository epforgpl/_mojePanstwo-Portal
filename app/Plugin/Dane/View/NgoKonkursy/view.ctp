<?php ////$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="object">
		
		<? debug( $object->getData() ); ?>
        
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>