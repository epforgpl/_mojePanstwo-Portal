<? echo $this->Html->css($this->Less->css('survey/ankieta2')); ?>
<? $this->Combinator->add_libs('js', array('survey/ankieta2')); ?>

<div class="survey ankieta2 modal fade" id="surveyAnkieta2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/survey" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div class="text">
                        <p>Cześć,</p>

                        <p>Chciałabym Cię prosić o odpowiedź na 7 krótkich pytań, by pomóc nam rozwinąć portal
                            MojePanstwo.pl. Obiecuję że nie zajmie Ci to dłużej niż 3 minuty.</p>

                        <p>Każda uwaga jest dla nas niezwykle cenna. Dzięki nim możemy lepiej dostosować się do Twoich
                            oczekiwań.</p>

                        <p>Nie ma stron idealnych - prześlij mi swoje uwagi.</p>

                        <p>Ankieta jest anonimowa, jej wypełnienie zajmie Ci tylko kilka minut.</p>
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
                            <h4>Czy poleciłabyś/byś naszą stronę rodzinie/znajomym?</h4>

                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][polecilbysStrone]"
                                       id="polecilbysStroneAbsolutnieNie"
                                       value="absolutnie_nie">
                                <label for="polecilbysStroneAbsolutnieNie">Absolutnie nie</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][polecilbysStrone]"
                                       id="polecilbysStronePrawdopodobnieNie"
                                       value="prawdopodobnie_nie">
                                <label for="polecilbysStronePrawdopodobnieNie">Prawdopodobnie nie</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][polecilbysStrone]"
                                       id="polecilbysStroneNieWiem"
                                       value="nie_wiem">
                                <label for="polecilbysStroneNieWiem">Nie wiem</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][polecilbysStrone]"
                                       id="polecilbysStronePrawdopodobnieTak"
                                       value="prawdopodobnie_tak">
                                <label for="polecilbysStronePrawdopodobnieTak">Prawdopodobnie tak</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][polecilbysStrone]"
                                       id="polecilbysStroneZPewnosciaTak"
                                       value="z_pewnoscia_tak">
                                <label for="polecilbysStroneZPewnosciaTak">Z pewnością tak</label>
                            </div>
                        </div>
                        <div class="question">
                            <h4>Czy nawigacja na portalu jest dla Ciebie intuicyjna?</h4>

                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta2][nawigacjaIntuicyjna]"
                                       id="nawigacjaIntuicyjnaTak"
                                       value="tak">
                                <label for="nawigacjaIntuicyjnaTak">Tak</label>
                            </div>
                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta2][nawigacjaIntuicyjna]"
                                       id="nawigacjaIntuicyjnaNie"
                                       value="nie">
                                <label for="nawigacjaIntuicyjnaNie">Nie</label>
                            </div>
                        </div>
                        <div class="question">
                            <h4>Z portalu korzystasz najczęściej na:</h4>

                            <div class="radio radio-icon col-xs-4">
                                <input type="radio" name="survey[ankieta2][portalNa]" id="portalNaKomputer"
                                       value="komputer">
                                <label for="portalNaKomputer"><span
                                        class="icon laptop"></span>Komputerze/laptopie</label>
                            </div>
                            <div class="radio radio-icon col-xs-4">
                                <input type="radio" name="survey[ankieta2][portalNa]" id="portalNaTablet"
                                       value="tablet">
                                <label for="portalNaTablet"><span class="icon tablet"></span>Tablecie</label>
                            </div>
                            <div class="radio radio-icon col-xs-4">
                                <input type="radio" name="survey[ankieta2][portalNa]" id="portalNaTelefon"
                                       value="telefon">
                                <label for="portalNaTelefon"><span class="icon phone"></span>Telefonie</label>
                            </div>
                        </div>
                    </div>
                    <div class="page hide" data-pageno="2">
                        <div class="question">
                            <h4>Czy wprowadzane przez nas zmiany na portalu są dla Ciebie pomocne?</h4>

                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta2][zmianyPomocne]" id="zmianyPomocneTak"
                                       value="tak">
                                <label for="zmianyPomocneTak">tak</label>
                            </div>
                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta2][zmianyPomocne]" id="zmianyPomocneNie"
                                       value="nie">
                                <label for="zmianyPomocneNie">Nie</label>
                            </div>
                        </div>
                        <div class="question">
                            <h4>Czy korzystasz z filmików instruktażowych na naszym kanale Youtube i wpisów na blogu o
                                nowych funkcjonalnościach portalu?</h4>

                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta2][instrukcjeYT]" id="instrukcjeYTTak"
                                       value="tak">
                                <label for="instrukcjeYTTak">tak</label>
                            </div>
                            <div class="radio col-xs-3">
                                <input type="radio" name="survey[ankieta2][instrukcjeYT]" id="instrukcjeYTNie"
                                       value="nie">
                                <label for="instrukcjeYTNie">Nie</label>
                            </div>
                        </div>
                        <div class="question">
                            <h4>Jak oceniasz nasze wsparcie techniczne?</h4>

                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][wsparcieTechniczne]"
                                       id="wsparcieTechniczneBardzoNiezadowolony"
                                       value="bardzo_niezadowolony">
                                <label for="wsparcieTechniczneBardzoNiezadowolony">Bardzo niezadowolony/a</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][wsparcieTechniczne]"
                                       id="wsparcieTechniczneNiezadowolony"
                                       value="niezadowolony">
                                <label for="wsparcieTechniczneNiezadowolony">Niezadowolony/a</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][wsparcieTechniczne]"
                                       id="wsparcieTechniczneNieMamZdania"
                                       value="nie_mam_zdania">
                                <label for="wsparcieTechniczneNieMamZdania">Nie mam zdania</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][wsparcieTechniczne]"
                                       id="wsparcieTechniczneZadowolony"
                                       value="zadowolony">
                                <label for="wsparcieTechniczneZadowolony">Zadowolony/a</label>
                            </div>
                            <div class="radio radio-inline col-xs-2 col-xs-2Half">
                                <input type="radio" name="survey[ankieta2][wsparcieTechniczne]"
                                       id="wsparcieTechniczneBardzoZadowolony"
                                       value="bardzo_zadowolony">
                                <label for="wsparcieTechniczneBardzoZadowolony">Bardzo zadowolony/a</label>
                            </div>
                        </div>
                    </div>
                    <div class="page hide" data-pageno="3">
                        <div class="form-group question">
                            <label for="coMozemyZmienic">Co mogłoby sprawić, że nasza nowa usługa, byłaby dla Ciebie
                                bardziej interesująca?</label>
                            <textarea class="form-control" id="coMozemyZmienic" name="survey[ankieta2][coMozemyZmienic]"
                                      rows="14"></textarea>
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
                    <button type="button" class="btn nextBtn btn-primary pull-right">Dalej</button>
                    <button type="button" class="btn submitBtn btn-primary pull-right hide">Zakończ</button>
                </div>
            </form>
        </div>
    </div>
</div>
