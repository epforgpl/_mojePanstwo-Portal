<?php $this->Combinator->add_libs('css', $this->Less->css('powiadomienia', array('plugin' => 'Powiadomienia'))); ?>
<?php $this->Combinator->add_libs('js', 'Powiadomienia.powiadomienia') ?>

<?= $this->Element('appheader', array('title' => 'Powiadomienia', 'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce', 'appMenu' => $appMenu, 'appMenuSelected' => $appMenuSelected, 'headerUrl' => 'powiadomienia.png')); ?>

<div id="powiadomienia" class="fullPageHeight">
    <div class="slice left start">
        <div class="container">
            <div class="handler col-xs-12 col-sm-10 col-md-6 col-lg-4">
                <h1>Jak to działa?</h1>

                <p>Na portalu mojePaństwo możesz otrzymywać powiadomienia o nowych aktywnościach urzędów publicznych,
                    firm oraz wiele innych.</p>

                <p>Poniżej przykłady danych, które mozesz obserować.</p>
            </div>
        </div>
    </div>
    <div id="rotate">
        <div class="slice left instytucje">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Instytucje publiczne</h2>

                    <p>Otrzymuj informacje o nowych aktach prawnych, zamówieniach publicznych i&nbsp;innych działaniach
                        instytucji. Znajdź instytucję, którą chcesz obserwować w aplikacji <b>Kto tu rządzi?</b></p>

                    <a href="/kto_tu_rzadzi" target="_self" class="btn btn-primary" alt="Przejdź do aplikacji">Przejdź
                        do
                        aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice right firmy">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Firmy i&nbsp;organizacje</h2>

                    <p>Otrzymuj informacje o zmianach w skłądach zarządów, rad nadzorczych, ogłoszeniach wymaganych
                        przez prawo gospodarcze, zamówieniach publicznych i&nbsp;dotacjach otrzymywanych przez spółki i&nbsp;organizacje
                        zarejestrowane w Krajowym Rejestrze Sądowym. Znajdź firmę, którą chcesz obserwować w aplikacji
                        <b>Krajowy Rejestr Sądowy</b>.</p>
                    <a href="/krs" target="_self" class="btn btn-primary" alt="Przejdź do aplikacji">Przejdź do
                        aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice left prawo">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Prawo</h2>

                    <p>Otrzymuj informacje o nowelizacjach, aktach wykonawczych i&nbsp;innych wydawanych do ustaw.
                        Znajdź
                        ustawę, którą chcesz obserować w aplikacji <b>Prawo</b>.</p>
                    <a href="/prawo" target="_self" class="btn btn-primary" alt="Przejdź do aplikacji">Przejdź do
                        aplikacji</a>
                </div>
            </div>
        </div>
    </div>
</div>