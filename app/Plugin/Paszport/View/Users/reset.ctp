<?php echo $this->Element('notlogged'); ?>

<?php echo $this->Session->flash('flash', array('element' => 'alert')); ?>
<?php echo $this->Session->flash('auth', array('element' => 'alert')); ?>

<div class="main">
    <div class="content">
        <div class="forgotPassword">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo __d('paszport', "LC_PASZPORT_RESET_PASSWORD_MOTTO") ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo $this->Form->create('User', array('action' => 'reset')); ?>

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

                        <div class="slide inputForm sendForm col-xs-12">
                            <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_RESERT_BUTTON'), array('class' => 'btn btn-primary sendForm')); ?>
                        </div>

                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>