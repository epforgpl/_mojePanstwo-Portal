<?
	if( (@$mode!='short') && isset($data['zmiany']) && !empty($data['zmiany']) ) {
?>
<table class="table table-striped table-hover ">
	<thead>
		<tr>
			<th>Zmiana</th>
		</tr>
	</thead>
	<tbody>
	<? 
		foreach( $data['zmiany'] as $zmiana ) { 
			
			// $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
			// $href = isset( $zmiana['krs_osoba_id'] ) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;
			
	?>
		<tr>
			<td><?= $zmiana ?></td>			
		</tr>
	<? } ?>
	</tbody>
</table>    
<?		
	}
?>