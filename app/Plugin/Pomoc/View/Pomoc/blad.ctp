<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('blad', array('plugin' => 'Pomoc')));

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
	<div class="objectsPage">
	    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">

	        <div class="container">
	            <div class="dataBrowserContent">
	         
	                <div class="col-xs-12 col-sm-8">

                        <div class="appBanner">
                            <h1 class="appTitle">Pomoc</h1>

                            <p class="appSubtitle">Zgłoś błąd bądź sugestię</p>
                        </div>
                        <div class="content">
                            
                            <div class="dataWrap">
                            <div id="blad" name="zglos_blad" class="block col-xs-12 reportBug">
                                <section class="text">
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

                                    <p class="text-center">
                                        <?php echo $this->Html->link('<span class="fa fa-github"></span>Powiadom bezpośrednio w serwisie GitHub', 'https://github.com/epforgpl/_mojePanstwo-Portal/issues/new', array(
                                            'class' => 'btn btn-social btn-github sliceBtn',
                                            'target' => '_blank',
                                            'escape' => false
                                        )); ?>
                                    </p>
                                </section>
                                <section class="text">
                                    <p>Jeśli znajdują się u nas jakies błędy krytyczne bądź błędy bezpieczeństwa -
                                        prosimy wtedy o
                                        zgłoszenia drogą mailową, aby nie upubliczniać informacji o wykrytej
                                        dziurze/błędzie.</p>
                                    <div
                                        class="input-group emailBtn sliceBtn col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
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
</div>