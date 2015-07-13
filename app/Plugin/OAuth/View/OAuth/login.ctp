<div class="main">
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="span4">
                    <?php echo $this->Html->link(
                        $this->Html->image("logo.svg", array("alt" => __('LC_PROJECT_NAME', true))),
                        array(
                            'controller' => 'users',
                            'action' => ($this->Session->read('Auth.User.id')) ? 'index' : 'login'
                        ),
                        array('escape' => false)
                    ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container userHelper createAccount">
            <?php echo $this->Form->create('Paszport.User'); ?>
            <div class="row">
                <div class="span6 offset2">
                    <div class="control-group">

                    </div>
                </div>
            </div>
            <?php
            foreach ($OAuthParams as $key => $value) {
                echo $this->Form->hidden(h($key), array('value' => h($value)));
            }
            ?>
            <?php echo $this->Form->hidden('User.group_id'); ?>
            <div class="row">
                <div class="span6 offset2">
                    <?php echo $this->Form->input('User.email', array(
                        'type' => 'email',
                        'label' => __("LC_CREATE_EMAIL", true),
                        'data-validation-required-message' => __("LC_EMAIL_REQUIRED", true),
                        'required' => 'required',
                        'data-validation-email-message' => __("LC_NOT_A_VALID_EMAIL", true),
                        'after' => '<p class="help-block"></p>'
                    )); ?>
                </div>
            </div>
            <div class="row">
                <div class="span3 offset2">
                    <?php echo $this->Form->input('User.password', array(
                        'type' => 'password',
                        'label' => __("LC_CREATE_PASSWORD", true),
                        'data-validation-required-message' => __("LC_NEW_PASSWORD_BLANK", true),
                        'required' => 'required',
                        'data-validation-minlength-message' => __("LC_PASSWORD_MIN_6_CHAR", true),
                        'minlength' => '6',
                        'after' => '<p class="help-block"></p>'
                    )); ?>
                </div>
            </div>
            <div class="row last">
                <div class="span4 offset2">
                    <?php echo $this->Form->submit(__('LC_LOGIN'), array('class' => 'btn btn-primary btn-large')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>