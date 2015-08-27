<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>

<div class="objectsPage fullPageHeight">
    <div class="forgotPassword" id="modalPaszportLoginForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <? if (isset($tokenSuccess) && $tokenSuccess) { ?>
                    <div class="modal-header">
                        <h4 class="modal-title"><?= __d('paszport', 'LC_PASZPORT_CHANGE_PASSWORD') ?></h4>
                    </div>
                    <? if (isset($newPasswordSuccess) && $newPasswordSuccess) { ?>
                        <div class="modal-body">
                            <p class="text-success"><?= __d('paszport', 'LC_PASZPORT_CHANGEPASSWORD_SAVED') ?></p>
                        </div>
                    <? } else { ?>
                        <form action="/forgot" id="UserForgotForm" method="post" accept-charset="utf-8">
                            <div class="modal-body">
                                <input type="hidden" name="token" value="<?= $token ?>"/>

                                <div class="slide inputForm col-xs-12">
                                    <?php echo $this->Form->input('User.password', array(
                                        'class' => 'input-xlarge form-control',
                                        'type' => 'password',
                                        'label' => 'Nowe hasło',
                                        'autocomplete' => 'off',
                                        'required' => 'required',
                                        'after' => '<span class="help-block"></span>'
                                    )); ?>
                                </div>
                            </div>
                            <div class="modal-footer backgroundBlue">
                                <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_CHANGEPASSWORD_BUTTON'), array('class' => 'btn btn-link sendForm')); ?>
                            </div>
                        </form>
                    <? } ?>
                <? } else { ?>
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo __d('paszport', "LC_PASZPORT_PASSWORD_FORGOT_MOTTO") ?></h4>
                    </div>
                    <? if (isset($success) && $success) { ?>
                        <div class="modal-body">
                            <p class="text-success text-center"><?= __d('paszport', 'LC_PASZPORT_CHANGEPASSWORD_EMAIL_SENDED') ?></p>
                        </div>
                    <? } else { ?>
                        <form accept-charset="utf-8" method="post" id="UserForgotForm" action="/forgot">
                            <div class="modal-body">
                                <div class="slide inputForm textForm col-xs-12">
                                    <?php echo __d('paszport', "LC_PASZPORT_FORGOT_PASSWORD_EVANGELION"); ?><br/><br/>
                                </div>
                                <div class="slide inputForm col-xs-12">
                                    <?php echo $this->Form->input('User.email', array(
                                        'class' => 'input-xlarge form-control',
                                        'type' => 'email',
                                        'label' => __d('paszport', "LC_PASZPORT_FORGET_EMAIL", true),
                                        'autocomplete' => 'off',
                                        'data-validation-required-message' => __d('paszport', "LC_PASZPORT_EMAIL_REQUIRED", true),
                                        'required' => 'required',
                                        'data-validation-email-message' => __d('paszport', "LC_PASZPORT_NOT_A_VALID_EMAIL", true),
                                        'after' => '<span class="help-block"></span>'
                                    )); ?>
                                </div>
                            </div>
                            <div class="modal-footer backgroundBlue">
                                <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_FORGET_BUTTON'), array('class' => 'btn btn-link sendForm')); ?>
                            </div>
                        </form>
                    <? } ?>
                <? } ?>
            </div>
        </div>
    </div>
</div>
