<?
	$this->Combinator->add_libs('css', $this->Less->css('cover', array('plugin' => 'Dane')));
?>
<div class="col-md-8">
		
	<div class="databrowser-panels">
				
		<div class="databrowser-panel">
			<h2>Aplikacje</h2>
			
			<div class="apps row">
	            
	            <? foreach($_applications as $a) { if( $a['tag']==1 ) { ?>    
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-3" href="<?= $a['href'] ?>">
                    <i class="icon" data-icon-applications="<?= $a['icon'] ?>"></i>
			        <p><?= $a['name'] ?></p>
			    </a>
			    <? } } ?>
			    			                    
			</div>
		</div>
		
		<div class="databrowser-panel">
			<h2>Raporty</h2>
			
			<div class="apps row">
	            
	            <? foreach($_applications as $a) { if( $a['tag']==2 ) { ?>    
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-3" href="<?= $a['href'] ?>">
                    <i class="icon" data-icon-applications="<?= $a['icon'] ?>"></i>
			
			        <p><?= $a['name'] ?></p>
			    </a>
			    <? } } ?>
			    			                    
			</div>
		</div>
	
	</div>

</div>