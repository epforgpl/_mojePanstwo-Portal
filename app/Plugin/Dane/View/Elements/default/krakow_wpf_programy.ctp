<? 
	
	$static = $object->getStatic();	
	$count = count( array_filter(array_unique(array_column($static['years'], 1))) );
	
	if( $count > 1 ) { 
?>
<div
    class="krakowWpfProgramStatic margin-top-20"
    data-static="<?= htmlspecialchars(json_encode($object->getStatic())); ?>">
</div>
<? } ?>