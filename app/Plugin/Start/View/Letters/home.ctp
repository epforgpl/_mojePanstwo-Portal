<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('js', 'Start.letters.js') ?>

<?= $this->element('Start.pageBegin'); ?>

<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="col-xs-12">
        <div class="alert-identity alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Uwaga!</h4>

            <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
                    class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
                swoim koncie.</p>
        </div>
    </div>
<? } ?>

<div id="stepper" class="wizard clearfix">
    <div class="content clearfix">
        <div class="start">
            <div class="col-xs-12">

                <form class="letter form-horizontal" action="/moje-pisma" method="post">

                    <?php echo $this->element('Start.letters-start') ?>

                    <fieldset class="final">
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-1 text-center">
                                <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
                                        class="icon glyphicon glyphicon-pencil"></i>Stwórz pismo
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
