<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?= $this->Element('appheader'); ?>
<div class="objectsPage">
    <div id="modalPaszportLoginForm" class="paszportModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                    <h4 class="modal-title"
                        id="myModalLabel"><?php echo __d('paszport', 'LC_PASZPORT_PROJECT_MOTTO'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $this->Form->create('User', array(
                        'id' => 'UserLoginForm',
                        'url' => $this->Html->url(array(
                            'plugin' => 'paszport',
                            'controller' => 'paszport',
                            'action' => 'login',
                            'full_base' => true
                        ))
                    )); ?>

                    <div class="slide or col-xs-12">
                        <?php echo __d('paszport', 'LC_PASZPORT_MODAL_LOGIN_VIA_EMAIL') ?>
                    </div>

                    <div class="slide loginEmailForm col-xs-12">
                        <?php echo $this->Form->input('User.email', array(
                            'class' => 'input-xlarge',
                            'type' => 'email',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_EMAIL", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_EMAIL_REQUIRED", true),
                            'required' => 'required',
                            'data-validation-email-message' => __d('paszport', "LC_PASZPORT_NOT_A_VALID_EMAIL", true),
                            'after' => '<span class="help-block"></span>',
                            'class' => 'form-control'
                        )); ?>
                        <?php echo $this->Form->input('User.password', array(
                            'class' => 'input-xlarge',
                            'type' => 'password',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_PASSWORD", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_PASSWORD_REQUIRED", true),
                            'required' => 'required',
                            'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                            'minlength' => '6',
                            'after' => '<span class="help-block"></span>',
                            'class' => 'form-control'
                        )); ?>
                    </div>

                    <div class="slide loginOptions col-xs-12">
                        <?php echo $this->Html->link(__d('paszport', 'LC_PASZPORT_FORGOT_PASSWORD', true), array(
                            'plugin' => 'paszport',
                            'controller' => 'users',
                            'action' => 'forgot'
                        )); ?>
                    </div>

                    <div class="slide loginSend col-xs-12">
                        <div class="content">
                            <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_LOGIN'), array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>

                    <div class="slide or col-xs-12">
                        <?php echo __d('paszport', 'LC_PASZPORT_MODAL_LOGIN_VIA_FACEBOOK') ?>
                    </div>

                    <div class="slide logInVia col-xs-12">
                        <div class="content text-center">
                            <?php echo $this->Html->link('<i class="fa fa-facebook"></i>' . __d('paszport', 'LC_PASZPORT_LOGIN'), array(
                                'plugin' => 'paszport',
                                'controller' => 'users',
                                'action' => 'fblogin'
                            ), array('class' => 'btn btn-facebook btn-md', 'escape' => false)); ?>
                        </div>
                    </div>

                    <div class="slide register col-xs-12">
                        <?php echo $this->Html->link(__d('paszport', 'LC_PASZPORT_MODAL_LOGIN_REGISTER', true), array(
                            'plugin' => 'paszport',
                            'controller' => 'users',
                            'action' => 'add'
                        ), array('class' => 'register', 'autocomplete' => 'off', 'target' => '_self')); ?>
                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>