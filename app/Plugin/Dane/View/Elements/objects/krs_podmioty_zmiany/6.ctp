<?
	if( !empty($data) ) {
?>
<table class="table table-striped table-hover ">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Przed</th>
			<th>Po</th>
		</tr>
	</thead>
	<tbody>
	<? 
		foreach( $data as $z ) { 
			
			// $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
			// $href = isset( $zmiana['krs_osoba_id'] ) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;
			
	?>
		<tr>
			<td><b><?= $z['tytul'] ?></b></td>			
			<td><?= $z['dane']['-'][0] ?></td>			
			<td><?= $z['dane']['+'][0] ?></td>			
		</tr>
	<? } ?>
	</tbody>
</table>    
<?		
	}
?>