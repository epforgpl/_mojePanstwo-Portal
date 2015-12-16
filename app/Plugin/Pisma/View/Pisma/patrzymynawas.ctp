<? // echo $this->Element('menu'); ?>


<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma-patrzymynawas.js') ?>

<?php switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
}; ?>
<?php echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock')); ?>

<div class="container">
    <div class="row">
        <div id="stepper" class="wizard clearfix">
            <div class="content clearfix">
                <div class="container start naszrzecznik">
                    <div class="col-xs-12">

                        <form class="letter form-horizontal" action="/moje-pisma" method="post">

                            <?php $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma'))) ?>
                            <?php $this->Combinator->add_libs('css', $this->Less->css('naszrzecznik', array('plugin' => 'Pisma'))) ?>
                            <?php $this->Combinator->add_libs('js', 'Pisma.pisma-button.js') ?>



                            <h1 class="text-center">Wyślij pismo w super ważnej sprawie!</h1>

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="well">
                                        <p>Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem próbnej książki. Pięć wieków później zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym. Spopularyzował się w latach 60. XX w. wraz z publikacją arkuszy Letrasetu, zawierających fragmenty Lorem Ipsum, a ostatnio z zawierającym różne wersje Lorem Ipsum oprogramowaniem przeznaczonym do realizacji druków na komputerach osobistych, jak Aldus PageMaker.</p>

                                        <p><a href="http://patrzymynawas.pl/" target="_blank">Więcej o akcji &raquo;</a>
                                        </p>
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
                                        <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
                                                class="icon glyphicon glyphicon-pencil"></i>Stwórz pismo
                                        </button>
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
