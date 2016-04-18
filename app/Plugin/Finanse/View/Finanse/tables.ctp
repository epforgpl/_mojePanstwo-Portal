<?
	echo $this->Html->css($this->Less->css('app'));
	$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('tables', array('plugin' => 'Finanse')));
	$this->Combinator->add_libs('js', 'Finanse.tables.js');
	
	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">
		        
		<div class="dataBrowser upper margin-top-0">
		        <div class="dataBrowserContent">

					<div id="tablesBrowser" class="col-xs-12">
					
					    <div class="appBanner">
					
					        <h1 class="appTitle">Finanse publiczne</h1>
					        <p class="appSubtitle"><?= $subtitle ?></p>
							
					    </div>
						
						<?= $this->element('Finanse.tables', $tables); ?>
						
					</div>				
					
		        </div>
		</div>
		
    </div>
</div>