<?
	
	$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	
	$options = array(
		'mode' => 'init',
	);
	
	debug( $dataBrowser['aggs'] );
	
?>
<div class="col-md-8">
		
	<div class="databrowser-panels">
		
		
		<div class="databrowser-panel">
			<h2>Najnowsze akty prawne:</h2>			
			
			<div class="aggs-init">
									
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['all']['prawo']['top']['hits']['hits'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['all']['prawo']['top']['hits']['hits'] as $doc ) {?>
						    <li>
							<?
								echo $this->Dataobject->render($doc, 'default');
							?>
						    </li>
						    <? } ?>
					    </ul>
					    <div class="buttons">
							<a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
						</div>
					    <? } ?>
					    
					</div>
				</div>
				
				
						
			</div>
		</div>
		
		
		
		<div class="databrowser-panel">
			<h2>Najnowsze zamówienia publiczne:</h2>			
			
			<div class="aggs-init">
									
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['all']['zamowienia']['top']['hits']['hits'] as $doc ) {?>
						    <li>
							<?
								echo $this->Dataobject->render($doc, 'default');
							?>
						    </li>
						    <? } ?>
					    </ul>
					    <div class="buttons">
							<a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
						</div>
					    <? } ?>
					    
					</div>
				</div>
				
				
						
			</div>
		</div>
			
			
		<div class="databrowser-panel">
			<h2>Najwięcej zamówień publicznych otrzymali:</h2>
			
			<div class="aggs-init">
				
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    						    
					    <ul class="wykonawcy">
						    <?
						    	foreach( $dataBrowser['aggs']['all']['dokumenty']['wykonawcy']['id']['buckets'] as $doc ) {
																		
									$wykonawca = array(
										'id' => $doc['key'],
										'nazwa' => $doc['nazwa']['buckets'][0]['key'],
										'cena' => $doc['cena']['value'],
									);
						    ?>
						    <li>
						    							    	
						    	<h2 class="smaller">
							    	<a class="nazwa pull-left" href="#"><?= $this->Text->truncate($wykonawca['nazwa'], 70) ?></a>
							    	<span class="cena pull-right"><?= number_format_h($wykonawca['cena']) ?> PLN</span>
						    	</h2>
						    	
						    	<p class="stats"><?= pl_dopelniacz($doc['dokumenty']['doc_count'], 'zamówienie', 'zamówienia', 'zamówień') ?></p>
						    	
						    	<div style="display: none;">
							    	<ul class="dataobjects smaller">
								    <?
									    foreach( $doc['dokumenty']['top']['hits']['hits'] as $hit ) {
										    
										    $czesc = false;
										    
										    if(
										    	isset( $hit['fields']['source'][0]['static']['wykonawcy'] ) && 
										    	$hit['fields']['source'][0]['static']['wykonawcy']
										    ) {
											    foreach( $hit['fields']['source'][0]['static']['wykonawcy'] as $w )
												    if( $w['id'] == $wykonawca['id'] )
												    	$czesc = $w;
										    }
										    
										    echo $this->Dataobject->render($hit, 'zamowienia_publiczne_dokumenty', array(
											    'czesc' => $czesc,
										    ));
									    }
									?>							    
							    	</ul>
							    	
							    	<? if( $doc['dokumenty']['doc_count']>5 ) {?>
							    	<div class="buttons">
								    	<a href="#" class="btn btn-primary btn-sm">Więcej</a>
							    	</div>
							    	<? } ?>
						    	</div>
	
						    </li>
						    <? } ?>
					    </ul>
					    <div class="buttons">
							<a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
						</div>
					</div>
				</div>
						
			</div>
		</div>
		
	</div>

</div>