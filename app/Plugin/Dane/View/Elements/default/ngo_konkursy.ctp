<?
	if($object->getData('area_id')) {
		require_once(APPLIBS . '/DataobjectDictionary.php');
	    $dictionary = new MP\Lib\DataobjectDictionary();    
?>
	<ul class="tags">
	<?
		foreach( $object->getData('area_id') as $area_id ) {
	?>
		<li><a href="/ngo/konkursy?&conditions[ngo_konkursy.area_id]=<?= $area_id ?>" class="label label-default label-xs"><?= $dictionary->label('ngo_konkursy_areas', $area_id) ?></a></li>
	<?		
		}
	?>
	</ul>
<? } ?>