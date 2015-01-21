<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>

<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<div class="appHeader">
    <div class="container innerContent">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <? echo $this->Element('Pisma.menu', array(
                'selected' => 'nowe'
            )); ?>
        </div>
    </div>
</div>

<div id="stepper" class="wizard clearfix">
    <div class="content clearfix">
        <h2 class="title current">Wybierz szablon i adresata</h2>
        <section class="body current">
            <div class="container start">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <p class="hint-title">Wybierz szablon, aby ułatwić tworzenie pisma. Na podstawie wybranego
                        szablonu,
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