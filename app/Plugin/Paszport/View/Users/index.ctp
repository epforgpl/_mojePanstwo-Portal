<?php echo $this->Element('logged'); ?>

<div class="container userCenter">
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <?php echo $this->element('left_nav_block'); ?>
        </div>
        <div class="col-xs-12 col-sm-9">
            <h1><?php echo __d('paszport', $title_for_layout); ?></h1>

            <div class="row general mpanel">
                <div class="basic col-xs-11 col-md-8">
                    <ul>
                        <?php if ($this->data['User']['group_id'] == '1') { ?>
                            <li class="name">
                                <?php echo $this->Form->create('User', array(
                                    'url' => array(
                                        'controller' => 'users',
                                        'action' => 'field',
                                        'ext' => 'json'
                                    )
                                )); ?>
                                <div class="viewElement form-group">
                                    <?php echo $this->Form->input('User.username', array(
                                        'disabled' => 'disabled',
                                        'label' => __d('paszport', 'LC_PASZPORT_USERNAME', true),
                                        'class' => 'form-control'
                                    )); ?>
                                </div>
                                <div class="editElement form-group">
                                    <?php echo $this->Form->input('User.username', array(
                                        'label' => __d('paszport', 'LC_PASZPORT_USERNAME', true),
                                        'data-validation-required-message' => __d('paszport', "LC_PASZPORT_NAME_REQUIRED", true),
                                        'required' => 'required',
                                        'autocomplete' => 'off',
                                        'after' => '<span class="help-block"></span>',
                                        'class' => 'form-control'
                                    )); ?>
                                </div>
                                <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_EDIT'), array(
                                    'class' => 'btn btn-default edit doubleState',
                                    'data-text' => __d('paszport', 'LC_PASZPORT_SAVE')
                                )); ?>
                                <?php echo $this->Form->end(); ?>
                            </li>
                        <?php } ?>
                        <?php if ($this->data['User']['group_id'] == '2') { ?>
                            <li class="name">
                                <?php echo $this->Form->create('User', array(
                                    'url' => array(
                                        'controller' => 'users',
                                        'action' => 'field',
                                        'ext' => 'json'
                                    )
                                )); ?>
                                <div class="viewElement">
                                    <?php echo $this->Form->input('User.username', array(
                                        'disabled' => 'disabled',
                                        'label' => __d('paszport', 'LC_PASZPORT_USERNAME', true),
                                        'class' => 'form-control'
                                    )); ?>
                                </div>
                                <div class="editElement form-group">
                                    <?php echo $this->Form->input('User.username', array(
                                        'label' => __d('paszport', 'LC_PASZPORT_USERNAME', true),
                                        'data-validation-required-message' => __d('paszport', "LC_PASZPORT_INSTITUTION_NAME_REQUIRED", true),
                                        'required' => 'required',
                                        'autocomplete' => 'off',
                                        'after' => '<span class="help-block"></span>',
                                        'class' => 'form-control'
                                    )); ?>
                                </div>
                                <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_EDIT'), array(
                                    'class' => 'btn btn-default edit doubleState',
                                    'data-text' => __d('paszport', 'LC_PASZPORT_SAVE')
                                )); ?>
                                <?php echo $this->Form->end(); ?>
                            </li>
                        <?php } ?>
                        <li class="email">
                            <?php echo $this->Form->create('User', array(
                                'url' => array(
                                    'controller' => 'users',
                                    'action' => 'field',
                                    'ext' => 'json'
                                )
                            )); ?>
                            <div class="viewElement form-group">
                                <?php echo $this->Form->input('User.email', array(
                                    'disabled' => 'disabled',
                                    'label' => __d('paszport', 'LC_PASZPORT_EMAIL', true),
                                    'type' => 'email',
                                    'class' => 'form-control'
                                )); ?>
                            </div>
                            <div class="editElement form-group">
                                <?php echo $this->Form->input('User.email', array(
                                    'label' => __d('paszport', 'LC_PASZPORT_EMAIL', true),
                                    'type' => 'email',
                                    'data-validation-required-message' => __d('paszport', "LC_PASZPORT_EMAIL_REQUIRED", true),
                                    'required' => 'required',
                                    'data-validation-email-message' => __d('paszport', "LC_PASZPORT_NOT_A_VALID_EMAIL", true),
                                    'autocomplete' => 'off',
                                    'after' => '<span class="help-block"></span>',
                                    'class' => 'form-control'
                                )); ?>
                            </div>
                            <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_EDIT'), array(
                                'class' => 'btn btn-default edit doubleState',
                                'data-text' => __d('paszport', 'LC_PASZPORT_SAVE')
                            )); ?>
                            <?php echo $this->Form->end(); ?>
                        </li>
                        <li class="password">
                            <?php echo $this->Form->create('User', array(
                                'url' => array(
                                    'controller' => 'users',
                                    'action' => 'field',
                                    'ext' => 'json'
                                )
                            )); ?>
                            <div class="viewElement form-group">
                                <?php echo $this->Form->input('User.pass', array(
                                    'disabled' => 'disabled',
                                    'label' => __d('paszport', 'LC_PASZPORT_PASSWORD', true),
                                    'type' => 'password',
                                    'placeholder' => '*******',
                                    'class' => 'form-control'
                                )); ?>
                            </div>
                            <div class="editElement form-group">
                                <?php echo $this->Form->input('User.pass', array(
                                    'label' => __d('paszport', 'LC_PASZPORT_CURRENT_PASSWORD', true),
                                    'type' => 'password',
                                    'data-validation-required-message' => __d('paszport', 'LC_PASZPORT_CURRENT_PASSWORD_BLANK', true),
                                    'required' => 'required',
                                    'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                                    'minlength' => '6',
                                    'autocomplete' => 'off',
                                    'after' => '<span class="help-block"></span>',
                                    'class' => 'form-control'
                                )); ?>
                                <?php echo $this->Form->input('User.newpass', array(
                                    'label' => __d('paszport', 'LC_PASZPORT_NEW_PASSWORD', true),
                                    'type' => 'password',
                                    'data-validation-required-message' => __d('paszport', 'LC_PASZPORT_NEW_PASSWORD_BLANK', true),
                                    'required' => 'required',
                                    'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                                    'minlength' => '6',
                                    'autocomplete' => 'off',
                                    'after' => '<span class="help-block"></span>',
                                    'class' => 'form-control'
                                )); ?>
                                <?php echo $this->Form->input('User.confirmnewpass', array(
                                    'label' => __d('paszport', 'LC_PASZPORT_CONFIRM_PASSWORD', true),
                                    'type' => 'password',
                                    'data-validation-match-match' => 'data[User][newpass]',
                                    'data-validation-match-message' => __d('paszport', "LC_PASZPORT_CONFIRM_PASSWORD_NOT_EQUAL", true),
                                    'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                                    'minlength' => '6',
                                    'autocomplete' => 'off',
                                    'after' => '<span class="help-block"></span>',
                                    'class' => 'form-control'
                                )); ?>
                            </div>
                            <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_EDIT'), array(
                                'class' => 'btn btn-default edit doubleState passwordButton',
                                'data-text' => __d('paszport', 'LC_PASZPORT_SAVE')
                            )); ?>
                            <?php echo $this->Form->end(); ?>
                        </li>
                        <?php if ($this->data['User']['group_id'] == '1') { ?>
                            <li class="gender">
                                <?php
                                if (isset($this->data['User']['personal_gender'])) {
                                    switch ($this->data['User']['personal_gender']) {
                                        case 0:
                                            $genderNice = __d('paszport', 'LC_PASZPORT_GENDER_NOT_SET');
                                            break;
                                        case 1:
                                            $genderNice = __d('paszport', 'LC_PASZPORT_GENDER_MALE');
                                            break;
                                        case 2:
                                            $genderNice = __d('paszport', 'LC_PASZPORT_GENDER_FEMALE');
                                            break;
                                        default:
                                            $genderNice = __d('paszport', 'LC_PASZPORT_GENDER_NOT_SET');
                                            break;
                                    }
                                } else {
                                    $genderNice = __d('paszport', 'LC_PASZPORT_GENDER_NOT_SET');
                                } ?>
                                <?php echo $this->Form->create('User', array(
                                    'url' => array(
                                        'controller' => 'users',
                                        'action' => 'field',
                                        'ext' => 'json'
                                    )
                                )); ?>
                                <div class="viewElement">
                                    <?php echo $this->Form->input('User.personal_gender', array(
                                        'disabled' => 'disabled',
                                        'type' => 'text',
                                        'label' => __d('paszport', 'LC_PASZPORT_GENDER', true),
                                        'value' => $genderNice,
                                        'class' => 'form-control'
                                    )); ?>
                                </div>
                                <div class="editElement form-group">
                                    <?php echo $this->Form->input('User.personal_gender', array(
                                        'type' => 'select',
                                        'class' => 'selectpicker',
                                        'options' => array(
                                            '0' => __d('paszport', 'LC_PASZPORT_GENDER_NOT_SET'),
                                            '1' => __d('paszport', 'LC_PASZPORT_GENDER_MALE'),
                                            '2' => __d('paszport', 'LC_PASZPORT_GENDER_FEMALE')
                                        ),
                                        'selected' => (isset($this->data['User']['personal_gender'])) ? $this->data['User']['personal_gender'] : 0,
                                        'label' => __d('paszport', __d('paszport', 'LC_PASZPORT_GENDER'), true)
                                    )); ?>
                                </div>
                                <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_EDIT'), array(
                                    'class' => 'btn btn-default edit doubleState genderButton',
                                    'data-text' => __d('paszport', 'LC_PASZPORT_SAVE')
                                )); ?>
                                <?php echo $this->Form->end(); ?>
                            </li>
                            <li class="bday">
                                <?php echo $this->Form->create('User', array(
                                    'url' => array(
                                        'controller' => 'users',
                                        'action' => 'field',
                                        'ext' => 'json'
                                    )
                                )); ?>
                                <div class="viewElement">
                                    <?php if (isset($this->data['User']['personal_bday']) && $this->data['User']['personal_bday'] != '0000-00-00') {
                                        echo $this->Form->input('User.personal_bday', array(
                                            'type' => 'text',
                                            'disabled' => 'disabled',
                                            'label' => __d('paszport', 'LC_PASZPORT_DOB', true),
                                            'value' => $this->Time->format('d-m-Y', $this->data['User']['personal_bday']),
                                            'class' => 'form-control'
                                        ));
                                    } else {
                                        echo $this->Form->input('User.personal_bday', array(
                                            'type' => 'text',
                                            'disabled' => 'disabled',
                                            'label' => __d('paszport', 'LC_PASZPORT_DOB', true),
                                            'placeholder' => date('d-m-Y'),
                                            'class' => 'form-control'
                                        ));
                                    } ?>
                                </div>
                                <div class="editElement form-group">
                                    <div class="control-group">
                                        <label class="control-label"
                                               for="UserPersonalBday"><?php echo __d('paszport', 'LC_PASZPORT_DOB', true) ?></label>

                                        <div class="controls input-append dpYears"
                                             data-date="<?php if (isset($this->data['User']['personal_bday']) && $this->data['User']['personal_bday'] != '0000-00-00') {
                                                 echo $this->Time->format('Y-m-d', $this->data['User']['personal_bday']);
                                             } else {
                                                 echo date('Y-m-d');
                                             } ?>">
                                            <input type="text" id="UserPersonalBday" class="form-control input-append"
                                                   <?php if (isset($this->data['User']['personal_bday']) && $this->data['User']['personal_bday'] != '0000-00-00'){ ?>value="<?php echo $this->Time->format('d-m-Y', $this->data['User']['personal_bday']) ?>" <?php } ?>
                                                   name="data[User][personal_bday]"
                                                   placeholder="<?php echo date('d-m-Y') ?>"
                                                   autocomplete='off'/>
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_EDIT'), array(
                                    'class' => 'btn btn-default edit doubleState bDayButton',
                                    'data-text' => __d('paszport', 'LC_PASZPORT_SAVE')
                                )); ?>
                                <?php echo $this->Form->end(); ?>
                            </li>
                        <?php } ?>
                        <li class="language">
                            <?php echo $this->Form->create('User', array(
                                'url' => array(
                                    'controller' => 'users',
                                    'action' => 'field',
                                    'ext' => 'json'
                                )
                            )); ?>
                            <div class="viewElement">
                                <?php echo $this->Form->input('User.language_id', array(
                                    'type' => 'text',
                                    'disabled' => 'disabled',
                                    'label' => __d('paszport', 'LC_PASZPORT_LANGUAGE', true),
                                    'value' => $this->data['Language']['label'],
                                    'class' => 'form-control'
                                )); ?>
                            </div>
                            <div class="editElement form-group">
                                <?php echo $this->Form->input('User.language_id', array(
                                    'label' => __d('paszport', 'LC_PASZPORT_LANGUAGE'),
                                    'class' => 'selectpicker'
                                )); ?>
                            </div>
                            <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_EDIT'), array(
                                'class' => 'btn btn-default edit doubleState languageButton',
                                'data-text' => __d('paszport', 'LC_PASZPORT_SAVE')
                            )); ?>
                            <?php echo $this->Form->end(); ?>
                        </li>

                        <li>
                            <label><?php echo __d('paszport', "LC_PASZPORT_USER_SPECIAL_ACTIONS"); ?></label>
                            <a class="btn btn-default deleteAccount"
                               href="<?php echo $this->Html->url(array(
                                   'plugin' => 'paszport',
                                   'controller' => 'users',
                                   'action' => 'delete'
                               )); ?>"><?php echo __d('paszport', 'LC_PASZPORT_ACCOUNT_DELETE_LINK'); ?></a>
                        </li>

                    </ul>

                </div>
                <div class="avatar col-md-4 hidden-xs hidden-sm">
                    <?php if ($this->Session->read('Auth.User.photo')) { ?>
                        <?php echo $this->Html->image($this->Session->read('Auth.User.photo'), array('class' => 'img-polaroid')); ?>
                    <?php } else { ?>
                        <?php $thumb = $this->Image2->source('img/default.jpg')
                            ->crop(190, 190)
                            ->imagePath(); ?>
                        <?php echo $this->Html->image($thumb, array('class' => 'img-polaroid')); ?>
                    <?php } ?>
                    <div class="row">
                        <a href="<?php echo $this->Html->url(array(
                            'controller' => 'users',
                            'action' => 'avatar',
                            'delete'
                        )); ?>"
                           class="btn btn-default delete pull-left"><?php echo __d('paszport', 'LC_PASZPORT_DELETE'); ?></a>
                        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'avatar')); ?>"
                           class="btn btn-default edit pull-right"><?php echo __d('paszport', 'LC_PASZPORT_CHANGE'); ?></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
