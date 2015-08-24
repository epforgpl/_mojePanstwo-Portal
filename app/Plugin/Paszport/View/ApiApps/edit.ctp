<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>
<? $this->Combinator->add_libs('js', 'Paszport.api_apps.js'); ?>

<div class="editProfile container">
    <div class="mainBlock col-xs-12 col-md-6">
        <h3><?php echo __('Api Apps'); ?></h3>
        <?php echo $this->Html->link(__('New Api App'), array('action' => 'add'), array('class' => 'addAppBtn btn btn-primary btn-sm pull-right')); ?>

        <div class="apiApps edit">
            <fieldset>
                <?php echo $this->Form->create('ApiApp'); ?>
                <div class="form-group">
                    <div class="readonly">
                        <label><?= __('Type') ?></label>

                        <p class="form-control form-control-static"><?= $this->request->data['ApiApp']['type']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <? echo $this->Form->input('name', array('class' => 'form-control')); ?>
                </div>
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Przeglądaj&hellip; <? echo $this->Form->file('logo'); ?>
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly
                           value="<?= @$this->request->data['ApiApp']['logo']; ?>">
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('home_link', array('class' => 'form-control')); ?>
                </div>
                <? if ($this->request->data['ApiApp']['type'] !== 'domain') { ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('domains', array('class' => 'form-control')); ?>
                    </div>
                <? } ?>
            </fieldset>
            <span class="info-normal col-xs-12 row">Dodając aplikację zgadasz się na wykorzystanie podanych informacji w działaniach promocyjnych serwisu Moje Państwo.</span>

            <div class="optionsBtn col-xs-12">
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('class' => 'btn btn-default pull-left listBtn')); ?>

                <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary pull-right submitBtn')); ?>
                <?php echo $this->Form->button('Cancel', array(
                    'class' => 'btn btn-default pull-right cancelBtn',
                    'type' => 'button',
                    'onclick' => 'location.href=\'/users\'')); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ApiApp.id')), array('class' => 'btn btn-danger pull-right deleteBtn'), __('Are you sure you want to delete # %s?', $this->Form->value('ApiApp.id'))); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>