<?php $this->Combinator->add_libs('css', $this->Less->css('powiadomienia', array('plugin' => 'Powiadomienia'))); ?>
<?php $this->Combinator->add_libs('js', 'Powiadomienia.powiadomienia') ?>

<div id="powiadomienia" class="fullPageHeight"
     style="background-image: url('/Powiadomienia/img/header_powiadomienia.png')">
    <div class="header">
        <div class="holder container">
            <h1 class="col-xs-12">Powiadomienia</h1>
        </div>
        <div class="menu">
            <div class="container">
                <ul>
                    <li>
                        <a href="#" target="_self">Moje powiadomienia</a>
                    </li>
                    <li>
                        <a href="#" target="_self">Obserwuję</a>
                    </li>
                    <li class="active">
                        <a href="#" target="_self">Jak to działa?</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="handler container">
            <div class="col-xs-12">
                <div class="header">
                    <h2>Jak to działa?</h2>

                    <p>Na portalu mojePaństwo możesz otrzymywać powiadomienia o nowych
                        aktywnościach urzędów publicznych, firm oraz wiele innych.<br>
                        Oto przykłady danych, które możesz obserwować:
                    </p>
                </div>
                <div class="list">
                    <?= $this->Element('Powiadomienia.box', array('icon' => 'sejmometr', 'title' => 'Instytucje publiczne', 'text' => '<p>Otrzymuj informacje o nowych aktach prawnych, zamówieniach publicznych i innych działaniach instytucji. Znajdź instytucję, którą chcesz obserwować w aplikacji <a href="/kto_tu_rzadzi" target="_self">Kto tu rządzi?</a></p>')) ?>
                    <?= $this->Element('Powiadomienia.box', array('icon' => 'krs', 'title' => 'Firmy i organizacje', 'text' => '<p>Otrzymuj informacje o zmianach w składach zarządów, rad nadzorczych, ogłoszeniach wymaganych przez prawo gospodarcze, zamówieniach publicznych i dotacjach otrzymywanych przez spółki i organizacje zarejestrowane w Krajowym Rejestrze Sądowym. Znajdź instytucję, którą chcesz obserwować w aplikacji <a href="/krs" target="_self">Krajowy Rejestr Sądowy</a></p>')) ?>
                    <?= $this->Element('Powiadomienia.box', array('icon' => 'prawo', 'title' => 'Prawo', 'text' => '<p>Otrzymuj informacje o nowelizacjach, aktach wykonawczych i innych wydawanych do ustaw. Znajdź ustawę, którą chcesz obserować w aplikacji <a href="/prawo" target="_self">Prawo</a></p>')) ?>
                </div>
            </div>
        </div>
    </div>
</div>