<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>

<div class="editProfile container">
    <div class="mainBlock col-md-9">
        <h3><?php echo __('Api Apps'); ?></h3>
        <?php echo $this->Html->link(__('New Api App'), array('action' => 'add'), array('class' => 'addAppBtn btn btn-primary btn-sm pull-right')); ?>

        <div class="col-xs-12 apiApps form">
            <?php echo $this->Form->create('ApiApp'); ?>
            <fieldset>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name');
                echo $this->Form->input('description');
                echo $this->Form->input('home_link');;
                ?>
            </fieldset>
            <?php echo $this->Form->end(__('Submit')); ?>
        </div>
        <div class="col-xs-12 apiActionBtn">
            <div class="btn-group" role="group">
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ApiApp.id')), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $this->Form->value('ApiApp.id'))); ?>
                <?php echo $this->Html->link(__('List Api Apps'), array('action' => 'index')); ?>
            </div>
        </div>
    </div>
</div>