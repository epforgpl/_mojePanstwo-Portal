<? echo $this->Html->css($this->Less->css('survey/ankieta1')); ?>
<? $this->Combinator->add_libs('js', array('survey/ankieta1')); ?>

<div class="survey ankieta1 modal fade" id="surveyAnkieta1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/survey" method="POST">
                <div class="modal-header">
                    <button type="submit" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div class="text">
                        <p>Cześć,</p>

                        <p>Chciałabym Cię prosić o odpowiedź na 9 krótkich pytań, by pomóc nam rozwinąć portal
                            MojePanstwo.pl. Obiecuję że nie zajmie Ci to dłużej niż 3 minuty.</p>

                        <p>Każda uwaga jest dla nas niezwykle cenna. Dzięki nim możemy lepiej dostosować się do Twoich
                            oczekiwań.</p>

                        <p>Ankieta jest anonimowa.</p>
                    </div>
                    <div class="text finisher">
                        <p>Dziękuję za poświęcony czas.<br/>
                            Twoje uwagi są dla nas bardzo ważne.</p>

                        <p>Pozdrawiam,<br/>
                            Asia z MojePanstwo.pl</p>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="page" data-pageno="1">
                        <div class="question">
                            <h4>Czy należysz do organizacji pozarządowej?</h4>

                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta1][areYouNgo]" id="areYouNgoTak" value="tak">
                                <label for="areYouNgoTak">Tak</label>
                            </div>
                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta1][areYouNgo]" id="areYouNgoNie" value="nie">
                                <label for="areYouNgoNie">Nie</label>
                            </div>
                        </div>
                        <div class="question">
                            <h4>Jak często korzystasz z portalu mojePaństwo.pl?</h4>

                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta1][beHereOften]" id="beHereOftenPierwszy"
                                       value="pierwszy_raz">
                                <label for="beHereOftenPierwszy">Jestem tu pierwszy raz</label>
                            </div>
                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta1][beHereOften]" id="beHereOftenRzadko"
                                       value="rzadko">
                                <label for="beHereOftenRzadko">Rzadko</label>
                            </div>
                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta1][beHereOften]" id="beHereOftenCzesto"
                                       value="czesto">
                                <label for="beHereOftenCzesto">Często</label>
                            </div>
                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta1][beHereOften]" id="beHereOftenCodziennie"
                                       value="codziennie">
                                <label for="beHereOftenCodziennie">Codziennie</label>
                            </div>
                        </div>
                        <div class="question">
                            <h4>Jak oceniasz wygląd i funkcjonalność strony?</h4>

                            <div class="radio col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta1][howPortalLook]" id="howPortalLookZle"
                                       value="zle">
                                <label for="howPortalLookZle">Jestem tu pierwszy raz</label>
                            </div>
                            <div class="radio col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta1][howPortalLook]" id="howPortalLookMoglo"
                                       value="moglo_byc_lepiej">
                                <label for="howPortalLookMoglo">Mogło być lepiej</label>
                            </div>
                            <div class="radio col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta1][howPortalLook]" id="howPortalLookSrednio"
                                       value="srednio">
                                <label for="howPortalLookSrednio">Średnio</label>
                            </div>
                            <div class="radio col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta1][howPortalLook]" id="howPortalLookDobrze"
                                       value="dobrze">
                                <label for="howPortalLookDobrze">Dobrze</label>
                            </div>
                            <div class="radio col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta1][howPortalLook]" id="howPortalLookBardzo"
                                       value="bardzo_dobrze">
                                <label for="howPortalLookBardzo">Bardzo dobrze</label>
                            </div>
                        </div>
                    </div>
                    <div class="page hide" data-pageno="2">
                        <div class="question">
                            <h4>Z jakich działów na naszym portalu ostatnio korzystałeś/aś?<br/>
                                <small>Możesz zaznaczyć kilka opcji.</small>
                            </h4>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastKRS"
                                       value="krs">
                                <label for="whatYouUseLastKRS">KRS</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastHandel"
                                       value="handel_zagraniczny">
                                <label for="whatYouUseLastHandel">Handel zagraniczny</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastNGO"
                                       value="ngo">
                                <label for="whatYouUseLastNGO">NGO</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]"
                                       id="whatYouUseLastOrzecznictwo" value="orzecznictwo">
                                <label for="whatYouUseLastOrzecznictwo">Orzecznictwo</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastPrawo"
                                       value="prawo">
                                <label for="whatYouUseLastPrawo">Prawo</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]"
                                       id="whatYouUseLastSejmometr"
                                       value="sejmometr">
                                <label for="whatYouUseLastSejmometr">Sejmometr</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastBDL"
                                       value="bdl">
                                <label for="whatYouUseLastBDL">Bank Danych Lokalnych</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastKody"
                                       value="kody_pocztowe">
                                <label for="whatYouUseLastKody">Kody pocztowe</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastRzadzi"
                                       value="kto_tu_rzadzi">
                                <label for="whatYouUseLastRzadzi">Kto tu rządzi?</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastDostep"
                                       value="dostep_do_informacji_publicznej">
                                <label for="whatYouUseLastDostep">Dostęp do Informacji Publicznej</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastGmina"
                                       value="moja_gmina">
                                <label for="whatYouUseLastGmina">Moja Gmina</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]"
                                       id="whatYouUseLastFinanse"
                                       value="finanse_gmin">
                                <label for="whatYouUseLastFinanse">Finanse Gmin</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]" id="whatYouUseLastMedia"
                                       value="media">
                                <label for="whatYouUseLastMedia">Finanse Gmin</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]"
                                       id="whatYouUseLastWydatki"
                                       value="wydatki_poslow">
                                <label for="whatYouUseLastWydatki">Wydatki posłów</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]"
                                       id="whatYouUseLastZamowienia"
                                       value="zamowienia_publiczne">
                                <label for="whatYouUseLastZamowienia">Zamówienia publiczne</label>
                            </div>
                            <div class="checkbox col-xs-6">
                                <input type="checkbox" name="survey[ankieta1][whatYouUseLast]"
                                       id="whatYouUseLastWyjazdy"
                                       value="wyjazdy_poslow">
                                <label for="whatYouUseLastWyjazdy">Wyjazdy posłów</label>
                            </div>
                        </div>
                    </div>
                    <div class="page hide" data-pageno="3">
                        <div class="form-group question">
                            <label for="whatWeNeedToAdd">Jakie informacje chciałbyś/chciałabyś znaleźć na stronie, a
                                których
                                obecnie brakuje (jest za mało)?</label>
                            <input type="text" class="form-control" id="whatWeNeedToAdd"
                                   name="survey[ankieta1][whatWeNeedToAdd]">
                        </div>
                        <div class="form-group question">
                            <label for="whatIsMostProp">Co uważasz za największe zalety strony?</label>
                            <input type="text" class="form-control" id="whatIsMostProp"
                                   name="survey[ankieta1][whatIsMostProp]">
                        </div>
                        <div class="form-group question">
                            <label for="whatIsMostCons">Co uważasz za największe wady strony? </label>
                            <input type="text" class="form-control" id="whatIsMostCons"
                                   name="survey[ankieta1][whatIsMostCons]">
                        </div>
                    </div>
                    <div class="page hide" data-pageno="4">
                        <div class="question">
                            <h4>Jak trafiłeś/aś na naszą stronę (skąd znasz adres)?</h4>

                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howYouFindUs]" id="howYouFindUsWyszukiwarka"
                                       value="wyszukiwarka">
                                <label for="howYouFindUsWyszukiwarka">Wyszukiwarka</label>
                            </div>
                            <div class="radio col-xs-8">
                                <input type="radio" name="survey[ankieta1][howYouFindUs]" id="howYouFindUsInnaStrona"
                                       value="inna_strona">
                                <label for="howYouFindUsInnaStrona">Inna strona internetowa</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howYouFindUs]" id="howYouFindUsSocial"
                                       value="social_media">
                                <label for="howYouFindUsSocial">Social Media</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howYouFindUs]" id="howYouFindUsZnajomi"
                                       value="znajomi">
                                <label for="howYouFindUsZnajomi">Znajomi</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howYouFindUs]" id="howYouFindUsInneZrodla"
                                       value="inne_zrodla">
                                <label for="howYouFindUsInneZrodla">Inne źródła</label>
                            </div>
                        </div>
                        <div class="question">
                            <h4>Jak jest Twój wiek?</h4>

                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howOldAreYou]" id="howOldAreYou18_25"
                                       value="18_25">
                                <label for="howOldAreYou18_25">18 - 25</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howOldAreYou]" id="howOldAreYou26_35"
                                       value="26_35">
                                <label for="howOldAreYou26_35">26 - 35</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howOldAreYou]" id="howOldAreYou36_45"
                                       value="36_45">
                                <label for="howOldAreYou36_45">36 - 45</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howOldAreYou]" id="howOldAreYou46_55"
                                       value="46_55">
                                <label for="howOldAreYou46_55">46 - 55</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howOldAreYou]" id="howOldAreYou56_66"
                                       value="56_66">
                                <label for="howOldAreYou56_66">56 - 66</label>
                            </div>
                            <div class="radio col-xs-4">
                                <input type="radio" name="survey[ankieta1][howOldAreYou]" id="howOldAreYou67"
                                       value="67">
                                <label for="howOldAreYou67">67+</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <ul class="progressBar pull-left">
                        <li class="active">&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                    </ul>
                    <button type="button" class="btn btn-primary pull-right">Dalej</button>
                    <button type="submit" class="btn submitBtn btn-primary pull-right hide">Zakończ</button>
                </div>
            </form>
        </div>
    </div>
</div>
