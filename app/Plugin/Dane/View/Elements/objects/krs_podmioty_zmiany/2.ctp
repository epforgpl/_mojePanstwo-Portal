<?

$mode = isset($mode) ? $mode : 'full';

if (isset($data['wykreslono']) && !empty($data['wykreslono'])) {
    ?>
    <p class="label label-danger">Wykreślono</p>
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>Dział PKD</th>
        </tr>
        </thead>
        <tbody>
        <?
        $i = 0;
        foreach ($data['wykreslono'] as $zmiana) {

            // $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
            // $href = isset( $zmiana['krs_osoba_id'] ) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;

            ?>
            <tr>
                <td><strong><?= $zmiana['kod'] ?></strong> <?= $zmiana['nazwa'] ?></td>
            </tr>
            <?
            $i++;
            if (($mode == 'short') && ($i >= 3)) {
                break;
            }
        }
        ?>
        </tbody>
    </table>
    <?
    if (($mode == 'short') && ($diff = (count($data['wykreslono']) - $i))) {
        ?>
        <p class="text-center">oraz <?= pl_dopelniacz($diff, 'inny dział', 'inne działy', 'innych działów') ?></p>
    <?
    }
}
?>

<?
if (isset($data['wpisano']) && !empty($data['wpisano'])) {
    ?>
    <p class="label label-success">Wpisano</p>
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>Dział PKD</th>
        </tr>
        </thead>
        <tbody>
        <?
        $i = 0;
        foreach ($data['wpisano'] as $zmiana) {

            // $title = $zmiana['osoba']['imie'] . ' ' . $zmiana['osoba']['nazwisko'];
            // $href = isset( $zmiana['krs_osoba_id'] ) ? '/dane/krs_osoby/' . $zmiana['krs_osoba_id'] : false;

            ?>
            <tr>
                <td><strong><?= $zmiana['kod'] ?></strong> <?= $zmiana['nazwa'] ?></td>
            </tr>
            <?
            $i++;
            if (($mode == 'short') && ($i >= 3)) {
                break;
            }
        }
        ?>
        </tbody>
    </table>
    <?
    if (($mode == 'short') && ($diff = (count($data['wpisano']) - $i))) {
        ?>
        <p class="text-center">oraz <?= pl_dopelniacz($diff, 'inny dział', 'inne działy', 'innych działów') ?></p>
    <?
    }
}
?>
