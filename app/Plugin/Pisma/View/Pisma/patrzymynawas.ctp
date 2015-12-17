<? // echo $this->Element('menu'); ?>


<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma-patrzymynawas.js') ?>

<?php switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
}; ?>
<?php echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock')); ?>

<div class="container">
    <div class="row">
        <div id="stepper" class="wizard clearfix">
            <div class="content clearfix">
                <div class="container start naszrzecznik">
                    <div class="col-xs-12">

                        <form class="letter form-horizontal" action="/moje-pisma" method="post">

                            <?php $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma'))) ?>
                            <?php $this->Combinator->add_libs('css', $this->Less->css('naszrzecznik', array('plugin' => 'Pisma'))) ?>
                            <?php $this->Combinator->add_libs('js', 'Pisma.pisma-button.js') ?>



                            <h1 class="text-center">Dołącz do apelu organizacji ws projektu ustawy o Trybunale Konstytucyjnym. Przeciwko ograniczaniu praw obywatelskich!</h1>

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="well">
                                        
					                                        <p>Grupa organizacji pozarządowych skierowała apel oraz opinię dotyczącą zagrożeń płynących z przyjęcia projektu ustawy o Trybunale Konstytucyjnym, którego pierwsze czytanie odbywa się 17 grudnia 2015 r. o 11.30. 
					Dołączam się do ich apelu!</p>
					
					<p>Trybunał Konstytucyjny jest instytucją, która ma stać na straży praw i
					wolności obywateli. Większość spraw, które rozpatruje, dotyczy
					codziennego życia Polaków – wysokości kwoty wolnej od podatku,
					rekrutacji do szkół i przedszkoli czy wolności zgromadzeń. Proponowane
					zmiany uniemożliwią Trybunałowi realizację tej ważnej roli, a co za tym
					idzie negatywnie wpłyną na sytuację wszystkich obywateli.</p>
					
					<p>Wejście w życie proponowanych w ustawie o Trybunale Konstytucyjnym zmian
					doprowadzi do paraliżu prac tej instytucji. Projekt zakłada, że w
					większości spraw Trybunał wydawać będzie wyroki w pełnym, minimum
					13-osobowym składzie. Trybunał rozpatruje co roku po kilkadziesiąt skarg
					konstytucyjnych, pytań prawnych oraz wniosków. Obecnie większość z nich
					rozpatrywana jest przez składy kilkuosobowe. Wymóg każdorazowego
					orzekania w pełnym składzie radykalnie przedłuży termin oczekiwania na
					rozstrzygnięcie. Ta zmiana będzie dotyczyła również wszystkich spraw,
					które są obecnie w toku.</p>
					
					<p>Kolejna zmiana zawarta w projekcie – wymóg stwierdzania
					niekonstytucyjności ustaw większością 2/3 głosów, zamiast zwykłą
					większością – doprowadzi do tego, że w najtrudniejszych,
					kontrowersyjnych sprawach, wyrok może w ogóle nie zapaść.</p>
					
					<p>Prace nad zmianą ustawy o Trybunale Konstytucyjnym prowadzone są w
					wielkim pośpiechu, który ogranicza możliwość zajęcia stanowiska przez
					obywateli, w tym ekspertów i organizacje społeczne. W sprawach
					fundamentalnych dla ustroju Rzeczypospolitej oraz praw obywateli
					niezbędny jest namysł i rozwaga, a nie wyścig z czasem i praca w nocy.</p>
					
					<p>Wątpliwości dotyczące proponowanych zmian szczegółowo omawia
					opinia prawna przygotowana przez Helsińską Fundację Praw Człowieka, znajdują się pod adresem
					<a href="https://panoptykon.org/sites/default/files/stanowiska/opinia_hfpc_16_12_2015.pdf" target="_blank">https://panoptykon.org/sites/default/files/stanowiska/opinia_hfpc_16_12_2015.pdf</a></p>
					
					<p>Apelujemy o powstrzymanie się od przyjmowania zaproponowanych w tej
					ustawie rozwiązań, a także o przeprowadzenie prac legislacyjnych z
					należytą rozwagą i w sposób umożliwiający poważną i merytoryczną dyskusję.</p>
					
					<p>Szanowni Posłowie i Posłanki, prosimy Was, nie dawajcie nam w prezencie
					na Święta ustawy, która uderza w prawa i wolności obywateli.</p>
					
					<p>Amnesty International<br/>
					Fundacja Batorego<br/>
					Fundacja ePaństwo<br/>
					Fundacja Panoptykon<br/>
					Helsińska Fundacja Praw Człowieka<br/>
					INPRIS – Instytut Prawa i Społeczeństwa<br/>
					Instytut Spraw Publicznych<br/>
					Sieć Obywatelska Watchdog Polska<br/>
					Stowarzyszenie Interwencji Prawnej
					</p>
                                        
                                    </div>

                                </div>
                            </div>

                            <h2 class="text-center">Znajdź swojego posła i wyślij pismo teraz!</h2>
                            <input type="hidden" name="szablon_id" value="83"/>

                            <fieldset>
                                <div class="form-group adresaci">
                                    <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>

                                    <div class="col-lg-9">
                                        <div class="suggesterBlockPisma">
                                            <?= $this->Element('Pisma.searcher', array('q' => '', 'dataset' => 'pisma_adresaci-aktywni_poslowie', 'placeholder' => 'Zacznij pisać aby znaleźć adresata...')) ?>
                                        </div>
                                        <span
                                            class="help-block">Na podstawie wybranego posła, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
                                    </div>

                                    <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
                                        echo ' value="' . $pismo['adresat_id'] . '"';
                                    } ?>>

                                </div>
                            </fieldset>

                            <fieldset class="final">
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-1 text-center">
                                        <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
                                                class="icon glyphicon glyphicon-pencil"></i>Stwórz pismo
                                        </button>
                                    </div>
                                </div>
                            </fieldset>

                            <h2 class="text-center">Nie wiesz kto jest Twoim posłem?</h2>

                            <p class="help-block text-center"><a href="#" id="localizeMe">Zlokalizuj się</a> lub wskaż
                                na mapie miejsce zamieszkania:</p>

                            <div class="row">
                                <div id="map"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div data-name="okregi" data-value='<?= json_encode($okregi) ?>'></div>

<div class="modal fade" id="wybierzPosla" tabindex="-1" role="dialog" aria-labelledby="wybierzPoslaLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
            </div>
        </div>
    </div>
</div>
