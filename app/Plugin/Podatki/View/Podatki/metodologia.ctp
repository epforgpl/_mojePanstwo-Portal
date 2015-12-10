<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));
?>

<form id="podatki" method="post">
    <div class="container">
        <div class="appBanner">
            <h1 class="appTitle"><?= __d('podatki', 'LC_PODATKI_METODOLOGIA_HEADLINE'); ?></h1>

            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-justify">
                <p>
                    Obliczenia podatków i składek odzwierciedlają stan prawny z 2014 roku. Podatek VAT płacony przez
                    konsumentów jest obliczony na podstawie szacunków przeciętnej stawki podatku VAT dla gospodarstw
                    domowych o różnych poziomach dochodu przedstawionych w raporcie „VAT w wydatkach gospodarstw
                    domowych”,
                    przygotowanym przez Centrum Analiz Ekonomicznych CenEA. Dla obliczenia wysokości akcyzy przyjęto
                    uproszczenie, zgodnie z którym wysokość płaconej akcyzy stanowi połowę wysokości płaconego podatku
                    VAT.
                    Uproszczenie to wynika ze struktury dochodów budżetu państwa. Składki na ubezpieczenie społeczne
                    płacone
                    przez pracodawcę obejmują też składki na Fundusz Pracy i Fundusz Gwarantowanych Świadczeń
                    Pracowniczych.
                    Przyjęto stawkę wypadkową w wysokości 1,93%.
                </p>

                <p>Struktura wydatków państwa została opracowana na podstawie
                    danych za 2013 rok. W tym celu wykorzystano następujące źródła danych: sprawozdanie z wykonania
                    budżetu
                    państwa za 2013 rok; raport NIK „Analiza wykonania budżetu państwa i założeń polityki pieniężnej w
                    2013
                    roku”; informacje NIK o wynikach kontroli wykonania budżetu państwa w poszczególnych częściach
                    budżetowych oraz wyników kontroli planów finansowych poszczególnych agencji, funduszy, itp.;
                    informacje
                    o wykonaniu planów finansowych Funduszu Ubezpieczeń Społecznych oraz Funduszu Emerytalno-Rentowego
                    rolników; roczne sprawozdanie z wykonania planu finansowego NFZ; sprawozdanie z wykonania planu
                    wydatków
                    budżetowych jednostek samorządu terytorialnego oraz sprawozdanie z wykonania planów finansowych
                    samorządowych zakładów budżetowych (dane zbiorcze dla wszystkich JST); informacje otrzymane
                    bezpośrednio
                    z Ministerstwa Finansów w trybie dostępu do informacji publicznej.
                </p>

                <p>Wszystkie kwoty zaokrąglono do pełnych złotych.</p>
            </div>
        </div>
    </div>

    <div class="main_button_container text-center">
        <a class="btn btn-primary btn-lg btn-icon" href="/podatki"><i
                class="icon glyphicon glyphicon-credit-card"></i><span>Przejdź do obliczeń</span>
        </a>
    </div>

    <div class="footer text-center">
        <div class="customObject krakow903 col-xs-12" id="fundatorzy">
            <div class="part">
                <div class="logotypy">
                    <a title="EEA Grants" href="http://www.eeagrants.org/" target="_blank">
                        <img src="/img/partnerzy/eea_grants.png" class="image">
                    </a>
                    <a title="Fundacja im. Stefana Batorego" href="http://www.batory.org.pl/" target="_blank">
                        <img src="/img/partnerzy/fundacja_batorego.png" class="image">
                    </a>
                    <a title="Polska Fundacja Dzieci i Młodzieży" href="http://www.pcyf.org.pl/" target="_blank">
                        <img src="/img/partnerzy/polska_fundacja_dzieci_i_mlodziezy.png" class="image">
                    </a>
                    <a title="Fundacja Naukowa Instytut Badań Strukturalnych" href="http://www.ibs.org.pl/"
                       target="_blank">
                        <img src="/Podatki/img/logotyp_ibs.jpg" class="image">
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
