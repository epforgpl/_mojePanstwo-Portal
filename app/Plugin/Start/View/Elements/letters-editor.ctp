<?php echo $this->Html->css('/plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min', array('block' => 'cssBlock')); ?>

<?php echo $this->Html->script('/plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('/plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-PL', array('block' => 'scriptBlock')); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('js', 'Start.letters-jquery.autosize.min.js') ?>
<?php $this->Combinator->add_libs('js', 'Start.letters.js') ?>

<?php
if (!empty($pismo['szablon_id'])) {
    $pismo_init['szablon_id'] = $pismo['szablon_id'];
}
if (!empty($pismo['adresat_id'])) {
    $pismo_init['adresat_id'] = $pismo['adresat_id'];
}
?>

<div class="editPage">
    <? echo $this->element('Start.letters-pismo-header', array(
        'pismo' => $pismo,
        'alert' => true,
        'editable' => true
    )); ?>

    <div id="stepper" class="stepper"<? if (!empty($pismo_init)) {
        echo ' data-pismo=' . json_encode($pismo_init);
    } ?> data-status-check="<?= $pismo['saved'] ?>">
        <section>
            <form class="form-save" method="post" action="/moje-pisma/<?= $pismo['alphaid'] ?>,<?= $pismo['slug'] ?>">
                <div class="col-xs-12 noleftpadding">
                    <div class="alert alert-info">
                        <h4>Edycja pisma</h4>

                        <div class="wysightml5Block pull-left"></div>
                        <ul class="actionButton form-buttons pull-right">
                            <li class="inner-addon">
                                <button type="submit" class="btn btn-primary btn-icon action savePismo"
                                        name="_save"><i
                                        class="icon glyphicon glyphicon-save"></i>Zapisz
                                </button>
                                <a class="btn btn-default" style="width: inherit; margin-left: 5px;"
                                   href="/moje-pisma/<?= $pismo['alphaid'] ?>,<?= $pismo['slug'] ?>">Anuluj</a>
                                <input type="hidden" name="save" value="1"/>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="container edit">
                    <div class="editor-container row">
                        <div class="col-xs-12 norightpadding">
                            <? echo $this->element('Start.letters-render', array('pismoEditPage' => true)); ?>
                        </div>
                        <div class="col-xs-12 nopadding">
                            <div class="editor-tooltip">
                                <? if (!$this->Session->read('Auth.User.id')) { ?>
                                    <div class="alert alert-dismissable alert-success" style="margin-top: 0;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <h4>Uwaga!</h4>

                                        <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez
                                            24 godziny. <a
                                                class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby
                                            trwale przechowywać pisma na
                                            swoim koncie.</p>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
