<?php echo $this->Element('logged'); ?>

<div class="container userCenter">
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <?php echo $this->element('left_nav_block'); ?>
        </div>
        <div class="col-xs-12 col-sm-9">
            <h3><?php echo __d('paszport', $title_for_layout); ?></h3>

            <?php echo $this->Form->create('User', array('action' => 'delete')); ?>
            <div class="form-group col-xs-12 col-sm-9">
                <div class="row">
                    <?php echo $this->Form->input('User.password', array(
                        'label' => __d('paszport', 'LC_PASZPORT_DELETE_PASSWORD_CONFIRM', true),
                        'class' => "form-control"
                    )); ?>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-9">
                <div class="row">
                    <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_DELETE', true), array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>