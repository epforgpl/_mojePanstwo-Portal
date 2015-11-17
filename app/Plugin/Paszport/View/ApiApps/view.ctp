<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>

<div class="editProfile container">
    <div class="mainBlock col-xs-12 col-md-6">
        <h3><?php echo __('Api Apps'); ?></h3>
        <?php echo $this->Html->link(__('New Api App'), array('action' => 'add'), array('class' => 'addAppBtn btn btn-primary btn-sm pull-right')); ?>

        <div class="apiApps view">
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('Id') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['id']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('Type') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['type']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('Name') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['name']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('Description') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['description']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('Home Link') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['home_link']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('Domains') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['domains']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('API Key') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['api_key']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="readonly">
                    <label><?= __('User ID') ?></label>

                    <p class="form-control form-control-static"><?= h($apiApp['ApiApp']['user_id']); ?></p>
                </div>
            </div>
            <div class="optionsBtn col-xs-12">
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('class' => 'btn btn-default pull-left listBtn')); ?>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $apiApp['ApiApp']['id']), array('class' => 'btn btn-warning pull-right editBtn')); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $apiApp['ApiApp']['id']), array('class' => 'btn btn-danger pull-right deleteBtn'), __('Are you sure you want to delete # %s?', $apiApp['ApiApp']['id'])); ?>
            </div>
        </div>
    </div>
</div>