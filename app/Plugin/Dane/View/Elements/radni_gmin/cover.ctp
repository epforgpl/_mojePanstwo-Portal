<?
	
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	
	$options = array(
		'mode' => 'init',
	);
?>
<div class="col-md-8">
		
	<div class="databrowser-panels">
		
		<? if( @$dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits'] ) {?>		
		<div class="databrowser-panel">
			<h2>Najnowsze interpelacje:</h2>			
			
			<div class="aggs-init">
									
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['all']['interpelacje']['top']['hits']['hits'] as $doc ) {?>
						    <li>
							<?
								echo $this->Dataobject->render($doc, 'default');
							?>
						    </li>
						    <? } ?>
					    </ul>
					    <div class="buttons">
							<a href="<?= $radny->getUrl() ?>/interpelacje" class="btn btn-primary btn-sm">Zobacz więcej</a>
						</div>
					    <? } ?>
					    
					</div>
				</div>
										
			</div>
		</div>
		<? } ?>
				
		<? if( @$dataBrowser['aggs']['all']['komisje']['komisje']['top']['hits']['hits'] ) {?>		
		<div class="databrowser-panel">
			<h2>Komisje, w których zasiada radny:</h2>			
			
			<div class="aggs-init">
									
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <? if( $dataBrowser['aggs']['all']['komisje']['komisje']['top']['hits']['hits'] ) {?>
					    <ul class="dataobjects">
						    <? foreach( $dataBrowser['aggs']['all']['komisje']['komisje']['top']['hits']['hits'] as $doc ) {?>
						    <li>
								<div class="objectRender readed docdataobject objclass">
	
								    <div class="row">
								
								        <div class="data col-xs-12">
								
								            
								            <div>
								
								                
								                                    <div class="content">
								
								                        						
														<i class="object-icon glyphicon glyphicon-file"></i>						
														<div class="object-icon-side ">
														
								                                                   
								                        
								                        <p class="title">
								                                                        <a href="/dane/gminy/903/komisje/<?= $doc['fields']['komisja_id'][0] ?>"><?= $doc['fields']['komisja_nazwa'][0] ?>						                                                                                                                            </a>                         </p>
								                        
								                                                <p class="meta meta-desc"><?= $doc['fields']['stanowisko_nazwa'][0] ?></p>
								                                                
								                        
								                                                
														</div>
								
								                    </div>
								                            </div>
								        </div>
								    </div>
								</div>						    
						    							
						    </li>
						    <? } ?>
					    </ul>
					    <? } ?>
					    
					</div>
				</div>
										
			</div>
		</div>
		<? } ?>
			
			
		
		<? if (isset($osoba) && ($organizacje = $osoba->getLayer('organizacje'))) { ?>
		<div class="databrowser-panel">
			<h2>Powiązania w KRS:</h2>			
			
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <ul class="dataobjects">
						    <? foreach ($organizacje as $organizacja) { 
							    $kapitalZakladowy = (float) $organizacja['kapital_zakladowy'];
						    ?>
						    <li>
							<?
								
								$organizacja['firma'] = $organizacja['nazwa'];
								$role = $organizacja['role'];
								unset( $organizacja['role'] );
								
								$doc = array(
									'fields' => array(
										'dataset' => array(
											'krs_podmioty'
										),
										'source' => array(
											array(
												'data' => $organizacja,
											),
										),
										'id' => array(
											array(
												$organizacja['id'],
											),
										),
									),
									'_id' => false,
									
								);
								
								
								echo $this->Dataobject->render($doc, 'default');
							?>
							
							<? if ($role) { ?>
		                    <ul class="list-group less-borders role">
		                        <? foreach ($role as $rola) {
		                            ?>
		                            <li class="list-group-item">
		                                <p><span
		                                        class="label label-primary"><?= $rola['label'] ?></span> <? if (isset($rola['params']['subtitle']) && $rola['params']['subtitle']) { ?>
		                                        <span
		                                            class="sublabel normalizeText"><?= $rola['params']['subtitle'] ?></span><? } ?>
		                                </p>
		                            </li>
		                        <?
		                        }
		                        ?>
		                    </ul>
		                    <? } ?>
							
						    </li>
						    <? } ?>
					    </ul>
					</div>
				</div>
						
			</div>
			
		</div>	
		<? } ?>
		
	</div>

</div>