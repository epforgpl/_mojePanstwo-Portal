<?
if (isset($data['zmiany_funkcji']) && !empty($data['zmiany_funkcji'])) {
    ?>
    <p class="label label-warning">Zmiany funkcji</p>
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>Osoba</th>
            <th>Funkcja przed</th>
            <th>Funkcja po</th>
        </tr>
        </thead>
        <tbody>
        <?
        foreach ($data['zmiany_funkcji'] as $zmiana) {

            $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
            $href = isset($zmiana['krs_osoba_id']) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;

            ?>
            <tr>
                <td><? if ($href) { ?><a href="<?= $href ?>"><? }
                        echo $title;
                        if ($href) { ?></a><? } ?></td>
                <td><?= $zmiana['funkcja']['przed'] ?></td>
                <td><?= $zmiana['funkcja']['po'] ?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
<?
}
?>

<?
if (isset($data['powolania']) && !empty($data['powolania'])) {
    ?>
    <p class="label label-success">Powołania</p>
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>Osoba</th>
            <th>Funkcja</th>
        </tr>
        </thead>
        <tbody>
        <?
        foreach ($data['powolania'] as $zmiana) {

            $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
            $href = isset($zmiana['krs_osoba_id']) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;

            ?>
            <tr>
                <td><? if ($href) { ?><a href="<?= $href ?>"><? }
                        echo $title;
                        if ($href) { ?></a><? } ?></td>
                <td><?= $zmiana['funkcja'] ?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
<?
}
?>

<?
if (isset($data['odwolania']) && !empty($data['odwolania'])) {
    ?>
    <p class="label label-danger">Odwołania</p>
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>Osoba</th>
            <th>Funkcja</th>
        </tr>
        </thead>
        <tbody>
        <?
        foreach ($data['odwolania'] as $zmiana) {

            $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
            $href = isset($zmiana['krs_osoba_id']) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;

            ?>
            <tr>
                <td><? if ($href) { ?><a href="<?= $href ?>"><? }
                        echo $title;
                        if ($href) { ?></a><? } ?></td>
                <td><?= $zmiana['funkcja'] ?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
<?
}
?>