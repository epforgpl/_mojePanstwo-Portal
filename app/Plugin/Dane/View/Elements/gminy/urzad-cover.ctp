<?
	
	$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	
	$options = array(
		'mode' => 'init',
	);
?>
<div class="col-md-8">
	<div class="databrowser-panels">
		
		<? if( $object->getId()==903 ) { ?>
		
			<div class="databrowser-panel">
				<h2>Najnowsze zarządzenia Prezydenta:</h2>			
				
				<div class="aggs-init">
										
					<div class="dataAggs">
						<div class="agg agg-Dataobjects">
						    <? if( $dataBrowser['aggs']['all']['zarzadzenia']['top']['hits']['hits'] ) {?>
						    <ul class="dataobjects">
							    <? foreach( $dataBrowser['aggs']['all']['zarzadzenia']['top']['hits']['hits'] as $doc ) {?>
							    <li>
								<?
									echo $this->Dataobject->render($doc, 'default');
								?>
							    </li>
							    <? } ?>
						    </ul>
						    <div class="buttons">
								<a href="<?= $object->getUrl() ?>/zarzadzenia" class="btn btn-primary btn-sm">Zobacz więcej</a>
							</div>
						    <? } ?>
						    
						</div>
					</div>
					
					
							
				</div>
			</div>
		
		<? } ?>
		
		
	</div>

</div>