<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.api_apps.js'); ?>

<?= $this->element('Start.pageBegin'); ?>

<div class="row">
    <div class="col-md-12">

        <h1>Aplikacja: <?= $this->request->data['ApiApp']['name'] ?></h1>

        <div class="apiApps edit">
            <fieldset>
                <?php echo $this->Form->create('ApiApp'); ?>
                <div class="form-group">
                    <div class="readonly">
                        <label>Typ</label>
                        <div class="radio">
                            <input type="radio" disabled="disabled" name="data[ApiApp][type]" id="apiNewTypeWeb" value="web" checked>
                            <label for="apiNewTypeWeb">Aplikacja webowa</label>
                        </div>
                        <div class="radio">
                            <input type="radio" disabled="disabled" name="data[ApiApp][type]" id="apiNewTypeDomain" value="domain">
                            <label for="apiNewTypeDomain">Aplikacja serwerowa</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <? echo $this->Form->input('name', array('label' => 'Nazwa', 'class' => 'form-control')); ?>
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
                    <?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => 'Opis')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('home_link', array('class' => 'form-control', 'label' => 'Strona projektu / link do aplikacji')); ?>
                </div>
                <? if ($this->request->data['ApiApp']['type'] !== 'domain') { ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('domains', array('class' => 'form-control', 'label' => 'Obsługiwane domeny')); ?>
                    </div>
                <? } ?>
            </fieldset>
            <span class="info-normal col-xs-12 row">Dodając aplikację zgadasz się na wykorzystanie podanych informacji w działaniach promocyjnych serwisu Moje Państwo.</span>

            <div class="optionsBtn col-xs-12">
                <?php echo $this->Html->link('Anuluj', array('action' => 'index'), array('class' => 'btn btn-default pull-left listBtn')); ?>

                <?php echo $this->Form->button('Zapisz', array('class' => 'btn btn-primary pull-right submitBtn')); ?>
                <?php // echo $this->Form->postLink('Usuń', array('action' => 'delete', $this->Form->value('ApiApp.id')), array('class' => 'btn btn-danger pull-right deleteBtn'), __('Are you sure you want to delete # %s?', $this->Form->value('ApiApp.name'))); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
