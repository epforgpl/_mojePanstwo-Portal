<?php
$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Start.letters.js');
$this->Combinator->add_libs('js', 'Start.letters-edit.js');

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>
<?
/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));
echo $this->Html->script('/pickadate.js/lib/compressed/picker.js', array('block' => 'scriptBlock'));
echo $this->Html->script('/pickadate.js/lib/compressed/picker.date.js', array('block' => 'scriptBlock'));
echo $this->Html->script('/pickadate.js/lib/compressed/picker.time.js', array('block' => 'scriptBlock'));
echo $this->Html->script('/pickadate.js/lib/compressed/translations/pl_PL.js', array('block' => 'scriptBlock'));
?>

<link rel="stylesheet" href="/pickadate.js/lib/themes/default.css">
<link rel="stylesheet" href="/pickadate.js/lib/themes/default.date.css">

<div class="app-content-wrap">
    <div class="objectsPage">

        <?= $this->element('letters/header') ?>

        <?= $this->element('letters/menu', array(
            'plugin' => 'Start',
            'active' => 'edit',
        )); ?>
		
		<form action="/moje-pisma/<?= $pismo['id'] ?>,<?= $pismo['slug'] ?>" method="post" class="form-horizontal form-letter">
		
	        <div class="container">
	
	            <div class="row">
	                <div class="col-md-9 margin-top-15">
	
	                    <? if (@$pismo['_template'][0]['opis']) { ?>
	                        <div class="alert alert-info margin-top-15 margin-sides-20">
	
	                            <?= $pismo['_template'][0]['opis'] ?>
	
	                        </div>
	                    <? } ?>
		
	                    <div class="bs-component mp-form nobg mp-form-letter">
	                        
	                        <input type="hidden" name="edit_from_inputs" value="1"/>
	                        <fieldset>
	                            
	                            <? if (@$pismo['_template'][0]['podstawa_prawna']) { ?>
			                        <div class="form-group form-row">
				                        
				                        <label class="col-lg-12 control-label control-label-full">Do Twojego pisma zostanie dołączona następująca podstawa prawna:</label>
				                        
				                        <div class="col-lg-12">
			                                <section class="content">
			                                    <div><?= $pismo['_template'][0]['podstawa_prawna'] ?></div>
			                                </section>
				                        </div>
	                                
			                        </div>
			                    <? } ?>
	                            
	                            
	                            <?
	                            if ($pismo['_inputs']) {
	                                if ($inputs = $pismo['_inputs']) {
	                                    foreach ($inputs as $input) {
	
	                                        $full = true;
	                                        $v = '';
	                                        if ($input['value'])
	                                            $v = $input['value'];
	                                        elseif ($input['default_value']) {
	
	                                            $v = $input['default_value'];
	
	                                            if (
	                                                $v &&
	                                                ($v[0] == '$') &&
	                                                preg_match('/^\$session\[(.*?)\]$/i', $v, $match)
	                                            )
	                                                $v = $this->Session->read($match[1]);
	
	                                        }
	
	                                        if ($input['type'] == 'richtext') {
	                                            ?>
	                                            <div class="form-group form-row">
	                                                <? if ($input['label']) { ?><label for="inp<?= $input['id'] ?>"
	                                                                                   class="col-lg-12 control-label control-label-full"><?= $input['label'] ?></label><? } ?>
	                                                <div class="col-lg-12">
					                        <textarea class="form-control tinymceField" rows="20"
	                                                  id="inp<?= $input['id'] ?>"
	                                                  name="inp<?= $input['id'] ?>"><?= $v ?></textarea>
	                                                    <? if (@$input['desc']) { ?><span
	                                                        class="help-block"><?= $input['desc'] ?></span><? } ?>
	                                                </div>
	                                            </div>
	                                            <?
	                                        } elseif ($input['type'] == 'text') {
	                                            ?>
	                                            <div class="form-group form-row">
	                                                <? if ($input['label']) { ?><label for="inp<?= $input['id'] ?>"
	                                                                                   class="<? if ($full) { ?>col-lg-12 control-label-full<? } else { ?>col-lg-2 control-label<? } ?>"><?= $input['label'] ?></label><? } ?>
	                                                <div
	                                                    class="<? if ($full) { ?>col-lg-12<? } else { ?>col-lg-10<? } ?>">
	                                                    <input value="<?= $v ?>" type="text" class="form-control"
	                                                           id="inp<?= $input['id'] ?>"
	                                                           name="inp<?= $input['id'] ?>"<? if (@$input['placeholder']) { ?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
	                                                    <? if (@$input['desc']) { ?><span
	                                                        class="help-block"><?= $input['desc'] ?></span><? } ?>
	                                                </div>
	                                            </div>
	                                            <?
	                                        } elseif ($input['type'] == 'date') {
	                                            ?>
	                                            <div class="form-group form-row">
	                                                <label for="inp<?= $input['id'] ?>"
	                                                       class="<? if ($full) { ?>col-lg-12 control-label-full<? } else { ?>col-lg-2 control-label<? } ?>"><?= $input['label'] ?></label>
	                                                <div
	                                                    class="<? if ($full) { ?>col-lg-12<? } else { ?>col-lg-10<? } ?>">
	                                                    <input value="<?= $v ?>" style="max-width: 130px;"
	                                                           maxlength="10" type="text" class="form-control"
	                                                           id="inp<?= $input['id'] ?>"
	                                                           name="inp<?= $input['id'] ?>"<? if (@$input['placeholder']) { ?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
	                                                    <? if (@$input['desc']) { ?><span
	                                                        class="help-block"><?= $input['desc'] ?></span><? } ?>
	                                                </div>
	                                            </div>
	                                            <?
	                                        } elseif ($input['type'] == 'email') {
	                                            ?>
	                                            <div class="form-group form-row">
	                                                <label for="inp<?= $input['id'] ?>"
	                                                       class="<? if ($full) { ?>col-lg-12 control-label-full<?
	                                                       } else { ?>col-lg-2 control-label<?
	                                                       } ?>"><?= $input['label'] ?></label>
	                                                <div class="<? if ($full) { ?>col-lg-12<?
	                                                } else { ?>col-lg-10<?
	                                                } ?>">
	                                                    <input value="<?= $v ?>" type="text" class="form-control"
	                                                           id="inp<?= $input['id'] ?>"
	                                                           name="inp<?= $input['id'] ?>"<? if (@$input['placeholder']) { ?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
	                                                    <? if (@$input['desc']) { ?><span
	                                                        class="help-block"><?= $input['desc'] ?></span><? } ?>
	                                                </div>
	                                            </div>
	                                            <?
	                                        }
	
	                                    }
	                                }
	                            } else {
	
	                                $full = true;
	                                $v = '';
	
	                                ?>
	
	                                <div class="form-group form-row">
	                                    <label for="inp0" class="<? if ($full) { ?>col-lg-12 control-label-full<?
	                                    } else { ?>col-lg-2 control-label<?
	                                    } ?>">Treść pisma</label>
	                                    <div class="<? if ($full) { ?>col-lg-12<?
	                                    } else { ?>col-lg-10<?
	                                    } ?>">
	                                        <textarea class="form-control tinymceField" rows="10" id="inp0"
	                                                  name="inp0"><?= $v ?></textarea>
	                                    </div>
	                                </div>
	
	                                <?
	                            }
	                            ?>
	                            
	                        </fieldset>
	                            
	                        
	                    </div>
	                    
	                </div><div class="col-md-3">
	
	
	                    <?= $this->element('letters/side', array('plugin' => 'Start',)); ?>
	
	
	                </div>
	                
	            </div>
	            
	        </div>
	        
	        <? // debug($pismo); ?>
	        
	            
	        <div class="meta-fields">
		        <div class="meta-fields-inner">
		      	
			        <div class="container">
			            <div class="row">
				            <div class="col-md-9">
					            
					            <div class="bs-component mp-form nobg mp-form-letter">
					            			            
						            <fieldset>    
										
										<h2>Dodatkowe informacje o piśmie:</h2>
																				
										<div class="row">
											<div class="col-md-6">
												
												<div class="form-group form-row">
													<label for="from_str" class="col-lg-12 control-label control-label-full">Miejsce</label>
													<div class="col-lg-12">
														<input placeholder="Nazwa miejscowości, w której piszez pismo" class="form-control" id="from_str" name="miejscowosc" value="<?= $pismo['miejscowosc'] ?>" />
													</div>
												</div>
												
											</div><div class="col-md-6">
												
												<div class="form-group form-row">
													<label for="signature" class="col-lg-12 control-label control-label-full">Data</label>
													<div class="col-lg-12">
														<? /*<p class="input-fake form-control">15 maja 2015</p>*/ ?>
														<input placeholder="Data napisania pisma" name="data_pisma" data-value="<?= $pismo['data_pisma'] ?>" class="form-control" id="letter-date" />
													</div>
												</div>
												
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												
												<div class="form-group form-row">
													<label for="from_str" class="col-lg-12 control-label control-label-full">Twoje dane</label>
													<div class="col-lg-12">
														<textarea class="form-control" rows="4" id="from_str" name="nadawca"><?= $pismo['nadawca'] ?></textarea>
													</div>
												</div>
												
											</div><div class="col-md-6">
												
												<div class="form-group form-row">
													<label for="signature" class="col-lg-12 control-label control-label-full">Twój podpis</label>
													<div class="col-lg-12">
														<textarea class="form-control" rows="4" id="signature" name="podpis"><?= $pismo['podpis'] ?></textarea>
													</div>
												</div>
												
											</div>
										</div>
																		
										
			                            
			                            
			                            
			 
			                            
			                        </fieldset>
			                        
					            </div>
		
		                    </div>
		
		
		                </div>
		                
		            </div>
	            
		        </div>
	
	
	        </div>
	        
	        <div class="container">
				
				
		            <div class="row">
		                <div class="col-md-9">
			                
			                <div class="bs-component mp-form nobg mp-form-letter text-center margin-top-30 margin-bottom-30">
			                
		                        <? if ($pismo['saved']) { ?>
		                            <? /*<a href="/moje-pisma/<?= $pismo['id'] ?>,<?= $pismo['slug'] ?>"
		                               class="btn btn-md btn-default">Anuluj</a>
	                               */ ?>
		                            <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
		                                    class="icon icon-applications-pisma"></i>Zapisz pismo
		                            </button>
		                        <? } else { ?>
		                            <button type="submit" class="createBtn btn btn-md btn-success btn-icon"><i
		                                    class="icon icon-applications-pisma"></i>Zapisz i zobacz podgląd
		                                pisma
		                            </button>
		                        <? } ?>
	                        
			                </div>
			                
		                </div>
		            </div>
		            
	            
	        </div>
        
		</form>
        
    </div>
</div>
