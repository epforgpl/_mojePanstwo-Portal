<?

	$date_parts = explode('-', $object->getDate());	
	$date = strtotime( $object->getDate() );
	$day = date('N', $date);
	
?>
<div class="objectRender">
	<div class="date-div">
		
		<a href="<?= $object->getUrl() ?>" class="date-icon">
			<span class="binds"></span>
			<span class="month"><?= $object->getMonth() ?></span>
			<span class="day"><?= $date_parts[2] ?></span>
		</a>
		
	</div><div class="date-div-content">
		
		<p class="title">
	    	<a href="<?= $object->getUrl() ?>"><?= $object->getDay() ?></a>
		</p>
		<p class="meta meta-desc"><?= $object->getMetaDescription(); ?></p>
		
	</div>
</div>