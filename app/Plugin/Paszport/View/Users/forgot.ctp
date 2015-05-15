<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>

<?php echo $this->Session->flash('flash', array('element' => 'alert')); ?>
<?php echo $this->Session->flash('auth', array('element' => 'alert')); ?>

<div class="objectsPage fullPageHeight mpBackgroundSet"
     style="background-image: url(<?php if (isset($_COOKIE["mojePanstwo"])) {
         $mojePanstwo = json_decode($_COOKIE["mojePanstwo"]);
         echo $mojePanstwo->background->set;
     } else {
         echo '/img/home/backgrounds/home-background-default.jpg';
     } ?>)">
    <div class="forgotPassword" id="modalPaszportLoginForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"
                        id="myModalLabel"><?php echo __d('paszport', "LC_PASZPORT_PASSWORD_FORGOT_MOTTO") ?></h4>
                </div>
                <div class="modal-body">
                    <div class="slide inputForm textForm col-xs-12">
                        <?php echo __d('paszport', "LC_PASZPORT_FORGOT_PASSWORD_EVANGELION"); ?>
                    </div>

                    <?php echo $this->Form->create('User', array('action' => 'forgot')); ?>

                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.email', array(
                            'class' => 'input-xlarge form-control',
                            'type' => 'email',
                            'label' => '',
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_EMAIL_REQUIRED", true),
                            'required' => 'required',
                            'data-validation-email-message' => __d('paszport', "LC_PASZPORT_NOT_A_VALID_EMAIL", true),
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>

                    <div class="slide inputForm sendForm col-xs-12">
                        <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_FORGET_BUTTON'), array('class' => 'btn btn-primary sendForm')); ?>
                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
