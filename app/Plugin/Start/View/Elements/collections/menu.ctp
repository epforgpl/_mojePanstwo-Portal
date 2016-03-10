<?
	$items = array(
		array(
			'id' => 'view',
			'href' => $pismo['alphaid'] . ',' . $pismo['slug'],
			'label' => 'Pismo',
		),
		array(
			'id' => 'edit',
			'href' => $pismo['alphaid'] . ',' . $pismo['slug'] . '/edit',
			'label' => 'Edycja pisma',
		),

        array(
			'id' => 'anonymize',
			'href' => $pismo['alphaid'] . ',' . $pismo['slug'] . '/anonymize',
			'label' => 'Anonimizacja pisma',
		),
	);

if (!isset($active))
		$active = false;
?>

<div class="appMenu margin-top-10">
    <div class="container">
        <ul class="margin-sides-10">
	    <?
		    foreach( $items as $item ) {
		?>
			<li<? if( $item['id'] == $active ) {?> class="active"<? } ?>>
	            <a href="/moje-pisma/<?= $item['href'] ?>"><?= $item['label'] ?></a>
            </li>
		<? } ?>

        </ul>
    </div>
</div>
