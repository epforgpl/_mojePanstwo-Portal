//sprawozdanie 2
<table class="formularz table table-bordered">
    <thead>
    <tr>
        <td class="grey col-xs-3">Numer zbiórki<br/>
            <small><i>(Należy wypełnić zgodnie z numerem nadanym przy zgłoszeniu)</i></small>
        </td>
        <td class="col-xs-3"><?= ($edit) ? '<input type="text" name="numer_zbiorki" />' : $value ?></td>
        <td class="grey col-xs-3">Data wpływu sprawozdania</td>
        <td class="grey col-xs-3">//datepicker</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="grey"><h3>Ministerstwo Administracji i Cyfryzacji</h3></td>
        <td class="grey" colspan="3"><h2>Sprawozdanie ze sposobu rozdysponowania zebranych
                ofiar</h2>
            <small><i>Formularz wypełnia się dla zbiórek już przeprowadzonych, jak również dla tych,
                    które trwają dłużej niż rok</i></small>
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
        <td class="grey"><b>Sprawozdanie końcowe</b></td>
        <td colspan="1">
            <div class="checkbox text-center">
                <label for="sprawozdanie_koncowe">&nbsp;</label>
                <input id="sprawozdanie_koncowe" type="checkbox" name="sprawozdanie_typ"
                       value="koncowe" <? if (!$edit) {
                    echo 'disabled="disabled"';
                } ?>/>
        </td>
        <td class="grey"><b>Sprawozdanie częściowe</b></td>
        <td colspan="1">
            <div class="checkbox text-center">
                <label for="sprawozdanie_czesciowe">&nbsp;</label>
                <input id="sprawozdanie_czesciowe" type="checkbox" name="sprawozdanie_typ"
                       value="czesciowe" <? if (!$edit) {
                    echo 'disabled="disabled"';
                } ?>/>
        </td>
    </tr>
    <tr>
        <td class="grey"><b>Okres sprawozdawczy</b></td>
        <td colspan="3">//datepicker od do</td>
    </tr>
    <tr>
        <td class="grey"><b>Nazwa zbiórki</b></td>
        <td colspan="3"><?= ($edit) ? '<input type="text" name="nazwa_zbiorki" />' : $value ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>I Dane dotyczące organizatora zbiórki publicznej</b></td>
    </tr>
    <tr>
        <td class="grey">1. Nazwa organizacji/komitetu społecznego</td>
        <td colspan="3"><?= ($edit) ? '<input type="text" name="organizacja_nazwa" />' : $value ?></td>
    </tr>
    <tr>
        <td class="grey">2. Siedziba</td>
        <td colspan="3"><?= ($edit) ? '<input type="text" name="organizacja_miejscowosc" placeholder="Miejscowość" />' : $value ?></td>
    </tr>
    <tr>
        <td class="grey">3. Dane do kontaktu</td>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_kraj" placeholder="Kraj" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_miejscowosc" placeholder="Miejscowość" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_ulica" placeholder="Ulica" />' : $value ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_nr_domu" placeholder="Nr domu" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_nr_lokalu" placeholder="Nr lokalu" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_kod_pocztowy" placeholder="Kod pocztowy" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_nr_telefonu" placeholder="Nr telefonu" />' : $value ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input type="text" name="organizacja_kontakt_nr_faxu" placeholder="Nr faksu (pole nieobowiązkowe)" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="email" name="organizacja_kontakt_email" placeholder="e-mail (pole nieobowiązkowe)" />' : $value ?></td>
        <td colspan="2"><?= ($edit) ? '<input type="text" name="organizacja_kontakt_email" placeholder="Strona www (pole nieobowiązkowe)" />' : $value ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4">4. Osoba uprawniona do reprezentowania organizatora zbiórki<br/>
            <small><i>(w przypadku reprezentowania na podstawie pełnomocnictwa należy dołączyć kopię
                    pełnomocnictwa, dane podane w pkt 4 nie będą zamieszczane na portalu zbiórek
                    publicznych)</i></small>
        </td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_imie" placeholder="Imię" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_nazwisko" placeholder="Nazwisko" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_pesel_dowod" placeholder="PESEL (przypadku braku seria i nr dokumentu potwierdzającego tożsamość)" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_kraj" placeholder="Kraj" />' : $value ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_miejscowosc" placeholder="Miejscowość" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_ulica" placeholder="Ulica" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_nr_domu" placeholder="Nr domu" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_nr_lokalu" placeholder="Nr lokalu" />' : $value ?></td>
    </tr>
    <tr>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_kod_pocztowy" placeholder="Kod pocztowy" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_nr_telefonu" placeholder="Nr telefonu (pole nieobowiązkowe)" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_nr_faxu" placeholder="Nr faksu (pole nieobowiązkowe)" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text" name="osoba_uprawniona_email" placeholder="e-mail (pole nieobowiązkowe)" />' : $value ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>II. Informacja o wysokości i rodzaju zebranych ofiar w okresie
                sprawozdawczym</b>
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">1. Suma zebranych środków pieniężnych</td>
        <td><?= ($edit) ? '<input class="currency-pln" type="number" min="0" step="any" name="zebrane_suma" />' : $value ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" rowspan="4">2. Cele, na które wydatkowano środki w okresie sprawozdawczym</td>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_cele_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_cele_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_cele_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_cele_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_cele_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_cele_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_cele_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_cele_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td class="grey" rowspan="4">3. Kategorie i ilość albo wartość zebranych darów rzeczowych</td>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_kategorie_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_kategorie_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_kategorie_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_kategorie_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_kategorie_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_kategorie_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td colspan="2"><?= ($edit) ? '<input type="text"name="zebrane_kategorie_nazwa[]" />' : $value ?></td>
        <td><?= ($edit) ? '<input type="text"name="zebrane_kategorie_wartosc[]" />' : $value ?></td>
    </tr>
    <tr>
        <td class="grey">4. Dodatkowe informacje o zebranych ofiarach<br/>
            <small><b>(pole nieobowiązkowe)</b></small>
        </td>
        <td colspan="3"><?= ($edit) ? '<textarea name="zebrane_informacje_dodatkowe"></textarea>' : $value ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>III. Informacja o wysokości i rodzaju poniesionych kosztów
                rozdysponowania ofiar w okresie sprawozdawczym, które zostały pokryte z zebranych ofiar</b>
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3"><b>1. Koszty organizacji zbiórki publicznej ogółem</b><br/>
            <small><i>(Koszty ogółem
                    muszą być sumą kosztów podanych w pkt 2-6)</i></small>
        </td>
        <td><?= ($edit) ? '<input class="currency-pln" type="number" min="0" step="any" name="koszty_suma" />' : $value ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">2. Koszty związane z organizacją rozdysponowania ofiar</td>
        <td><?= ($edit) ? '<input class="currency-pln" type="number" min="0" step="any" name="koszty_organizacja" />' : $value ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">3. Koszty kampanii informacyjnej lub reklamowej dotyczącej zbiórki</td>
        <td><?= ($edit) ? '<input class="currency-pln" type="number" min="0" step="any" name="koszty_kampanii_informacyjne" />' : $value ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">4. Koszty administracyjne</td>
        <td><?= ($edit) ? '<input class="currency-pln" type="number" min="0" step="any" name="koszty_administracyjne" />' : $value ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">5. Wynagrodzenia</td>
        <td><?= ($edit) ? '<input class="currency-pln" type="number" min="0" step="any" name="koszty_wynagrodzenia" />' : $value ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey" colspan="3">6. Pozostałe koszty ogółem</td>
        <td><?= ($edit) ? '<input class="currency-pln" type="number" min="0" step="any" name="koszty_pozostałe" />' : $value ?>
            , PLN
        </td>
    </tr>
    <tr>
        <td class="grey">7. Dodatkowe informacje o kosztach<br/>
            <small><i>(pole nieobowiązkowe)</i></small>
        </td>
        <td colspan="3"><?= ($edit) ? '<textarea name="koszty_informacje_dodatkowe"></textarea>' : $value ?></td>
    </tr>

    <tr>
        <td class="grey" colspan="4"><b>IV. Podpis osoby składającej/podpisy osób składających sprawozdanie</b></td>
    </tr>
    <tr>
        <td colspan="3"><?= ($edit) ? '<input type="text" name="podpis[]" placeholder="Imię i nazwisko" />' : $value ?></td>
        <td><? if ($edit) {
                echo '<small><i>Podpis</i></small>';
            } ?></td>
    </tr>
    <tr>
        <td colspan="3"><?= ($edit) ? '<input type="text" name="podpis[]" placeholder="Imię i nazwisko" />' : $value ?></td>
        <td><? if ($edit) {
                echo '<small><i>Podpis</i></small>';
            } ?></td>
    </tr>
    <tr>
        <td colspan="3"><?= ($edit) ? '<input type="text" name="podpis[]" placeholder="Imię i nazwisko" />' : $value ?></td>
        <td><? if ($edit) {
                echo '<small><i>Podpis</i></small>';
            } ?></td>
    </tr>
    </tbody>
</table>
