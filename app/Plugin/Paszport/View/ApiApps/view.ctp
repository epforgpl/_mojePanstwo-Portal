<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>

<div class="editProfile container">
    <div class="mainBlock col-md-9">
        <h3><?php echo __('Api Apps'); ?></h3>
        <?php echo $this->Html->link(__('New Api App'), array('action' => 'add'), array('class' => 'addAppBtn btn btn-primary btn-sm pull-right')); ?>

        <div class="col-xs-12 apiApps view">
            <h2><?php echo __('Api App'); ?></h2>
            <dl>
                <dt><?php echo __('Id'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['id']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Name'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['name']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Description'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['description']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Home Link'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['home_link']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Type'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['type']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Api Key'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['api_key']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Domains'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['domains']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('User Id'); ?></dt>
                <dd>
                    <?php echo h($apiApp['ApiApp']['user_id']); ?>
                    &nbsp;
                </dd>
            </dl>
        </div>
        <div class="col-xs-12 apiActionBtn">
            <div class="btn-group" role="group">
                <?php echo $this->Html->link(__('Edit Api App'), array('action' => 'edit', $apiApp['ApiApp']['id']), array('class' => 'btn btn-warning')); ?>
                <?php echo $this->Form->postLink(__('Delete Api App'), array('action' => 'delete', $apiApp['ApiApp']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $apiApp['ApiApp']['id'])); ?>
                <?php echo $this->Html->link(__('List Api Apps'), array('action' => 'index'), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
    </div>
</div>
