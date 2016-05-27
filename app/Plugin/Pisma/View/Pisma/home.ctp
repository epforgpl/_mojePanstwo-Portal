<? echo $this->Element('menu'); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="container">
        <div class="col-md-10 col-sm-offset-1">
            <div class="alert-identity alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
                        class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
                    swoim koncie.</p>
            </div>
        </div>
    </div>
<? } ?>

<div class="container">
    <div class="row">
        <div id="stepper" class="wizard clearfix">
            <div class="content clearfix">
                <div class="container start">
                    <div class="col-xs-12">

                        <form class="letter form-horizontal" action="/pisma" method="post">

                            <?php echo $this->element('Pisma.start') ?>

                            <fieldset class="final">
                                <div class="form-group">
                                    <div class="col-lg-12 text-center">
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
    </div>
</div>
