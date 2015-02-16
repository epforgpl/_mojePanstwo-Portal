<table class="table table-striped table-hover ">
	<thead>
		<tr>
			<th>Część</th>
			<th>Nazwa</th>
			<th>Liczba ofert</th>
			<th>Wykonawca</th>
			<th>Cena</th>
			<th>Najniższa oferta</th>
			<th>Najwyższa oferta</th>
			<th>Wartość</th>
			<th>Odrzucone oferty</th>
		</tr>
	</thead>
	<tbody>
	<? foreach( $details['czesci-wykonawcy'] as $item ) { ?>
		<tr>
			<td>#<?= $item['numer'] ?></td>
			<td><?= $item['nazwa'] ?></td>
			<td><?= $item['liczba_ofert'] ?></td>
			<td><?= $item['wykonawcy'][0]['nazwa'] ?> (<?= $item['wykonawcy'][0]['miejscowosc'] ?>)</td>
			<td><?= $item['cena'] ?></td>
			<td><?= $item['cena_min'] ?></td>
			<td><?= $item['cena_max'] ?></td>
			<td><?= $item['wartosc'] ?></td>
			<td><?= $item['liczba_odrzuconych_ofert'] ?></td>
		</tr>
	<? } ?>
	</tbody>
</table>