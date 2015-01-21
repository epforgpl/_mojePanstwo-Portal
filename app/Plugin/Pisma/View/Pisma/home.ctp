<?php echo $this->Html->css('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min', array('block' => 'cssBlock')); ?>

<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-PL', array('block' => 'scriptBlock')); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>

<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<?php
if (!empty($pismo['szablon_id'])) $pismo_init['szablon_id'] = $pismo['szablon_id'];
if (!empty($pismo['adresat_id'])) $pismo_init['adresat_id'] = $pismo['adresat_id'];
?>

<div class="appHeader">
    <div class="container innerContent">

        <div class="col-xs-12">
            <? echo $this->Element('Pisma.menu', array(
                'selected' => 'nowe'
            )); ?>
        </div>

    </div>
</div>

<div class="_container">
    <div id="stepper">
        <h2>Wybierz szablon i adresata</h2>
        <section>

            <div class="container start">

                <div class="col-xs-12 col-md-10 col-md-offset-1">

                    <p class="hint-title">Wybierz szablon, aby ułatwić tworzenie pisma. Na podstawie wybranego szablonu,
                        umieścimy w Twoim piśmie odpowiednie formuły prawne i inne informacje. Jeśli nie chcesz
                        wybierać szablonu - przejdź dalej.</p>

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
        </section>
    </div>

</div>