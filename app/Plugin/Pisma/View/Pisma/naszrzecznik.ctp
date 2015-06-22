<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma-naszrzecznik.js') ?>
<?php echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock')); ?>

<div class="container">
    <div class="row">
        <div id="stepper" class="wizard clearfix">
            <div class="content clearfix">
                <div class="container start naszrzecznik">
                    <div class="col-xs-12">

                        <form class="letter form-horizontal" action="/pisma" method="post">

                            <?php $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma'))) ?>
                            <?php $this->Combinator->add_libs('css', $this->Less->css('naszrzecznik', array('plugin' => 'Pisma'))) ?>
                            <?php $this->Combinator->add_libs('js', 'Pisma.pisma-button.js') ?>



                            <h1 class="text-center">Wyślij pismo z poparciem kandydatury Adama Bodnara na Rzecznika Praw
                                Obywatelskich</h1>

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="well">
                                        <p>Chcesz aby Adam Bodnar został wybrany przez Sejm na Rzecznika Praw Obywatelskich (RPO)? Skorzystaj z poniższego formularza by wysłać maila do wybranego posła lub posłanki z prośbą o głosowanie za kandydaturą Adama Bodnara na RPO. Możesz wysłać wiadomość z proponowaną poniżej treścią lub zmienić treść wg swojego uznania.</p>

                                        <p><a href="http://naszrzecznik.pl" target="_blank">Więcej o akcji &raquo;</a></p>
                                    </div>

                                </div>
                            </div>

                            <h2 class="text-center">Znajdź swojego posła i wyślij pismo teraz!</h2>
                            <input type="hidden" name="szablon_id" value="71"/>

                            <fieldset>
                                <div class="form-group adresaci">
                                    <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>

                                    <div class="col-lg-9">
                                        <div class="suggesterBlockPisma">
                                            <?= $this->Element('Pisma.searcher', array('q' => '', 'dataset' => 'pisma_adresaci-aktywni_poslowie', 'placeholder' => 'Zacznij pisać aby znaleźć adresata...')) ?>
                                        </div>
                                        <span
                                            class="help-block">Na podstawie wybranego posła, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
                                    </div>

                                    <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
                                        echo ' value="' . $pismo['adresat_id'] . '"';
                                    } ?>>

                                </div>
                            </fieldset>

                            <fieldset class="final">
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-1 text-center">
                                        <button type="submit" class="btn btn-md btn-primary">Stwórz pismo</button>
                                    </div>
                                </div>
                            </fieldset>

                            <h2 class="text-center">Nie wiesz kto jest Twoim posłem?</h2>

                            <p class="help-block text-center"><a href="#" id="localizeMe">Zlokalizuj się</a> lub wskaż
                                na mapie miejsce zamieszkania:</p>

                            <div class="row">
                                <div id="map"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div data-name="okregi" data-value='<?= json_encode($okregi) ?>'></div>

<div class="modal fade" id="wybierzPosla" tabindex="-1" role="dialog" aria-labelledby="wybierzPoslaLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
            </div>
        </div>
    </div>
</div>