<?php

echo $this->Html->css($this->Less->css('modals/ngo1-modal'));
$this->Combinator->add_libs('js', 'modals/ngo1-modal');

?>

<div class="modal fade" id="ngo1Modal" tabindex="-1" role="dialog" aria-labelledby="ngo1ModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="well bs-component mp-form margin-top-0 margin-bottom-0">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ngo1ModalLabel">Czy należysz do organizacji pozarządowej?</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="radio">
                                <input name="is_ngo" value="0" checked="" type="radio" id="ngo1ModalNo">
                                <label for="ngo1ModalNo">Nie</label>
                            </div>
                            <div class="radio">
                                <input id="ngo1ModalYes" name="is_ngo" value="1" type="radio">
                                <label for="ngo1ModalYes">Tak</label>
                            </div>
                        </div>

                        <div class="selectOrganization" style="display: none;">
                            <h4>Wybierz swoją organizacje</h4>
                            <p class="help-block">Portal MojePaństwo.pl pomaga Twojej organizacji docierać do osób zainteresowanych Waszymi działaniami, a także usprawnia pracę samej organizacji oferując specjalne narzędzia dostępne tylko dla oficjalnych partnerów. Aby uzyskać taki status należy wypełnić poniższy formularz, następnie skontaktujemy się z Państwem w celu potwierdzenia profilu i uaktywnimy nowe funkcje.</p>
                            <div class="form-group">
                                <label for="organizationNameInput">Organizacja</label>
                                <div class="suggesterBlockPisma">
                                    <?= $this->element('Start.letters-searcher', array('q' => '', 'notRequired' => true, 'dataset' => 'krs_podmioty', 'placeholder' => 'Zacznij pisać aby znaleźć organizacje...')) ?>
                                </div>
                            </div>
                            <div class="form-group margin-top-10">
                                <label for="ngo1ModalFirstNameInput">Imię</label>
                                <input type="text" name="organization_firstname" class="form-control" id="ngo1ModalFirstNameInput" placeholder="Imię">
                            </div>
                            <div class="form-group">
                                <label for="ngo1ModalLastNameInput">Nazwisko</label>
                                <input type="text" name="organization_lastname" class="form-control" id="ngo1ModalLastNameInput" placeholder="Nazwisko">
                            </div>
                            <div class="form-group">
                                <label for="ngo1ModalFunctionInput">Funkcja</label>
                                <input type="text" name="organization_function" class="form-control" id="ngo1ModalFunctionInput" placeholder="Funkcja">
                            </div>
                            <div class="form-group">
                                <label for="ngo1ModalEmailInput">Adres email</label>
                                <input type="email" name="organization_email" class="form-control" id="ngo1ModalEmailInput" placeholder="Adres email">
                            </div>
                            <div class="form-group">
                                <label for="ngo1ModalPhoneNumberInput">Telefon</label>
                                <input type="text" name="organization_phone_number" class="form-control" id="ngo1ModalPhoneNumberInput" placeholder="Telefon">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Nie teraz</button>
                    <button type="button" id="ngo1ModalSubmit" class="btn btn-primary">Zapisz</button>
                </div>
            </div>
        </div>
    </div>
</div>
