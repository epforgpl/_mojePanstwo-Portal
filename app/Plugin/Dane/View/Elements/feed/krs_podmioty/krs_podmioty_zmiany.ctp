<ul class="krs_podmioty_zmiany_ul">
<?
	if( $object->getData('wpisac') ) {
?>
	<li class="aoverflow">
		<p class="status label label-success">Wpisano</p> <?= $object->getData('wpisac') ?>
	</li>
<?		
	}

	if( $object->getData('wykreslic') ) {
?>
	<li class="aoverflow">
		<p class="status label label-danger">Wykreślono</p> <?= $object->getData('wykreslic') ?>
	</li>
<?		
	}
?>
</ul>
<p class="text-right col-md-12"><a href="/dane/msig_dzialy/<?= $object->getData('dzial_id') ?>">MSiG</a></p>