<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
?>

<div class="objectsPage">
    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
        <div class="searcher-app">
            <div class="container">
                <?= $this->element('Dane.DataBrowser/browser-searcher', array(
                    'size' => 'md',
                )); ?>
            </div>
        </div>

        <div class="container">
            <div class="dataBrowserContent">
                <div class="col-xs-12 col-sm-4 col-md-1-5 nopadding dataAggsContainer">
                    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
                        <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
                    <div class="dataWrap">
                        <div class="appBanner bottom-border">
                            <h1 class="appTitle">Pomoc</h1>

                            <p class="appSubtitle">Centrum pomocy portalu mojePaństwo</p>
                        </div>
                        <div class="content">
                            <div class="block col-xs-12">3 posty z WP</div>
                            <div class="block col-xs-12">3 filmy</div>
                            <div id="blad" class="block col-xs-12 reportBug">
                                <header>Zgłoś błąd</header>
                                <section>
                                    <p>Jeśli wystąpił jakiś błąd w naszym serwisie, posiadamy błędne lub nieaktualne
                                        dane, bądź chcą Państwo
                                        zgłosić nową funkcjonalność - poinformujcie
                                        Nas o tym.</p>

                                    <p> Jeśli zgłaszacie Państwo błąd prosimy o uwzględnienie jak największej ilości
                                        informacji: dokładny
                                        opis błędu, miejscem w którym występuje - najlepiej poparty adresem www,
                                        przeglądarką (rodzaj i jej
                                        wersją) oraz system operacyjnym, na którym błąd występuje. Dzięki czemu będziemy
                                        w stanie łatwiej
                                        odtworzyć błąd w celu diagnozy i naprawienia go.</p>

                                    <?php echo $this->Html->link('<span class="fa fa-github"></span>Powiadom bezpośrednio w serwisie GitHub', 'https://github.com/epforgpl/_mojePanstwo-Portal/issues/new', array(
                                        'class' => 'btn btn-social btn-github sliceBtn',
                                        'target' => '_blank',
                                        'escape' => false
                                    )); ?>
                                </section>
                                <section>
                                    <p>Jeśli znajdują się u nas jakies błędy krytyczne bądź błędy bezpieczeństwa -
                                        prosimy wtedy o
                                        zgłoszenia droga mailową, aby nie upubliczniać informacji o wykrytej
                                        dziurze/błędzie.</p>

                                    <div class="input-group sliceBtn">
                                        <span class="input-group-btn">
                                            <a class="btn btn-default glyphicon glyphicon-envelope" type="button"
                                               href="mailto:security@mojepanstwo.pl"></a>
                                        </span>
                                        <input type="text" class="form-control" value="security@mojepanstwo.pl"
                                               readonly>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
