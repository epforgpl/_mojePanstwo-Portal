<?php $this->Combinator->add_libs('css', $this->Less->css('radny_details', array('plugin' => 'PrzejrzystyKrakow'))) ?>

<? $detail = $radny->data; ?>

<div class="krakowRadnyDetail">
    <div class="row col-xs-12 col-md-7">
        <table class="table table-condensed">
            <?php if (true || isset($detail['rok_urodzenia'])) { ?>
                <tr>
                    <td>Data urodzenia</td>
                    <td><?= $detail['rok_urodzenia'] ?>(potrzeba pełna date)</td>
                </tr>
            <? } ?>
            <?php if (true) { ?>
                <tr>
                    <td>Miejsce urodzenia</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? } ?>
            <?php if (true) { ?>
                <tr>
                    <td>Miejsce pracy</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? } ?>
            <?php if (true) { ?>
                <tr>
                    <td>Adres email</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? } ?>
            <?php if (true) { ?>
                <tr>
                    <td>Telefon</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? } ?>
            <?php if (isset($detail['radni_gmin.data_wybrania'])) { ?>
                <tr>
                    <td>Data wybrania</td>
                    <td><?= $detail['radni_gmin.data_wybrania'] ?></td>
                </tr>
            <? } ?>
            <?php if (isset($detail['liczba_glosow'])) { ?>
                <tr>
                    <td>Liczba otrzymanych głosów</td>
                    <td><?= $detail['liczba_glosow'] ?><?php if (isset($detail['procent_glosow_w_okregu'])) {
                            echo ' (' . $detail['procent_glosow_w_okregu'] . '%)';
                        } ?></td>
                </tr>
            <? } ?>
            <?php if (isset($detail['liczba_interpelacji'])) { ?>
                <tr>
                    <td>Liczba interpelacji</td>
                    <td><?= $detail['liczba_interpelacji'] ?></td>
                </tr>
            <? } ?>
            <?php if (true || isset($detail['kadencja_id'])) { ?>
                <tr>
                    <td>Kadencje</td>
                    <td><?= implode(", ", $detail['kadencja_id']) ?>(zaznaczyć pogrubieniem info w którym był radnym)
                    </td>
                </tr>
            <? } ?>
        </table>
    </div>
    <div class="col-xs-12 col-md-5">
        <h3><?= $detail['okreg_nr'] ?></h3>
        (mapa okręgu)
    </div>
</div>