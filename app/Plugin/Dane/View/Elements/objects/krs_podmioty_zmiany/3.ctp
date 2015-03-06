<?
	if( isset($data['wykreslono']) && !empty($data['wykreslono']) ) {
?>
<p class="label label-danger">Usunięto</p>
<table class="table table-striped table-hover ">
	<thead>
		<tr>
			<th>Dział PKD</th>
		</tr>
	</thead>
	<tbody>
	<? 
		foreach( $data['wykreslono'] as $zmiana ) { 
			
			// $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
			// $href = isset( $zmiana['krs_osoba_id'] ) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;
			
	?>
		<tr>
			<td><b><?= $zmiana['kod'] ?></b> <?= $zmiana['nazwa'] ?></td>			
		</tr>
	<? } ?>
	</tbody>
</table>    
<?		
	}
?>

<?
	if( isset($data['wpisano']) && !empty($data['wpisano']) ) {
?>
<p class="label label-success">Dodano</p>
<table class="table table-striped table-hover ">
	<thead>
		<tr>
			<th>Dokument</th>
			<th>Od</th>
			<th>Do</th>
			<th>Data złożenia</th>
		</tr>
	</thead>
	<tbody>
	<? 
		foreach( $data['wpisano'] as $zmiana ) { 
			
			// $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
			// $href = isset( $zmiana['krs_osoba_id'] ) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;
			
	?>
		<tr>
			<td><?= @$zmiana['dokument'] ?></td>			
			<td><?= @$this->Czas->dataSlownie($zmiana['okres_od']) ?></td>			
			<td><?= @$this->Czas->dataSlownie($zmiana['okres_do']) ?></td>			
			<td><?= @$this->Czas->dataSlownie($zmiana['data_zlozenia']) ?></td>			
		</tr>
	<? } ?>
	</tbody>
</table>    
<?		
	}
?>