<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'MojePisma'))) ?>
<?php $this->Combinator->add_libs('js', 'MojePisma.pisma.js') ?>

<?= $this->Element('appheader') ?>

<div class="container">
    <div class="row">
        <div id="stepper" class="wizard clearfix">
            <div class="content clearfix">
                <div class="container start">
                    <div class="col-xs-12">

                        <form class="letter form-horizontal" action="/moje-pisma" method="post">

                            <?php echo $this->element('MojePisma.start') ?>

                            <fieldset class="final">
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-1 text-center">
                                        <button type="submit" class="btn btn-md btn-primary">Stwórz pismo
                                            <span class="glyphicon glyphicon-"></span>
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