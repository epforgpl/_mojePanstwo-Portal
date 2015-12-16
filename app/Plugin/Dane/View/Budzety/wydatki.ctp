<?
$nazwa = array(
    'wydatki' => "Wydatki budżetu wg. części",
    'dzialy' => "Wydatki budżetu wg. działów"
); ?>
<div class="container">
    <div class="row margin-top-20">
        <ul class="nav nav-tabs">
            <? foreach ($types as $typ) { ?>
                <li role="presentation" <? if ($typ == $type){ ?>class="active"<? } ?>><a
                        href="?type=<?= $typ ?>"><?= $nazwa[$typ] ?></a></li>
            <? } ?>
        </ul>
    </div>
</div>
<? echo $this->Element('dataobject/pageBegin'); ?>


<div class="row">
    <div class="col-md-12">
        <div class="block block-simple col-xs-12">
            <header>Wydatki budżetu:</header>
            <section class="aggs-init margin-sides-20">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">

                        <div class="col-xs-12 col-sm-11 row">
                            <? if ($type == 'wydatki') { ?>
                                <div><a href="csv">
                                        <button class="btn btn-md btn-primary btn-icon" style="width:auto;"><span
                                                class="icon glyphicon glyphicon-download"></span>Pobierz dane
                                        </button>
                                    </a></div>
                                <table class="table table-strict table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Część</th>
                                        <th>Dział</th>
                                        <th>Rozdział</th>
                                        <th>Treść</th>
                                        <th>Poz.</th>
                                        <th>Plan</th>
                                        <th>Dotacje i subwencje</th>
                                        <th>Świadczenia na rzecz osób fizycznych</th>
                                        <th>Wydatki bieżace jednostek budżetowych</th>
                                        <th>Wydatki majątkowe</th>
                                        <th>Wydatki na obsługę długu</th>
                                        <th>Środki własne UE</th>
                                        <th>Współfinansowanie UE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? $i = 0;
                                    foreach ($object->getLayers('wydatki') as $row) {
                                        ?>
                                        <tr <? if ($row['pl_budzety_wydatki']['czesc_str'] != '') { ?> class="info"<? } elseif ($row['pl_budzety_wydatki']['dzial_str'] != '') { ?> class="active"<? } ?>>
                                            <th scope="row"><?= $row['pl_budzety_wydatki']['czesc_str'] ?></th>
                                            <th scope="row"><?= $row['pl_budzety_wydatki']['dzial_str'] ?></th>
                                            <th scope="row"><?= $row['pl_budzety_wydatki']['rozdzial_str'] ?></th>
                                            <td><?= $row['pl_budzety_wydatki']['tresc'] ?></td>
                                            <td><?= $row['pl_budzety_wydatki']['pozycja'] ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['plan'] * 1000) ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['dotacje_i_subwencje'] * 1000) ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['swiadczenia_na_rzecz_osob_fizycznych'] * 1000) ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['wydatki_biezace_jednostek_budzetowych'] * 1000) ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['wydatki_majatkowe'] * 1000) ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['wydatki_na_obsluge_dlugu'] * 1000) ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['srodki_wlasne_ue'] * 1000) ?></td>
                                            <td><?= number_format_h($row['pl_budzety_wydatki']['wspolfinansowanie_ue'] * 1000) ?></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            <? } else { ?>
                                <table class="table table-strict table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Dział</th>
                                        <th>Rozdział</th>
                                        <th>Treść</th>
                                        <th>Plan</th>
                                        <th>Dotacje i subwencje</th>
                                        <th>Świadczenia na rzecz osób fizycznych</th>
                                        <th>Wydatki bieżace jednostek budżetowych</th>
                                        <th>Wydatki majątkowe</th>
                                        <th>Wydatki na obsługę długu</th>
                                        <th>Środki własne UE</th>
                                        <th>Współfinansowanie UE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? $i = 0;
                                    $dane = array();
                                    foreach ($object->getLayers('dzialy')['dzialy'] as $row) {
                                        $dane[$row['pl_budzety_wydatki']['dzial_str']] = $row;
                                        $dane[$row['pl_budzety_wydatki']['dzial_str']]['dane'] = array();
                                    }
                                    foreach ($object->getLayers('dzialy')['rozdzialy'] as $row) {
                                        $dane[$row['pl_budzety_wydatki_dzialy']['src']]['dane'][$row['pl_budzety_wydatki']['rozdzial_str']] = $row;
                                    }
                                    foreach ($dane as $k => $row) {
                                        ?>
                                        <tr class="info">
                                            <th scope="row"><?= $k ?></th>
                                            <th scope="row"></th>
                                            <td><?= @$row['pl_budzety_wydatki']['tresc'] ?></td>
                                            <td><?= number_format_h(@$row[0]['plan'] * 1000) ?></td>
                                            <td><?= number_format_h(@$row[0]['dotacje_i_subwencje'] * 1000) ?></td>
                                            <td><?= number_format_h(@$row[0]['swiadczenia_na_rzecz_osob_fizycznych'] * 1000) ?></td>
                                            <td><?= number_format_h(@$row[0]['wydatki_biezace_jednostek_budzetowych'] * 1000) ?></td>
                                            <td><?= number_format_h(@$row[0]['wydatki_majatkowe'] * 1000) ?></td>
                                            <td><?= number_format_h(@$row[0]['wydatki_na_obsluge_dlugu'] * 1000) ?></td>
                                            <td><?= number_format_h(@$row[0]['srodki_wlasne_ue'] * 1000) ?></td>
                                            <td><?= number_format_h(@$row[0]['wspolfinansowanie_ue'] * 1000) ?></td>
                                        </tr>
                                        <? foreach ($row['dane'] as $key => $val) { ?>
                                            <tr>
                                                <th scope="row"></th>
                                                <th scope="row"><?= $key ?></th>
                                                <td><?= $val['pl_budzety_wydatki']['tresc'] ?></td>
                                                <td><?= number_format_h($val[0]['plan'] * 1000) ?></td>
                                                <td><?= number_format_h($val[0]['dotacje_i_subwencje'] * 1000) ?></td>
                                                <td><?= number_format_h($val[0]['swiadczenia_na_rzecz_osob_fizycznych'] * 1000) ?></td>
                                                <td><?= number_format_h($val[0]['wydatki_biezace_jednostek_budzetowych'] * 1000) ?></td>
                                                <td><?= number_format_h($val[0]['wydatki_majatkowe'] * 1000) ?></td>
                                                <td><?= number_format_h($val[0]['wydatki_na_obsluge_dlugu'] * 1000) ?></td>
                                                <td><?= number_format_h($val[0]['srodki_wlasne_ue'] * 1000) ?></td>
                                                <td><?= number_format_h($val[0]['wspolfinansowanie_ue'] * 1000) ?></td>
                                            </tr>
                                        <? } ?>
                                    <? } ?>
                                    </tbody>
                                </table>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div class="row">

    <div class="block block-simple col-xs-12">

    </div>

</div>

<?= $this->Element('dataobject/pageEnd'); ?>
