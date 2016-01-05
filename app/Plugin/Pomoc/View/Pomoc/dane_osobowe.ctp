<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
//$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
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

                            <p class="appSubtitle">Ochrona danych osobowych</p>
                        </div>
                        <div class="block col-xs-12">
                            <header>Podstawa Prawna portalu mojepanstwo.pl</header>
                            <section>
                                <p><strong>Sposób pozyskania danych.</strong> Portal mojepanstwo.pl wydawany jest przez
                                    Fundację ePaństwo zarejestrowaną pod numerem KRS 0000359730 i zawiera różne dane
                                    publiczne w tym te, które publikowane są na podstawie ustawy z dnia 20 sierpnia 1997
                                    r. o Krajowym Rejestrze Sądowym (Dz.U. z 2015 r. poz. 1142) w Krajowym Rejestrze
                                    Sądowym (dalej: KRS) oraz Monitorze Sądowym i Gospodarczym (dalej: Monitor). Zgodnie
                                    z art. 8 ust. 1 powołanej ustawy rejestr jest jawny, a istotą Monitora Sądowego i
                                    Gospodarczego jest umieszczenie go obiegu publicznym (art. 13). Fundacja pozyskuje
                                    dane z powszechnie dostępnych źródeł i publikuje ich kopie na wydawanych przez
                                    siebie portalu.</p>

                                <p><strong>Charakter pozyskanych danych.</strong> Fundacja pozyskuje i publikuje
                                    dane,które w zakresie w jakim dotyczą osób fizycznych stanowią dane osobowe,
                                    októrych mowa w art. 6 ust. 1 ustawy o ochronie danych osobowych. Są toimię,
                                    nazwisko, rok urodzenia, nr PESEL oraz powiązany z tymi danymipodmiot i pełniona w
                                    nim funkcja podlegający rejestracji w KRS lubogłoszeniu w Monitorze.</p>

                                <p><strong>Przetwarzanie i rozpowszechnianie danych.</strong> Przetwarzając dane
                                    Fundacjakorzysta z przesłanki wskazanej w art. 23 ust. pkt 5 ustawy o ochroniedanych
                                    osobowych tj. gdy jest to niezbędne dla wypełnienia prawnieusprawiedliwionych celów
                                    realizowanych przez administratorów danych alboodbiorców danych, a przetwarzanie nie
                                    narusza praw i wolności osoby, którejdane dotyczą. Zwrócić należy również uwagę, że
                                    prawo do rozpowszechnianiatego typu informacji, będących jednocześnie informacjami
                                    publicznymi zuwagi na ich charakter, gwarantowane jest art. 54 ust. 1
                                    KonstytucjiRzeczypospolitej Polskiej z dnia 2 kwietnia 1997 r. (Dz.U. 1997 nr 78
                                    poz.483 z późn. zm.) oraz art. 2a ust. 2 ustawy z dnia 6 września 2001 r. odostępie
                                    do informacji publicznej (Dz.U. 2014 poz. 782 z późn. zm.).</p>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
