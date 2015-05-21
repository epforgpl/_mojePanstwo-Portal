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
			<h2>Radni rady miasta Kraków:</h2>			
			
			<div class="aggs-init">
									
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['all']['radni']['top']['hits']['hits'] ) {?>
					    <ul class="dataobjects row">
						    <? foreach( $dataBrowser['aggs']['all']['radni']['top']['hits']['hits'] as $doc ) {?>
						    <li class="col-md-6">
							<?
								echo $this->Dataobject->render($doc, 'krakow_radni');
							?>
						    </li>
						    <? } ?>
					    </ul>
					    <? } ?>
					    
					</div>
				</div>
				
				
						
			</div>
		</div>
		
		<? } ?>

	</div>

</div>