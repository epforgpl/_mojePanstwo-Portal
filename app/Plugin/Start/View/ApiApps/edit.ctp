<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.api_apps.js'); ?>

<?= $this->element('Start.pageBegin'); ?>

<div class="row">
    <div class="col-md-12">

        <h1>Aplikacja: <?= $this->request->data['ApiApp']['name'] ?></h1>

        <div class="apiApps edit well bs-component mp-form dzialanie">
            <fieldset>
                <?php echo $this->Form->create('ApiApp'); ?>
                <div class="form-group">
                    <span class="title"><?= __d('start', __('LC_APIAPPS_TYP_APLIKACJI')) ?></span>

                    <div class="radio">
                        <input type="radio" disabled="disabled" name="data[ApiApp][type]" id="apiNewTypeWeb"
                               value="web"<? if ($this->request->data['ApiApp']['type'] == 'web') {
                            echo ' checked';
                        } ?>>
                        <label for="apiNewTypeWeb"><?= __d('start', __('LC_APIAPPS_APLIKACJA_WEBOWA')) ?></label>
                    </div>
                    <div class="radio">
                        <input type="radio" disabled="disabled" name="data[ApiApp][type]" id="apiNewTypeDomain"
                               value="domain"<? if ($this->request->data['ApiApp']['type'] !== 'web') {
                            echo ' checked';
                        } ?>>
                        <label for="apiNewTypeDomain"><?= __d('start', __('LC_APIAPPS_APLIKACJA_SERWEROWA')) ?></label>
                    </div>
                </div>

                <div class="form-group">
                    <? echo $this->Form->input('name', array('label' => __d('start', __('LC_APIAPPS_NAZWA')), 'class' => 'form-control')); ?>
                </div>

                <? /*
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Przeglądaj&hellip; <? echo $this->Form->file('logo'); ?>
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly
                           value="<?= @$this->request->data['ApiApp']['logo']; ?>">
                </div>
                */ ?>

                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => __d('start', __('LC_APIAPPS_OPIS')))); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('home_link', array('class' => 'form-control', 'label' => __d('start', __('LC_APIAPPS_HOMEPAGE')))); ?>
                </div>
                <? if ($this->request->data['ApiApp']['type'] !== 'domain') { ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('domains', array('class' => 'form-control', 'label' => __d('start', __('LC_APIAPPS_DOMAINS')))); ?>
                    </div>
                <? } ?>
            </fieldset>
            <span class="info-normal col-xs-12 row"><?= __d('start', __('LC_APIAPPS_PROMOTION_AGREE')) ?></span>

            <div class="optionsBtn col-xs-12">
                <?php echo $this->Form->button('<span class="icon glyphicon glyphicon-ok"></span>' . __d('start', __('LC_APIAPPS_SAVE')), array('class' => 'btn width-auto btn-primary btn-icon submitBtn')); ?>
                <?php echo $this->Html->link(__d('start', __('LC_APIAPPS_CANCEL')), array('action' => 'index'), array('class' => 'btn btn-link')); ?>
                <?php // echo $this->Form->postLink('<span class="icon glyphicon glyphicon-remove"></span>'. __d('start', __('LC_APIAPPS_DELETE')), array('action' => 'delete', $this->Form->value('ApiApp.id')), array('class' => 'btn width-auto btn-danger btn-icon deleteBtn'), __('Are you sure you want to delete # %s?', $this->Form->value('ApiApp.name'))); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
