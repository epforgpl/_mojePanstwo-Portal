<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<?= $this->Element('appheader', array('title' => 'Pisma', 'subtitle' => 'Twórz i wysyłaj pisma do urzędów i urzędnikow.', 'appMenu' => $appMenu, 'appMenuSelected' => $appMenuSelected)); ?>

<div class="container">
    <div id="stepper" class="wizard clearfix">
        <div class="content clearfix">
                <div class="container start">
                    <div class="col-xs-12">

                        <form class="letter form-horizontal" action="/pisma" method="post">

                            <?php echo $this->element('Pisma.start') ?>

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