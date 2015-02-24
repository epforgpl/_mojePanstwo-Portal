<?php $this->Combinator->add_libs('css', $this->Less->css('inner-story', array('plugin' => 'Sejmometr'))); ?>
<?php $this->Combinator->add_libs('js', 'Sejmometr.inner-story-libs.js'); ?>
<?php $this->Combinator->add_libs('js', 'Sejmometr.inner-story.js'); ?>

<div id="storyLine">
    <div class="innerStory">
        <div class="far">
            <div class="clouds"></div>
        </div>
        <div class="medium">
            <div class="scene intro" data-scene="1">
                <div class="title">
                    <h3>Środki finansowe ogółem do rozliczenia</h3>

                    <h2>1 209 340
                        <small>PLN</small>
                    </h2>
                </div>
                <div class="infoIcon icon big biuro">Wydatki na biuro poselskie</div>
                <div class="scrollHint"></div>
            </div>
            <div class="scene sejm" data-scene="2">
                <div class="building"></div>
                <?php /*<div class="stat zarobki">
            <p>Uposażenie poselskie</p>
            <strong>9 304
                <small>PLN/miesiąc</small>
            </strong>

            <div class="icon posel">wydatki na posłów w 2013r.</div>
        </div> */
                ?>
                <div class="stat przejazd">
                    <p>Przejazdy posłów<br>samochodem własnym lub innym</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
            </div>
            <div class="scene biuro" data-scene="3">
                <div class="stat biura">
                    <p>Koszty wynajmu lokalu<br>na biura poselskie</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
                <div class="marker"></div>
            </div>
            <div class="scene szpital" data-scene="4">
                <div class="stat korespondencja">
                    <p>Korespondencja i ogłoszenia</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
                <div class="stat badania">
                    <p>Badanie lekarskie<br>i szkolenia pracowników</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
            </div>
            <div class="scene bank" data-scene="5">
                <div class="stat rachunki">
                    <p>Obsługa rachunkowo-księgowa<br>i bankowa biur poselskich</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
            </div>
            <div class="scene spotkanie" data-scene="6">
                <div class="name">
                    <p>Spotkanie z posłem</p>
                </div>
                <div class="men"></div>
                <div class="stat sala">
                    <p>Koszty wynajmowania sal<br>na spotkania z wyborcami</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
            </div>
            <div class="scene tlumaczenia" data-scene="7">
                <div class="stat ekspertyzy">
                    <p>Ekspertyzy, opinie, tłumaczenia</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
            </div>
            <div class="scene dom" data-scene="8">
                <div class="stat prywatny">
                    <p>Koszty wynajmu kwater prywatnych</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon posel">wydatki na posłów w 2013r.</div>
                </div>
                <div class="stat dom">
                    <p>Koszty najmu kwater<br>w Domu poselskim</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon posel">wydatki na posłów w 2013r.</div>
                </div>
            </div>
            <div class="scene droga" data-scene="9">
                <div class="stat taksowka">
                    <p>Przejazdy posłów teksówkami</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon biuro">wydatki na biura poselskie w 2013r.</div>
                </div>
                <div class="marker"></div>
            </div>
            <div class="scene lotnisko" data-scene="10">
                <div class="building"></div>
                <div class="stat loty">
                    <p>Podróże służbowe pracowników<br>biur poselskich</p>
                    <strong>209 304
                        <small>PLN</small>
                    </strong>

                    <div class="icon posel">wydatki na posłów w 2013r.</div>
                </div>
                <div class="marker"></div>
            </div>
            <div class="scene lot" data-scene="11"></div>
            <div class="scene stats" data-scene="12">
                <div class="screen">
                    <div class="container">
                        <div class="col-xs-12">
                            <div class="list">
                                <h3>Lista wszystkich wydatków</h3>

                                <div class="options col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-4">
                                    <a class="btn btn-info pull-left repeat" href="#">Jeszcze raz</a>
                                    <a class="btn btn-info pull-right more" href="http://mojepanstwo.pl" target="_self">Dowiedz
                                        się
                                        więcej</a>
                                </div>

                                <ul class="col-xs-12">
                                    <li class="col-xs-12 col-md-6">
                                        <div class="txt">Wynagrodzenie pracowników biura poselskiego</div>
                                        <div class="cost">1 230 576 PLN</div>
                                    </li>
                                    <li class="col-xs-12 col-md-6">
                                        <div class="txt">Wynagrodzenie pracowników biura poselskiego</div>
                                        <div class="cost">1 230 576 PLN</div>
                                    </li>
                                    <li class="col-xs-12 col-md-6">
                                        <div class="txt">Wynagrodzenie pracowników biura poselskiego</div>
                                        <div class="cost">1 230 576 PLN</div>
                                    </li>
                                    <li class="col-xs-12 col-md-6">
                                        <div class="txt">Wynagrodzenie pracowników biura poselskiego</div>
                                        <div class="cost">1 230 576 PLN</div>
                                    </li>
                                    <li class="col-xs-12 col-md-6">
                                        <div class="txt">Wynagrodzenie pracowników biura poselskiego</div>
                                        <div class="cost">1 230 576 PLN</div>
                                    </li>
                                    <li class="col-xs-12 col-md-6">
                                        <div class="txt">Wynagrodzenie pracowników biura poselskiego</div>
                                        <div class="cost">1 230 576 PLN</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="near">
            <div class="posel"></div>
            <div class="samochod"></div>
            <div class="taxi"></div>
            <div class="samolot"></div>
        </div>
    </div>
</div>