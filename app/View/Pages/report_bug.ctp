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

                <?php echo $this->Html->link('<i class="fa fa-envelope-o"></i>Wyślij zgłoszenie za pomocą formularza', 'https://gitreports.com/issue/epforgpl/_mojePanstwo-Portal', array(
                    'class' => 'btn btn-social btn-reddit',
                    'target' => '_blank',
                    'escape' => false
                )); ?>
                <?php echo $this->Html->link('<i class="fa fa-github"></i>Powiadom bezpośrednio w serwisie GitHub', 'https://github.com/epforgpl/_mojePanstwo-Portal/issues?state=open', array(
                    'class' => 'btn btn-social btn-github',
                    'target' => '_blank',
                    'escape' => false
                )); ?>
            </section>

        </div>
    </div>
</div>