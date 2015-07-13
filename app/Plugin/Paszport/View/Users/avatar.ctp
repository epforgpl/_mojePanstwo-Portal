<?php echo $this->Element('logged'); ?>

<div class="container userCenter">
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <?php echo $this->element('left_nav_block'); ?>
        </div>
        <div class="col-xs-12 col-sm-9">
            <h3><?php echo __d('paszport', $title_for_layout); ?></h3>

            <div class="row general">
                <div class="col-xs-11 col-md-6">
                    <h5><?php echo __d('paszport', 'LC_PASZPORT_CHANGE_AVATAR_TITLE', true); ?></h5>

                    <?php echo $this->Form->create('User', array('class' => 'inline', 'type' => 'file')); ?>
                    <?php echo $this->Form->input('User.photo', array(
                        'label' => " ",
                        'type' => 'file',
                        'class' => 'btn btn-link'
                    )); ?>
                    <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_SEND', true), array('class' => 'btn btn-primary')); ?>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>