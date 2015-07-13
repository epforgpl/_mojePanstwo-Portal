<?

$mode = isset($mode) ? $mode : 'full';

if (isset($data['wykreslono']) && !empty($data['wykreslono'])) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <p class="label label-danger">Wykreślono</p>

            <p class="margintop-xs"><?
                if ($mode == 'short')
                    echo $this->Text->truncate($data['wykreslono'], 150);
                else
                    echo $data['wykreslono'];
                ?></p>
        </div>
    </div>
<? } ?>

<?
if (isset($data['wpisano']) && !empty($data['wpisano'])) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <p class="label label-success">Wpisano</p>

            <p class="margintop-xs"><?
                if ($mode == 'short')
                    echo $this->Text->truncate($data['wpisano'], 150);
                else
                    echo $data['wpisano'];
                ?></p>
        </div>
    </div>
<? } ?>