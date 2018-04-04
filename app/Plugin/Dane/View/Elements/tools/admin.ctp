<?php /*
<?php $this->Combinator->add_libs('css', $this->Less->css('tool-uprawnienia', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-tools-admin'); ?>

<div class="banner uprawnienia block">
    <?php echo $this->Html->image('Dane.banners/zarzadzanie.svg', array('width' => '69', 'alt' => 'Poproś o uprawnienia', 'class' => 'pull-right')); ?>
    <p><?= isset($label) ? $label : '<strong>Zarządzaj profilem</strong> tej organizacji' ?></p>

    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uprawnieniaModal">Poproś o uprawnienia
    </button>
</div>

<div class="modal fade" id="uprawnieniaModal" tabindex="-1" role="dialog" aria-labelledby="uprawnieniaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"
                    id="uprawnieniaModalLabel">Zostań właścicielem tego profilu</h4>
            </div>
            <form class="form-horizontal" method="post">
                <input type="hidden" name="_action" value="moderate_request"/>
                <div class="modal-body">
                    <p>
                        Portal MojePaństwo.pl pomaga Twojej organizacji docierać do osób zainteresowanych Waszymi
                        działaniami, a także usprawnia pracę samej organizacji oferując specjalne narzędzia. <strong>Uzupełnisz
                            tutaj podstawowe dane kontaktowe, dodasz aktualne działania czy wpiszesz nr konta i
                            zaczniesz
                            zbierać środki na Waszą działalność.</strong> Aby uzyskać taki dostęp należy wypełnić
                        poniższy formularz
                        a skontaktujemy się w celu potwierdzenia profilu i uaktywnimy nowe funkcje.
                    </p>
                    <?php if ($this->Session->read('Auth.User.id')) { ?>
                        <div class="form-group">
                            <label for="inputName">Imię</label>
                            <input required="required" autocomplete="off" type="text" class="form-control"
                                   id="inputName"
                                   name="firstname">
                        </div>
                        <div class="form-group">
                            <label for="inputSurname">Nazwisko</label>
                            <input required="required" autocomplete="off" type="text" class="form-control"
                                   id="inputSurname"
                                   name="lastname">
                        </div>
                        <div class="form-group">
                            <label for="inputOrganization">Organizacja</label>
                            <input required="required" autocomplete="off" type="text" class="form-control"
                                   id="inputOrganization"
                                   name="organization">
                        </div>
                        <div class="form-group">
                            <label for="inputPosition">Funkcja</label>
                            <input required="required" autocomplete="off" type="text" class="form-control"
                                   id="inputPosition" name="position">
                        </div>

                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input required="required" autocomplete="off" type="email" class="form-control"
                                   id="inputEmail"
                                   name="email">
                        </div>
                        <div class="form-group">
                            <label for="inputPhone">Telefon</label>
                            <input required="required" autocomplete="off" type="phone" class="form-control"
                                   id="inputPhone"
                                   name="phone">
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer<?php if (!$this->Session->read('Auth.User.id')) {
                    echo ' backgroundBlue';
                } ?>">
                    <?php if ($this->Session->read('Auth.User.id')) { ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-icon text-center">
                                <span class="icon" data-icon="&#xe604;"></span>Wyślij
                            </button>
                        </div>
                    <?php } else { ?>
                        <a href="/login" class="_specialCaseLoginButton" data-dismiss="modal">Zaloguj się, aby
                            korzystać z funkcji zarządzania profilem
                        </a>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
*/ ?>