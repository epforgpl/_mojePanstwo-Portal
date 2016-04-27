<?php
/** @var object $data */
$edit = isset($edit) && $edit;
?>

<table class="formularz table table-bordered">
    <thead>
    <tr>
        <td class="grey col-xs-3">Numer zbiórki<br/>
            <small><i>(Należy wypełnić zgodnie z numerem nadanym przy zgłoszeniu widocznym
                    na portalu zbiórek)</i></small>
        </td>
        <td class="col-xs-3"><?= ($edit) ? '<input class="form-control" type="text" name="numer_zbiorki" value="' . @$data['numer_zbiorki'] . '" required="required" />' : (isset($data['numer_zbiorki'])) ? $data['numer_zbiorki'] : '&nbsp;' ?></td>
        <td class="grey col-xs-3">Data wpływu sprawozdania</td>
        <td class="grey col-xs-3"><?= ($edit) ? '<input class="datepicker form-control" name="data_wplywu" type="text" value="' . @$data['data_wplywu'] . '"required="required" />' : ((!empty($data['data_wplywu'])) ? $data['data_wplywu'] : '&nbsp;') ?></td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="grey"><h3>Ministerstwo Cyfryzacji</h3></td>
        <td class="grey" colspan="3"><h2>Sprawozdanie z przeprowadzonej zbiórki publicznej</h2>
            <small><i>Formularz wypełnia się dla zbiórek już przeprowadzonych, jak również dla tych,
                    które trwają dłużej niż rok za każdy 6-miesięczny okres</i></small>
        </td>
    </tr>
    <tr>
        <td class="semigrey" colspan="4">
            <p><i>&#10004; Formularz należy wypełnić w języku polskim, drukowanymi
                    literami;<br/>
                    &#10004; Wypełnić należy tylko białe pola;<br/>
                    &#10004; W polach wyboru należy wstawić znak X;</i>
            </p>
            <p>
                We wszystkich polach, w których nie będą wpisane odpowiednie informacje, należy
                wstawić
                pojedynczy znak myślnika (-)
            </p>
            <p><b>
                    Przewidywany czas wypełnienia formularza:<br/>
                    dla postaci elektronicznej – 10 min.,<br/>
                    dla postaci papierowej – 15 min.</b>
            </p>
        </td>
    </tr>
    <tr>
        <td class="grey"><b>Okres sprawozdawczy</b></td>
        <td colspan="3">
            <? if ($edit) { ?>
                <div class="datepicker range">
                    <label for="datepickerRangeOd">Od</label>
                    <input id="datepickerRangeOd" class="from form-control" name="okres_sprawozdawczy[]" type="text"
                           value="<?= @$data['okres_sprawozdawczy'][0] ?>"/>
                    <label for="datepickerRangeDo">do</label>
                    <input id="datepickerRangeDo" class="to form-control" name="okres_sprawozdawczy[]" type="text"
                           value="<?= @$data['okres_sprawozdawczy'][1] ?>"/>
                </div>
            <? } else {
                $dateOdDo = '';
                if (!empty($data['okres_sprawozdawczy'][0])) {
                    $dateOdDo .= 'Od ' . $data['okres_sprawozdawczy'][0] . ' ';
                }
                if (!empty($data['okres_sprawozdawczy'][1])) {
                    $dateOdDo .= 'do ' . @$data['okres_sprawozdawczy'][1];
                };
                echo $dateOdDo;
            } ?>

        </td>
    </tr>
    <tr>
        <td class="grey"><b>Nazwa zbiórki</b></td>
        <td colspan="3"><?= ($edit) ? '<input class="form-control" type="text" name="nazwa_zbiorki" value="' . @$data['nazwa_zbiorki'] . '" required="required" />' : ((!empty($data['nazwa_zbiorki'])) ? $data['nazwa_zbiorki'] : '&nbsp;') ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>I Dane dotyczące organizatora zbiórki publicznej</b></td>
    </tr>
    <tr>
        <td class="grey">1. Nazwa organizacji/komitetu społecznego</td>
        <td colspan="3"><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_nazwa" value="' . @$data['organizacja_nazwa'] . '" required="required" />' : ((!empty($data['organizacja_nazwa'])) ? $data['organizacja_nazwa'] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td class="grey">2. Siedziba</td>
        <td colspan="3"><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_miejscowosc" placeholder="Miejscowość" value="' . @$data['organizacja_miejscowosc'] . '" required="required" />' : ((!empty($data['organizacja_miejscowosc'])) ? $data['organizacja_miejscowosc'] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td class="grey">3. Dane do kontaktu</td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_kraj" placeholder="Kraj" value="' . @$data['organizacja_kontakt_kraj'] . '" required="required" />' : ((!empty($data['organizacja_kontakt_kraj'])) ? $data['organizacja_kontakt_kraj'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_miejscowosc" placeholder="Miejscowość" value="' . @$data['organizacja_kontakt_miejscowosc'] . '" required="required" />' : ((!empty($data['organizacja_kontakt_miejscowosc'])) ? $data['organizacja_kontakt_miejscowosc'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_ulica" placeholder="Ulica" value="' . @$data['organizacja_kontakt_ulica'] . '" required="required" />' : ((!empty($data['organizacja_kontakt_ulica'])) ? $data['organizacja_kontakt_ulica'] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_nr_domu" placeholder="Nr domu" value="' . @$data['organizacja_kontakt_nr_domu'] . '" required="required" />' : ((!empty($data['organizacja_kontakt_nr_domu'])) ? $data['organizacja_kontakt_nr_domu'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_nr_lokalu" placeholder="Nr lokalu" value="' . @$data['organizacja_kontakt_nr_lokalu'] . '" required="required" />' : ((!empty($data['organizacja_kontakt_nr_lokalu'])) ? $data['organizacja_kontakt_nr_lokalu'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_kod_pocztowy" placeholder="Kod pocztowy" value="' . @$data['organizacja_kontakt_kod_pocztowy'] . '" required="required" />' : ((!empty($data['organizacja_kontakt_kod_pocztowy'])) ? $data['organizacja_kontakt_kod_pocztowy'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_nr_telefonu" placeholder="Nr telefonu" value="' . @$data['organizacja_kontakt_nr_telefonu'] . '" required="required" />' : ((!empty($data['organizacja_kontakt_nr_telefonu'])) ? $data['organizacja_kontakt_nr_telefonu'] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_nr_faxu" placeholder="Nr faksu (pole nieobowiązkowe)" value="' . @$data['organizacja_kontakt_nr_faxu'] . '" />' : ((!empty($data['organizacja_kontakt_nr_faxu'])) ? $data['organizacja_kontakt_nr_faxu'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="email" name="organizacja_kontakt_email" placeholder="e-mail (pole nieobowiązkowe)" value="' . @$data['organizacja_kontakt_email'] . '" />' : ((!empty($data['organizacja_kontakt_email'])) ? $data['organizacja_kontakt_email'] : '&nbsp;') ?></td>
        <td colspan="2"><?= ($edit) ? '<input class="form-control" type="text" name="organizacja_kontakt_www" placeholder="Strona www (pole nieobowiązkowe)" value="' . @$data['organizacja_kontakt_www'] . '" />' : ((!empty($data['organizacja_kontakt_www'])) ? $data['organizacja_kontakt_www'] : '&nbsp;') ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4">4. Osoba uprawniona do reprezentowania organizatora zbiórki<br/>
            <small><i>(w przypadku reprezentowania na podstawie pełnomocnictwa należy dołączyć kopię
                    pełnomocnictwa, dane podane w pkt 4 nie będą zamieszczane na portalu zbiórek
                    publicznych)</i></small>
        </td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_imie" placeholder="Imię" value="' . @$data['osoba_uprawniona_imie'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_imie'])) ? $data['osoba_uprawniona_imie'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_nazwisko" placeholder="Nazwisko" value="' . @$data['osoba_uprawniona_nazwisko'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_nazwisko'])) ? $data['osoba_uprawniona_nazwisko'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_pesel_dowod" placeholder="PESEL (przypadku braku seria i nr dokumentu potwierdzającego tożsamość)" value="' . @$data['osoba_uprawniona_pesel_dowod'] . '" size="11" maxlength="11" required="required" />' : ((!empty($data['osoba_uprawniona_pesel_dowod'])) ? $data['osoba_uprawniona_pesel_dowod'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_kraj" placeholder="Kraj" value="' . @$data['osoba_uprawniona_kraj'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_kraj'])) ? $data['osoba_uprawniona_kraj'] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_miejscowosc" placeholder="Miejscowość" value="' . @$data['osoba_uprawniona_miejscowosc'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_miejscowosc'])) ? $data['osoba_uprawniona_miejscowosc'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_ulica" placeholder="Ulica" value="' . @$data['osoba_uprawniona_ulica'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_ulica'])) ? $data['osoba_uprawniona_ulica'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_nr_domu" placeholder="Nr domu" value="' . @$data['osoba_uprawniona_nr_domu'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_nr_domu'])) ? $data['osoba_uprawniona_nr_domu'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_nr_lokalu" placeholder="Nr lokalu" value="' . @$data['osoba_uprawniona_nr_lokalu'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_nr_lokalu'])) ? $data['osoba_uprawniona_nr_lokalu'] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_kod_pocztowy" placeholder="Kod pocztowy" value="' . @$data['osoba_uprawniona_kod_pocztowy'] . '" required="required" />' : ((!empty($data['osoba_uprawniona_kod_pocztowy'])) ? $data['osoba_uprawniona_kod_pocztowy'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_nr_telefonu" placeholder="Nr telefonu (pole nieobowiązkowe)" value="' . @$data['osoba_uprawniona_nr_telefonu'] . '" />' : ((!empty($data['osoba_uprawniona_nr_telefonu'])) ? $data['osoba_uprawniona_nr_telefonu'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="osoba_uprawniona_nr_faxu" placeholder="Nr faksu (pole nieobowiązkowe)" value="' . @$data['osoba_uprawniona_nr_faxu'] . '" />' : ((!empty($data['osoba_uprawniona_nr_faxu'])) ? $data['osoba_uprawniona_nr_faxu'] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="email" name="osoba_uprawniona_email" placeholder="e-mail (pole nieobowiązkowe)" value="' . @$data['osoba_uprawniona_email'] . '" />' : ((!empty($data['osoba_uprawniona_email'])) ? $data['osoba_uprawniona_email'] : '&nbsp;') ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>II. Informacja o wysokości i rodzaju zebranych ofiar w okresie
                sprawozdawczym</b>
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">1. Suma zebranych środków pieniężnych</td>
        <td><?= ($edit) ? '<input class="form-control currency-pln" type="number" min="0" step="any" name="zebrane_suma" value="' . @$data['zebrane_suma'] . '" required="required" />' : ((!empty($data['zebrane_suma'])) ? $data['zebrane_suma'] : '&nbsp;') ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" rowspan="4">2. Kategorie i ilość albo wartość zebranych darów rzeczowych</td>
        <td colspan="2"><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_nazwa[]" value="' . @$data['zebrane_kategorie_nazwa'][0] . '" />' : ((!empty($data['zebrane_kategorie_nazwa'][0])) ? $data['zebrane_kategorie_nazwa'][0] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_wartosc[]" value="' . @$data['zebrane_kategorie_wartosc'][0] . '" />' : ((!empty($data['zebrane_kategorie_wartosc'][0])) ? $data['zebrane_informacje_dodatkowe'][0] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_nazwa[]" value="' . @$data['zebrane_kategorie_nazwa'][1] . '" />' : ((!empty($data['zebrane_kategorie_nazwa'][1])) ? $data['zebrane_kategorie_nazwa'][1] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_wartosc[]" value="' . @$data['zebrane_kategorie_wartosc'][1] . '" />' : ((!empty($data['zebrane_kategorie_wartosc'][1])) ? $data['zebrane_informacje_dodatkowe'][1] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_nazwa[]" value="' . @$data['zebrane_kategorie_nazwa'][2] . '" />' : ((!empty($data['zebrane_kategorie_nazwa'][2])) ? $data['zebrane_kategorie_nazwa'][2] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_wartosc[]" value="' . @$data['zebrane_kategorie_wartosc'][2] . '" />' : ((!empty($data['zebrane_kategorie_wartosc'][2])) ? $data['zebrane_informacje_dodatkowe'][2] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_nazwa[]" value="' . @$data['zebrane_kategorie_nazwa'][3] . '" />' : ((!empty($data['zebrane_kategorie_nazwa'][3])) ? $data['zebrane_kategorie_nazwa'][3] : '&nbsp;') ?></td>
        <td><?= ($edit) ? '<input class="form-control" type="text" name="zebrane_kategorie_wartosc[]" value="' . @$data['zebrane_kategorie_wartosc'][3] . '" />' : ((!empty($data['zebrane_informacje_dodatkowe'][3])) ? $data['zebrane_informacje_dodatkowe'][3] : '&nbsp;') ?></td>
    </tr>
    <tr>
        <td class="grey">3. Dodatkowe informacje o zebranych ofiarach<br/>
            <small><i>(pole nieobowiązkowe)</i></small>
        </td>
        <td colspan="3"><?= ($edit) ? '<textarea class="form-control" name="zebrane_informacje_dodatkowe">' . @$data['zebrane_informacje_dodatkowe'] . '</textarea>' : ((!empty($data['zebrane_informacje_dodatkowe'])) ? $data['zebrane_informacje_dodatkowe'] : '&nbsp;') ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>III. Informacja o wysokości i rodzaju poniesionych kosztów
                organizacji zbiórki publicznej w okresie sprawozdawczym, które zostały pokryte z zebranych ofiar</b>
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">1. Koszty organizacji zbiórki publicznej ogółem<br/>
            <small><i>(Koszty ogółem
                    muszą być sumą kosztów podanych w pkt 2-6)</i></small>
        </td>
        <td><?= ($edit) ? '<input class="form-control currency-pln" type="number" min="0" step="any" name="koszty_suma" value="' . @$data['koszty_suma'] . '" required="required" />' : ((!empty($data['koszty_suma'])) ? $data['koszty_suma'] : '&nbsp;') ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">2. Koszty związane z organizacją zbiórki: koszty skarbon,
            identyfikatorów,
            wykorzystanie sprzętu itp.
        </td>
        <td><?= ($edit) ? '<input class="form-control currency-pln" type="number" min="0" step="any" name="koszty_organizacja" value="' . @$data['koszty_organizacja'] . '" required="required" />' : ((!empty($data['koszty_organizacja'])) ? $data['koszty_organizacja'] : '&nbsp;') ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">3. Koszty kampanii informacyjnej lub reklamowej związanej z
            przeprowadzeniem
            zbiórki
        </td>
        <td><?= ($edit) ? '<input class="form-control currency-pln" type="number" min="0" step="any" name="koszty_kampanii_informacyjne" value="' . @$data['koszty_kampanii_informacyjne'] . '" required="required" />' : ((!empty($data['koszty_kampanii_informacyjne'])) ? $data['koszty_kampanii_informacyjne'] : '&nbsp;') ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">4. Koszty administracyjne</td>
        <td><?= ($edit) ? '<input class="form-control currency-pln" type="number" min="0" step="any" name="koszty_administracyjne" value="' . @$data['koszty_administracyjne'] . '" required="required" />' : ((!empty($data['koszty_administracyjne'])) ? $data['koszty_administracyjne'] : '&nbsp;') ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">5. Wynagrodzenia</td>
        <td><?= ($edit) ? '<input class="form-control currency-pln" type="number" min="0" step="any" name="koszty_wynagrodzenia" value="' . @$data['koszty_wynagrodzenia'] . '" required="required" />' : ((!empty($data['koszty_wynagrodzenia'])) ? $data['koszty_wynagrodzenia'] : '&nbsp;') ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">6. Pozostałe koszty ogółem</td>
        <td><?= ($edit) ? '<input class="form-control currency-pln" type="number" min="0" step="any" name="koszty_pozostałe" value="' . @$data['koszty_pozostałe'] . '" required="required" />' : ((!empty($data['koszty_pozostałe'])) ? $data['koszty_pozostałe'] : '&nbsp;') ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey">7. Dodatkowe informacje o kosztach<br/>
            <small><i>(pole nieobowiązkowe)</i></small>
        </td>
        <td colspan="3"><?= ($edit) ? '<textarea class="form-control" name="koszty_informacje_dodatkowe">' . @$data['koszty_informacje_dodatkowe'] . '</textarea>' : ((!empty($data['koszty_informacje_dodatkowe'])) ? $data['koszty_informacje_dodatkowe'] : '&nbsp;') ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>IV. Podpis osoby składającej/podpisy osób składających
                sprawozdanie</b>
        </td>
    </tr>
    <tr>
        <td colspan="3"><?= ($edit) ? '<input class="form-control" type="text" name="podpis[]" placeholder="Imię i nazwisko" value="' . @$data['podpis'][0] . '" />' : ((!empty($data['podpis'][0])) ? $data['podpis'][0] : '&nbsp;') ?></td>
        <td><? if ($edit) {
                echo '<small><i>Podpis</i></small>';
            } ?></td>
    </tr>
    <tr>
        <td colspan="3"><?= ($edit) ? '<input class="form-control" type="text" name="podpis[]" placeholder="Imię i nazwisko" value="' . @$data['podpis'][1] . '" />' : ((!empty($data['podpis'][1])) ? $data['podpis'][1] : '&nbsp;') ?></td>
        <td><? if ($edit) {
                echo '<small><i>Podpis</i></small>';
            } ?></td>
    </tr>
    <tr>
        <td colspan="3"><?= ($edit) ? '<input class="form-control" type="text" name="podpis[]" placeholder="Imię i nazwisko" value="' . @$data['podpis'][2] . '" />' : ((!empty($data['podpis'][2])) ? $data['podpis'][2] : '&nbsp;') ?></td>
        <td><? if ($edit) {
                echo '<small><i>Podpis</i></small>';
            } ?>
        </td>
    </tr>
    </tbody>
</table>
