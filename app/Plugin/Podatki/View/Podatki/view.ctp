<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highcharts-more');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js', 'Podatki.podatki.js');
?>


<form method="post">

	<div class="container">
		<div id="podatki">
		    <div class="appBanner">
		        <h1 class="appTitle"><?= __d('podatki', 'LC_PODATKI_HEADLINE'); ?></h1>
		
		        <p class="appSubtitle"><?= __d('podatki', 'LC_PODATKI_SUBHEADLINE'); ?></p>
		    </div>
		
		        
		 
		        
		    <div class="sections">
		        <div class="section">
			        <div class="row" data-number="<?= (isset($post['umowa_o_prace'])) ? count($post['umowa_o_prace']) : 1 ?>">
				        
				        <div class="col-xs-5 text-right">
					        
					        <label for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?>:</label>
					        
				        </div><div class="col-xs-2 text-center nopadding">
					        
					        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
			                   name="umowa_o_prace[]"
			                   title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
			                   id="przychody_umowa_o_prace_1"
			                   value="<?= @$post['umowa_o_prace'][0]; ?>">
			                   				        
				        </div><div class="col-xs-3 button_container">
					        
					        <a href="#" class="btn btn-link btn-xs" data-type="przychody_umowa_o_prace">
		                        <i class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
		                    </a>
					        
				        </div>
		
			        </div>
		        </div>
		        
		        <div class="section">
			        <div class="row" data-number="<?= (isset($post['umowa_o_prace'])) ? count($post['umowa_o_prace']) : 1 ?>">
				        
				        <div class="col-xs-5 text-right">
					        
					        <label for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?>:</label>
					        
				        </div><div class="col-xs-2 text-center nopadding">
					        
					        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
			                   name="umowa_o_prace[]"
			                   title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
			                   id="przychody_umowa_o_prace_1"
			                   value="<?= @$post['umowa_o_prace'][0]; ?>">
			                   				        
				        </div><div class="col-xs-3 button_container">
					        
					        <a href="#" class="btn btn-link btn-xs" data-type="przychody_umowa_o_prace">
		                        <i class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
		                    </a>
					        
				        </div>
		
			        </div>
		        </div>
		        
		        <div class="section">
			        <div class="row" data-number="<?= (isset($post['umowa_o_prace'])) ? count($post['umowa_o_prace']) : 1 ?>">
				        
				        <div class="col-xs-5 text-right">
					        
					        <label for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?>:</label>
					        
				        </div><div class="col-xs-2 text-center nopadding">
					        
					        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
			                   name="umowa_o_prace[]"
			                   title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
			                   id="przychody_umowa_o_prace_1"
			                   value="<?= @$post['umowa_o_prace'][0]; ?>">
			                   				        
				        </div><div class="col-xs-3 button_container">
					        
					        <a href="#" class="btn btn-link btn-xs" data-type="przychody_umowa_o_prace">
		                        <i class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
		                    </a>
					        
				        </div>
		
			        </div>
		        </div>
		        
		    </div>
		        
		        <p class="text-center">
			        
			        <a href="#">Prowadzisz jednosobową działalność gospodarczą?</a>
			        
		        </p>
		        
		        
		        
		        
		</div>
	</div>
	
	<div class="main_button_container text-center">
		<button class="btn btn-success btn-lg btn-icon" type="submit"><i
                class="icon glyphicon glyphicon-refresh"></i>Oblicz 
        </button>
	</div>
	

	<div class="stripe" style="display: none;">
		<div class="container">
										
			<h2>Miesięcznie odprowadzasz do budżetu państwa 1234,56 zł</h2>
			<div class="row chart_area">
				<div class="col-xs-6">
					Piechart wyrównany do prawej
				</div><div class="col-xs-6">
					Legenda do piecharta wyrównana do lewej
				</div>
			</div>
			
			
			<h2>Twoje podatki zostały wydawane na:</h2>
			
			Tu jedziemy z kafelkami
			
		</div>
	</div>

</form>
