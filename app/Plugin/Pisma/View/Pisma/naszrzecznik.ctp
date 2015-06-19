<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

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
							
							<fieldset>
							    <div class="form-group adresaci">
							        <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>
							
							        <div class="col-lg-9">
							            <input class="form-control input-lg" id="adresatSelect"
							                   placeholder="Zacznij pisać aby znaleźć posła..."
							                   type="text" autocomplete="off"/>
							
							            <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
							                echo ' value="' . $pismo['adresat_id'] . '"';
							            } ?>>
							
							            <div class="list adresaciList content" style="display: none">
							                <ul class="ul-raw"></ul>
							            </div>
							            <span
							                class="help-block">Na podstawie wybranego posła, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
							        </div>
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
                            <p class="help-block text-center">Zlokalizuj się lub wskaż na mapie miejsce zamieszkania:</p>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>