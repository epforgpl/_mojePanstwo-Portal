<?php $this->Combinator->add_libs('css', $this->Less->css('powiadomienia', array('plugin' => 'MojeDane'))); ?>
<?php $this->Combinator->add_libs('js', 'MojeDane.powiadomienia') ?>

<?= $this->Element('appheader'); ?>

<div id="powiadomienia" class="fullPageHeight">
    <div class="slice left start">
        <div class="container">
            <div class="handler col-xs-12 col-sm-9 col-md-7 col-lg-6">
                <h1>Jak to działa?</h1>

                <p>Na portalu mojePaństwo możesz otrzymywać powiadomienia o nowych aktywnościach urzędów publicznych,
                    firm oraz wiele innych.</p>

                <p>Poniżej przykłady danych, które mozesz obserować.</p>

                <a href="#rotate" class="icon" data-icon="&#xe608;"></a>
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
                        do aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice right gminy">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Gminy</h2>

                    <p>Otrzymuj informacje o najnowszych aktach prawnych i zamówieniach publicznych dotyczących Twojej gminy.
                        <b>Moja Gmina</b>.</p>
                    <a href="/moja_gmina" target="_self" class="btn btn-primary" alt="Przejdź do aplikacji">Przejdź do
                        aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice left prawo">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Prawo</h2>

                    <p>Otrzymuj informacje o nowelizacjach, aktach wykonawczych i&nbsp;innych wydawanych do ustaw.
                        Znajdź ustawę, którą chcesz obserować w aplikacji <b>Prawo</b>.</p>
                    <a href="/prawo" target="_self" class="btn btn-primary" alt="Przejdź do aplikacji"
                       data-tutorial='{}'>Przejdź do
                        aplikacji</a>
                </div>
            </div>
        </div>
    </div>
</div>