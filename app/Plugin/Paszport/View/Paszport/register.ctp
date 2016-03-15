<?php

$this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport')));
$this->Combinator->add_libs('js', 'Paszport.paszport-register.js');

?>

<div class="objectsPage fullPageHeight">
    <div class="createAccount" id="modalPaszportLoginForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo __d('paszport', 'LC_PASZPORT_FOOTER_REGISTER'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $this->Form->create('User', array(
                        'id' => 'UserRegisterForm',
                        'url' => $this->Html->url(array(
                            'plugin' => 'paszport',
                            'controller' => 'paszport',
                            'action' => 'register',
                            'full_base' => true
                        ))
                    )); ?>

                    <div class="slide or col-xs-12">
                        <?php echo __d('paszport', 'LC_PASZPORT_MODAL_REGISTER_VIA_EMAIL') ?>
                    </div>

                    <div class="slide inputForm col-xs-12 hide">
                        <div class="control-group">
                            <label class="control-label" for="AccountType">
                                <?php echo __d('paszport', "LC_PASZPORT_ACCOUNT_TYPE"); ?>
                            </label>

                            <div class="controls" id="AccountType">
                                <div class="btn-group">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                        <?php echo $groups[key($groups)]; ?>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($groups as $k => $g) { ?>
                                            <li data-group="<?php echo $k ?>"><a href="#"><?php echo $g ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php echo $this->Form->hidden('User.group_id'); ?>

                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.email', array(
                            'class' => 'input-xlarge form-control',
                            'type' => 'email',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_EMAIL", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_EMAIL_REQUIRED", true),
                            'required' => 'required',
                            'data-validation-email-message' => __d('paszport', "LC_PASZPORT_NOT_A_VALID_EMAIL", true),
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>

                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.password', array(
                            'class' => 'input-xlarge form-control',
                            'type' => 'password',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_PASSWORD", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_NEW_PASSWORD_BLANK", true),
                            'required' => 'required',
                            'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                            'minlength' => '6',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>
                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.repassword', array(
                            'class' => 'input-xlarge form-control',
                            'label' => __d('paszport', 'LC_PASZPORT_CONFIRM_PASSWORD', true),
                            'autocomplete' => 'off',
                            'type' => 'password',
                            'data-validation-match-match' => 'data[User][password]',
                            'data-validation-match-message' => __d('paszport', "LC_PASZPORT_CONFIRM_PASSWORD_NOT_EQUAL", true),
                            'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                            'minlength' => '6',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>

                    <div class="slide inputForm groupType col-xs-12" rel="1">
                        <?php echo $this->Form->input('User.username', array(
                            'class' => 'input-xlarge form-control',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_USERNAME", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_USERNAME_BLANK", true),
                            'group-required' => 'required',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>
                    <div class="slide inputForm groupType col-xs-12 hidden" rel="2">
                        <?php echo $this->Form->input('User.username', array(
                            'class' => 'input-xlarge form-control',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_INSTITUTION_NAME", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_INSTITUTION_NAME_BLANK", true),
                            'group-required' => 'required',
                            'disabled' => 'disabled',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>

                    <div class="slide inputForm col-xs-12 hide">
                        <?php echo $this->Form->input('User.language_id', array(
                            'class' => 'selectpicker',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_LANGUAGE", true)
                        )); ?>
                    </div>

                    <div class="slide inputForm sendForm col-xs-12 padding-bottom-5">
                        <label>
                            <?php echo $this->Form->checkbox('is_ngo'); ?>
                            &nbsp; Działam w organizacji pozarządowej
                        </label>
                    </div>

                    <div class="slide inputForm col-xs-12 selectOrganization" style="display: none;">
                        <div class="form-group">
                            <label for="organizationNameInput">Organizacja</label>
                            <div class="suggesterBlockPisma">
                                <?= $this->element('Start.letters-searcher', array('q' => '', 'notRequired' => true, 'dataset' => 'krs_podmioty', 'placeholder' => 'Zacznij pisać aby znaleźć organizacje...')) ?>
                            </div>
                            <input type="hidden" name="krs_pozycje_nazwa" value=""/>
                            <input type="hidden" name="organization_object_id" value="0"/>
                        </div>

                        <div class="form-group margin-top-10">
                            <label for="organizationFirstNameInput">Imię</label>
                            <input type="text" name="organization_firstname" class="form-control" id="organizationFirstNameInput" placeholder="Imię">
                        </div>
                        <div class="form-group">
                            <label for="organizationLastNameInput">Nazwisko</label>
                            <input type="text" name="organization_lastname" class="form-control" id="organizationLastNameInput" placeholder="Nazwisko">
                        </div>
                        <div class="form-group">
                            <label for="organizationFunctionInput">Funkcja</label>
                            <input type="text" name="organization_function" class="form-control" id="organizationFunctionInput" placeholder="Funkcja">
                        </div>
                        <div class="form-group">
                            <label for="organizationPhoneNumberInput">Telefon</label>
                            <input type="text" name="organization_phone_number" class="form-control" id="organizationPhoneNumberInput" placeholder="Telefon">
                        </div>
                    </div>

                    <div class="slide inputForm sendForm col-xs-12">
                        <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_REGISTER_BUTTON'), array('class' => 'btn btn-primary sendForm')); ?>
                    </div>

                    <div class="slide or col-xs-12">
                        <?php echo __d('paszport', 'LC_PASZPORT_MODAL_REGISTER_VIA_FACEBOOK') ?>
                    </div>

                    <div class="slide logInVia col-xs-12">
                        <div class="content text-center">
                            <?php echo $this->Html->link('<span class="fa fa-facebook"></span>' . __d('paszport', 'LC_PASZPORT_LOGIN'), array(
                                'plugin' => 'paszport',
                                'controller' => 'users',
                                'action' => 'fblogin'
                            ), array('class' => 'btn btn-social btn-facebook btn-md', 'escape' => false)); ?>
                        </div>

                        <p class="help-block small margin-top-20">
                            Administratorem danych osobowych użytkowników  jest Fundacja ePaństwo zarejestrowana pod numerem KRS 0000359730 Regon: 142445947, NIP: 1231216692. Dane osobowe będą przetwarzane  w celu korzystania z usług świadczonych w ramach portalu mojepanstwo.pl oraz przesyłania informacji związanych z portalem. Użytkownikom przysługuje prawo dostępu do treści dotyczących ich danych i ich poprawiania. Podanie danych osobowych jest dobrowolne jednak niezbędne do korzystania z usług administratora.
                        </p>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <div class="modal-footer backgroundBlue">
                    <?php echo $this->Html->link(__d('paszport', 'LC_PASZPORT_MODAL_LOGIN_LOGIN', true), '/login', array('class' => 'register', 'autocomplete' => 'off', 'target' => '_self')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
