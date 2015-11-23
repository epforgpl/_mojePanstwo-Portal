<?
	
	$from = false;
	$to = false;
	
	if( $object->getData('pisma.page_name') )
		$from = array(
			'href' => '/dane/krs_podmioty/' . $object->getData('pisma.page_object_id') . ',' . $object->getData('pisma.page_slug'),
			'title' => mb_strtolower( $object->getData('pisma.page_name') ),
		);
	elseif( $object->getData('pisma.from_user_name') )
		$from = array(
			'title' => $object->getData('pisma.from_user_name'),
		);
			
	if( $object->getData('pisma.to_label') )
		$to = array(
			'title' => $object->getData('pisma.to_label'),
		);
	
?>
<div>
<? if( $from ) { ?>		
	<p class="custom-par"><span class="_label">Od:</span> <span class="_value"><?= $from['title'] ?></span></p>
<? } ?>

<? if( $to ) { ?>		
	<p class="custom-par"><span class="_label">Do:</span> <span class="_value"><?= $to['title'] ?></span></p>
<? } ?>
</div>