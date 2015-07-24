<? 
	
if ($object->getData('opis')) { ?>
    <div class="opis">
        <?= $object->getData('opis') ?>
    </div>
<? } 

echo $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims));
echo $this->Element('Bdl.item');