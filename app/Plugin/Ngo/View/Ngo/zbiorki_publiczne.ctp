<?
echo $this->Html->css($this->Less->css('app'));
$this->Combinator->add_libs('css', $this->Less->css('zbiorki-publiczne', array('plugin' => 'Ngo')));

$this->Combinator->add_libs('js', 'Ngo.zbiorki-publiczne.js');

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">
        <div id="zbiorkiPubliczne" class="container">

            <div class="appBanner margin-top-20">
                <h1 class="appTitle">Organizacje pozarządowe</h1>
                <h2 class="appSubtitle">Rozlicz zbiorkę publiczną</h2>
                <p class="appSubtitle">Odpowiedz na kilka pytań, aby wygenerować formularz rozliczenia zbiórki</p>
            </div>
            <? if (isset($edit)) { ?>
                <form method="post" action="/ngo/zbiorki_publiczne/formularz">
                    <input type="hidden" name="sprawozdanie" value="<?= $data['sprawozdanie'] ?>"/>
                    <input type="hidden" name="skladajacy" value="<?= $data['skladajacy'] ?>"/>
                    <input type="hidden" name="zbiorka" value="<?= $data['zbiorka'] ?>"/>
                    <div class="sections col-xs-12">
                        <? if ($data['sprawozdanie'] == 'zakonczeniu') {
                            echo $this->Element('Ngo.ZbiorkiPubliczne/form1');
                        } else {
                            echo $this->Element('Ngo.ZbiorkiPubliczne/form2');
                        } ?>
                    </div>
                    <div class="sectionsBtn col-xs-12 text-center">
                        <a href="/ngo/zbiorki_publiczne" class="btn btn-link"
                           onclick="confirm('Czy na pewno?')">Anuluj</a>
                        <button type="submit" class="btn btn-primary viewForm">Podgląd formularza</button>
                    </div>
                </form>
            <? } else { ?>
                <form method="post">
                    <div class="sections col-xs-12">
                        <div
                            class="section panel text-center col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                            <h2>Co chcesz zrobić?</h2>
                            <div class="radio">
                                <input type="radio" id="sprawozdanie_po_zakonczeniu" name="sprawozdanie"
                                       value="zakonczeniu">
                                <label for="sprawozdanie_po_zakonczeniu">Stworzyć sprawozdanie po zakończeniu
                                    zbiórki</label>
                            </div>
                            <div class="radio">
                                <input type="radio" id="sprawozdanie_z_rozdysponowania" name="sprawozdanie"
                                       value="rozdysponowanie">
                                <label for="sprawozdanie_z_rozdysponowania">Stworzyć sprawozdanie z rozdysponowania
                                    środków</label>
                            </div>
                        </div>
                        <div
                            class="section panel hide text-center col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                            <h2>Kim jesteś?</h2>
                            <div class="radio">
                                <input type="radio" id="skladajacy_organizacja" name="skladajacy" value="organizacja">
                                <label for="skladajacy_organizacja">Organizacją wpisaną do Krajowego Rejestu
                                    Sądowego</label>
                            </div>
                            <div class="radio">
                                <input type="radio" id="skladajacy_komitet" name="skladajacy" value="komitet">
                                <label for="skladajacy_komitet">Komitetem społecznym</label>
                            </div>
                        </div>
                        <div
                            class="section hide panel text-center col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                            <h2>Ile trwała zbiórka?</h2>
                            <div class="radio">
                                <input type="radio" id="zbiorka_mniej_niz_12" name="zbiorka" value="mniej_niz_12">
                                <label for="zbiorka_mniej_niz_12">12 miesięcy lub mniej</label>
                            </div>
                            <div class="radio">
                                <input type="radio" id="zbiorka_wiecej_niz_12" name="zbiorka" value="wiecej_niz_12">
                                <label for="zbiorka_wiecej_niz_12">Więcej niż 12 miesięcy</label>
                            </div>
                        </div>
                    </div>
                    <div class="sectionsBtn col-xs-12 text-center">
                        <button type="submit" name="action" value="index" class="btn btn-primary btn-lg disabled">
                            Dalej
                        </button>
                    </div>
                </form>
            <? } ?>
        </div>
    </div>
</div>
