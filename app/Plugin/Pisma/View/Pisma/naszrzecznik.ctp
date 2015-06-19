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
							
							
									
							<h1 class="">Wyślij pismo z poparciem kandydatury Adama Bodnara na Rzecznika Praw Obywatelskich</h1>
										
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
										<div class="well">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sodales sem ante. Phasellus nec libero risus. Aliquam erat volutpat. Fusce vel arcu dolor. Aenean condimentum eros ipsum, eget pharetra diam dictum at. Pellentesque porttitor sodales magna a posuere. Donec ut lacus ac orci ullamcorper bibendum. Sed venenatis nunc a libero cursus, sit amet congue nisi pellentesque. Nunc et tempor sapien.</p>
											<p>Sed venenatis ut ipsum nec accumsan. Donec aliquam nisl et varius mollis. Donec pellentesque mi vitae nisi fringilla, non vestibulum mauris porttitor. Mauris nec nisi laoreet, gravida ex et, sodales nibh. Cras porttitor enim at urna eleifend, a faucibus sapien sagittis. </p>
											<p><a href="#">Więcej o akcji &raquo;</a></p>
										</div>
																	
								</div>
							</div>
							
							<h2 class="text-center">Znajdź swojego posła i wyślij pismo teraz!</h2>
							<input type="hidden" name="szablon_id" value="71" />
							
							<fieldset>
                                <div class="form-group adresaci">
                                    <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>

                                    <div class="col-lg-9">
                                        <?= $this->Element('Pisma.searcher', array('q' => '', 'dataset' => 'pisma_adresaci-aktywni_poslowie', 'placeholder' => 'Zacznij pisać aby znaleźć adresata...')) ?>
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
                                        <button type="submit" class="btn btn-md btn-primary">Stwórz pismo
                                            <span class="glyphicon glyphicon-"></span>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <h2 class="text-center">Nie wiesz kto jest Twoim posłem?</h2>
                            <p class="help-block text-center"><a href="#" id="localizeMe">Zlokalizuj się</a> lub wskaż na mapie miejsce zamieszkania:</p>

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