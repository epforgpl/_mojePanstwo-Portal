<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.api_apps.js'); ?>

<?= $this->element('Start.pageBegin'); ?>

<div class="row">
    <div class="col-md-12">

        <h1>Dodaj aplikację</h1>

        <div class="apiApps add well bs-component mp-form">
            <fieldset>
                <?php echo $this->Form->create('ApiApp'); ?>
                <div class="form-group">
                    <span class="title"><?= __d('start', __('LC_APIAPPS_TYP_APLIKACJI')) ?></span>

                    <div class="radio">
                        <input type="radio" name="data[ApiApp][type]" id="apiNewTypeWeb" value="web" checked>
                        <label for="apiNewTypeWeb"><?= __d('start', __('LC_APIAPPS_APLIKACJA_WEBOWA')) ?></label>
                    </div>
                    <div class="radio">
                        <input type="radio" name="data[ApiApp][type]" id="apiNewTypeDomain" value="domain">
                        <label for="apiNewTypeDomain"><?= __d('start', __('LC_APIAPPS_APLIKACJA_SERWEROWA')) ?></label>
                    </div>
                    <span class="info-warning"><?= __d('start', __('LC_APIAPPS_ADDING_WARNING')) ?></span>
                </div>

                <div class="form-group">
                    <? echo $this->Form->input('name', array('class' => 'form-control', 'label' => __d('start', __('LC_APIAPPS_NAZWA')))); ?>
                </div>

                <? /*
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-primary btn-file">
                                Przeglądaj&hellip; <? echo $this->Form->file('logo'); ?>
                            </span>
                        </span>
                        <input type="text" class="form-control" readonly>
                    </div>
                    */ ?>

                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => __d('start', __('LC_APIAPPS_OPIS')))); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('home_link', array('class' => 'form-control', 'label' => __d('start', __('LC_APIAPPS_HOMEPAGE')))); ?>
                </div>
                <div class="form-group domainBlock">
                    <?php echo $this->Form->input('domains', array('class' => 'form-control', 'label' => __d('start', __('LC_APIAPPS_DOMAINS')))); ?>
                </div>
            </fieldset>
            <span class="info-normal col-xs-12 row">Dodając aplikację zgadasz się na wykorzystanie podanych informacji w działaniach promocyjnych serwisu Moje Państwo.</span>

            <div class="optionsBtn col-xs-12">
                <?php echo $this->Form->button('<span class="icon glyphicon glyphicon-plus"></span>' . __d('start', __('LC_APIAPPS_ADD')), array('class' => 'btn width-auto btn-primary btn-icon submitBtn')); ?>
                <?php echo $this->Html->link(__d('start', __('LC_APIAPPS_CANCEL')), array('action' => 'index'), array('class' => 'btn btn-link')); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
