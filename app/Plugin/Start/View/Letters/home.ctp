<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('js', 'Start.letters.js') ?>

<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>



<div class="app-content-wrap">
    <div class="objectsPage">		
		<div class="container">
			
			<div class="overflow-auto">
				<h1 class="pull-left">Tworzenie nowego pisma</h1>
			</div>
			
		
			<div class="app-banner banner-letter">
				<p>Dzięki tej usłudze, łatwo stworzysz i wyślesz pismo do urzędu lub instytucji. Wybierz szablon w zależności od sprawy, którą chcesz załatwić. Znajdź i wybierz adresata, aby automatycznie uzupełnić dane teleadresowe pisma.</p>
			</div>
		
			
			<? if (!$this->Session->read('Auth.User.id')) { ?>
			    <div class="col-xs-12 nopadding">
			        <div class="alert-identity alert alert-dismissable alert-info">
			            <button type="button" class="close" data-dismiss="alert">×</button>			
			            <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
			                    class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
			                swoim koncie.</p>
			        </div>
			    </div>
			<? } ?>
			
			<div class="row">
				<div class="col-md-12">
					<div class="bs-component mp-form nopadding">
					    <form action="/moje-pisma" method="post" class="form-horizontal">
					        <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
					            echo ' value="' . $pismo['adresat_id'] . '"';
					        } ?>>
					        <fieldset>
								
								<div class="row">
									<div class="col-md-6">
								
										<div id="block-szablony" class="block block-szablony">
											<header>Wybierz szablon pisma:</header>
											<section class="content" style="padding-bottom: 0;">
										
									            <div class="radio">
							                        <input name="szablon_id" value="0" checked="" type="radio" id="brak">
							                        <label for="brak">Brak szablonu</label>
							                    </div>
							                    <div class="radio">
							                        <input id="wniosek_35" name="szablon_id" value="35"
							                               type="radio"<?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] == 35) {
							                            echo ' checked';
							                        } ?>>
							                        <label for="wniosek_35">Wniosek o udostępnienie informacji publicznej</label>
							                    </div>
							                    <div class="radio">
							                        <input id="wniosek_40" name="szablon_id" value="40"
							                               type="radio"<?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] == 40) {
							                            echo ' checked';
							                        } ?>>
							                        <label for="wniosek_40">Skarga na bezczynność organu</label>
							                    </div>
							                    <div class="radio">
							                        <input id="wniosek_82" name="szablon_id" value="82"
							                               type="radio"<?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] == 82) {
							                            echo ' checked';
							                        } ?>>
							                        <label for="wniosek_82">Petycja</label>
							                    </div>
							                    <?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] != 35 && $pismo['szablon_id'] != 40) { ?>
							                        <div class="radio">
							                            <input id="wniosek_<?php echo $pismo['szablon_id'] ?>" name="szablon_id"
							                                   value="<?php echo $pismo['szablon_id'] ?>" type="radio" checked="checked">
							                            <label
							                                for="wniosek_<?php echo $pismo['szablon_id'] ?>"><?php echo $pismo['nazwa'] ?></label>
							                        </div>
							                    <?php }; ?>
													
												<div class="wiecej_szablonow">
																			            
										            <ul id="tabs-szablony" class="nav nav-tabs">
											        <? foreach( $szablony as $i => $grupa ) { ?>
														<li role="presentation"><a href="#<?= $grupa['id'] ?>"><span class="glyphicon glyphicon-menu-down"></span> <?= $grupa['nazwa'] ?></a></li>
													<? } ?>
													</ul>
													
													<div id="tabContent" class="tab-content">
													<? foreach( $szablony as $i => $grupa ) { ?>
														<div role="tabpanel" class="tab-pane fade in out" id="<?= $grupa['id'] ?>">
															
														<? foreach( $grupa['templates'] as $szablon ) {?>
															<div class="radio">
										                        <input id="tab_wniosek_<?= $szablon['id'] ?>" name="szablon_id" value="<?= $szablon['id'] ?>"
										                               type="radio"<?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] == $szablon['id']) {
										                            echo ' checked';
										                        } ?>>
										                        <label for="tab_wniosek_<?= $szablon['id'] ?>"><?= $szablon['nazwa'] ?></label>
										                        <p class="opis"><?= $szablon['opis'] ?></p>
										                    </div>
										                <? } ?>
															
														</div>
													<? } ?>
													</div>
									            
												</div>
									            
											</section>
										</div>
							            
									</div><div class="col-md-6">
							    
							    
									    <div id="block-adresat" class="block block-adresat">
											<header>Wybierz adresata pisma:</header>
											<section class="content">
												
												
												<div class="row">
													<div class="col-md-12">
														
														<div class="suggesterBlockPisma">
									                        <?= $this->element('Start.letters-searcher', array('q' => '', 'dataset' => 'pisma_adresaci', 'placeholder' => 'Zacznij pisać aby znaleźć adresata...')) ?>
									                    </div>
														
													</div>
												</div>
												
												
												<span class="help-block">Na podstawie wybranego adresata, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
									            
											
												
									            
											</section>
									    </div>
							            
							            
							            
							            
							            
							            
							            
							            
							            
									</div>
								</div>
					            
					            
					            <? if(isset($objects)) { ?>
					                <div class="block block-simple nobg text-center">
						                <header>Stwórz pismo jako:</header>
						                <section class="content margin-bottom-10">
							                
							                <div class="row">
								                <div class="col-md-6 col-md-offset-3">
									                <select class="form-control" name="object_id">
							                            <option value="0">
							                                <?= AuthComponent::user('username') ?>
							                            </option>
							                            <? if (isset($objects)) {
							                                foreach ($objects as $obj) { ?>
							                                    <option value="<?= $obj['objects']['id'] ?>">
							                                        <?= $obj['objects']['slug'] ?>
							                                    </option>
							                                <? }
							                            } ?>
							                        </select>
								                </div>
							                </div>
							                
						                </section>
					                </div>					                
					            <? } ?>
					            
					            <div class="block block-simple nobg">
						            						            
						            <div class="form-group form-row margin-top-0 margin-bottom-20">
						                <div class="text-center">
						                    <button type="submit" class="createBtn btn btn-lg btn-primary btn-icon"><i
						                            class="icon glyphicon glyphicon-pencil"></i>Stwórz pismo
						                    </button>
						                </div>
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