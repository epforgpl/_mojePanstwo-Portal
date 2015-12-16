<?php $this->Combinator->add_libs('css', $this->Less->css('report_bug')) ?>

<div id="reportBug" class="container">
    <div class="col-xs-12 col-md-8 col-md-offset-2">
        <div class="block">
            <header>Zgłoś błąd</header>
            <section>
                <p>Jeśli wystąpił jakiś błąd w naszym serwisie, posiadamy błędne lub nieaktualne dane, bądź chcą Państwo
                    zgłosić nową funkcjonalność - poinformujcie
                    Nas o tym.</p>

                <p> Jeśli zgłaszacie Państwo błąd prosimy o uwzględnienie jak największej ilości informacji: dokładny
                    opis błędu, miejscem w którym występuje - najlepiej poparty adresem www, przeglądarką (rodzaj i jej
                    wersją) oraz system operacyjnym, na którym błąd występuje. Dzięki czemu będziemy w stanie łatwiej
                    odtworzyć błąd w celu diagnozy i naprawienia go.</p>

                <?php echo $this->Html->link('<span class="fa fa-github"></span>Powiadom bezpośrednio w serwisie GitHub', 'https://github.com/epforgpl/_mojePanstwo-Portal/issues/new', array(
                    'class' => 'btn btn-social btn-github sliceBtn',
                    'target' => '_blank',
                    'escape' => false
                )); ?>
            </section>
            <section>
                <p>Jeśli znajdują się u nas jakies błędy krytyczne bądź błędy bezpieczeństwa - prosimy wtedy o
                    zgłoszenia droga mailową, aby nie upubliczniać informacji o wykrytej dziurze/błędzie.</p>

                <div class="input-group sliceBtn">
                    <span class="input-group-btn">
                        <a class="btn btn-default glyphicon glyphicon-envelope" type="button"
                           href="mailto:security@mojepanstwo.pl"></a>
                    </span>
                    <input type="text" class="form-control" value="security@mojepanstwo.pl" readonly>
                </div>
            </section>
        </div>
    </div>
</div>
