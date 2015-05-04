<?php $this->Combinator->add_libs('css', $this->Less->css('powiadomienia', array('plugin' => 'MojeDane'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('pk-powiadomienia', array('plugin' => 'MojeDane'))); ?>
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
        <div class="slice left danePubliczne">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Dane publiczne z Krakowa</h2>

                    <p></p>
                    <a href="/dane/gminy/903,krakow" target="_self" class="btn btn-primary" alt="Przejdź do aplikacji">Przejdź
                        do
                        aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice right radaMiasta">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Prace Rady Miasta</h2>

                    <p></p>
                    <a href="/dane/gminy/903,krakow/rada" target="_self" class="btn btn-primary"
                       alt="Przejdź do aplikacji">Przejdź do
                        aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice left legislacja">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Proces legislacyjny</h2>

                    <p></p>

                    <a href="/dane/gminy/903,krakow/druki" target="_self" class="btn btn-primary"
                       alt="Przejdź do aplikacji">Przejdź
                        do aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice right urzadMiasta">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Prace Urzędu Miasta Krakowa</h2>

                    <p></p>
                    <a href="/dane/gminy/903,krakow/urzad" target="_self" class="btn btn-primary"
                       alt="Przejdź do aplikacji">Przejdź do
                        aplikacji</a>
                </div>
            </div>
        </div>
        <div class="slice left dzielnice">
            <div class="container">
                <div class="handler mini col-xs-12 col-sm-10 col-md-6 col-lg-4">
                    <h2>Dzielnice Krakowa</h2>

                    <p></p>
                    <a href="/dane/gminy/903,krakow/dzielnice" target="_self" class="btn btn-primary"
                       alt="Przejdź do aplikacji">Przejdź do
                        aplikacji</a>
                </div>
            </div>
        </div>
    </div>
</div>