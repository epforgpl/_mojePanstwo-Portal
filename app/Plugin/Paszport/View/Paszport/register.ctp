<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?= $this->Element('appheader'); ?>
<div class="objectsPage">
    <div class="createAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"
                        id="myModalLabel"><?php echo __d('paszport', "LC_PASZPORT_CREATE_MOTTO") ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $this->Form->create('Paszport', array('plugin' => 'Paszport', 'action' => 'register')); ?>
                            <div class="slide inputForm col-xs-12">
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

                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.language_id', array(
                            'class' => 'selectpicker',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_LANGUAGE", true)
                        )); ?>
                    </div>

                    <div class="slide inputForm sendForm col-xs-12">
                        <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_REGISTER_BUTTON'), array('class' => 'btn btn-primary sendForm')); ?>
                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>