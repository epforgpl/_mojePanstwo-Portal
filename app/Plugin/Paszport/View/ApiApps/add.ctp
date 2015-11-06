<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>
<? $this->Combinator->add_libs('js', 'Paszport.api_apps.js'); ?>

<div class="editProfile container">
    <div class="mainBlock col-xs-12 col-md-6">
        <h3>Dodaj aplikację</h3>

        <div class="apiApps add">
            <fieldset>
                <?php echo $this->Form->create('ApiApp'); ?>
                <div class="form-group">
                    <span class="title">Typ aplikacji</span>

                    <div class="radio">
                        <input type="radio" name="data[ApiApp][type]" id="apiNewTypeWeb" value="web" checked>
                        <label for="apiNewTypeWeb">Aplikacja webowa</label>
                    </div>
                    <div class="radio">
                        <input type="radio" name="data[ApiApp][type]" id="apiNewTypeDomain" value="domain">
                        <label for="apiNewTypeDomain">Aplikacja serwerowa</label>
                    </div>
                    <span class="info-warning">Uwaga! Po utworzenie typu aplikacji niemożna go zmienić</span>
                </div>
                <div class="form-group">
                    <? echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Nazwa')); ?>
                </div>
                <!--
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Przeglądaj&hellip; <? echo $this->Form->file('logo'); ?>
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly>
                </div>
                -->
                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => 'Opis (jakie zbiory danych i w jakim celu będziesz wykorzystywać)')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('home_link', array('class' => 'form-control', 'label' => 'Strona projektu / link do aplikacji')); ?>
                </div>
                <div class="form-group domainBlock">
                    <?php echo $this->Form->input('domains', array('class' => 'form-control', 'label' => 'Obsługiwane domeny (dla aplikacji webowej)')); ?>
                </div>
            </fieldset>
            <span class="info-normal col-xs-12 row">Dodając aplikację zgadasz się na wykorzystanie podanych informacji w działaniach promocyjnych serwisu Moje Państwo.</span>

            <div class="optionsBtn col-xs-12">
                <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary pull-right submitBtn')); ?>
                <?php echo $this->Form->button('Cancel', array(
                    'class' => 'btn btn-default pull-right cancelBtn',
                    'type' => 'button',
                    'onclick' => 'location.href=\'/users\'')); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>