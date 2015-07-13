<div class="row">
    <div class="col-lg-12">

        <? // debug( $object->getData() ); ?>
        <? // debug( $dokument->getLayer('details') ); ?>

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
                <th>Wartość szacunkowa (bez VAT)</th>
                <th>Odrzucone oferty</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($details['czesci-wykonawcy'] as $item) { ?>
                <tr>
                    <td>#<?= $item['numer'] ?></td>
                    <td><?= $item['nazwa'] ?></td>
                    <td><?= $item['liczba_ofert'] ?></td>
                    <td><?= $item['wykonawcy'][0]['nazwa'] ?> (<?= $item['wykonawcy'][0]['miejscowosc'] ?>)</td>
                    <td><?= _currency($item['cena']) ?></td>
                    <td><?= _currency($item['cena_min']) ?></td>
                    <td><?= _currency($item['cena_max']) ?></td>
                    <td><?= _currency($item['wartosc']) ?></td>
                    <td><?= $item['liczba_odrzuconych_ofert'] ?></td>
                </tr>
            <? } ?>
            </tbody>
        </table>

        <p><a target="_blank"
              href="http://bzp1.portal.uzp.gov.pl/index.php?ogloszenie=show&pozycja=<?= $details['data']['numer'] ?>&rok=<?= $details['data']['data'] ?>">Źródło</a>
        </p>


    </div>
</div>