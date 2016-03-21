<?
$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
?>



<div class="margin-top-0">
	
	<? 
						
		$projekty = array();
		if( @$dataBrowser['aggs']['projekty']['top']['hits']['hits'] ) 
			foreach( $dataBrowser['aggs']['projekty']['top']['hits']['hits'] as $b ) 
				if( @$b['fields']['id'][0] )
					$projekty[ $b['fields']['id'][0] ] = $b;
		
		// debug( $dataBrowser['aggs']['glosowania'] );
			
		$glosowania = array();
		if( @$dataBrowser['aggs']['glosowania']['top']['hits']['hits'] ) 
			foreach( $dataBrowser['aggs']['glosowania']['top']['hits']['hits'] as $b ) 
				if( @$b['fields']['id'][0] )
					$glosowania[ $b['fields']['id'][0] ] = $b;
											
	?>
	
    
    <? if( @$dataBrowser['aggs']['punkty']['top']['hits']['hits'] ) {?>
    
    <h1 class="smaller">Punkty porządku dziennego:</h1>
    
    <div class="block block-simple block-size-sm col-xs-12">				
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <ul class="dataobjects punkt-projekty">
                        <? 
	                        $bufor = array();
	                        foreach (@$dataBrowser['aggs']['punkty']['top']['hits']['hits'] as $doc) {
		                        
		                        $data = $doc['_source']['data'];
		                        
		                        if( !$data['sejm_posiedzenia_punkty']['numer'] ) {
		                        	$bufor = $data;
		                        	continue;
		                        }
		                        
                        ?>
                            <li>
                            	
                            	<? 
	                            	if( $data ) {
		                        ?>
                            	<div class="row punkt_header">
	                            	<div class="info">
				                        <p class="numer">
					                        <a href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>">
						                        <? if($data['sejm_posiedzenia_punkty']['numer']) { ?>
						                        Punkt #<?= $data['sejm_posiedzenia_punkty']['numer'] ?> <? } else {?>
							                    Poza punktami porządku dziennego  
						                        <?}?>
						                    </a>
						                </p>
						                <p class="tytul">
					                        <a class="link-discrete" href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>"><?= $data['sejm_posiedzenia_punkty']['tytul'] ?></a>
						                </p>
			                        </div>
                            	</div>
                            	<? } ?>
                            	
                            	<div class="row">
	                            	
	                            	<div class="col-md-6">
		                            	
		                            	<? 
			                            	if( $data = $doc['_source']['data'] ) {
				                        ?>
				                        <div class="punkt">
					                        
					                        
					                        <div class="info">
						                        <? if( $data['sejm_posiedzenia_punkty']['liczba_wystapien'] ) {?><a href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>"><img src="http://resources.sejmometr.pl/stenogramy/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>.jpg" /></a><? } ?>
						                        <p class="stats"><?= $data['sejm_posiedzenia_punkty']['stats_str_pl'] ?></p>
					                        </div>
					                        
					                        <?
					                        if( @$doc['fields']['source'][0]['static']['istotne_glosowania_ids'] ) {
						                    ?><ul class="glosowania"><?
												foreach( $doc['fields']['source'][0]['static']['istotne_glosowania_ids'] as $glosowanie_id ) {
													if( array_key_exists($glosowanie_id, $glosowania) ) {
													?><li><?
														echo $this->Dataobject->render($glosowania[$glosowanie_id], 'default', array(
					                            			'truncate' => 1000,
				                            			));
													?></li><?
													}
												}	
											?></ul><?
							                }
							                ?>
					                        
					                        
				                        </div>	
				                        <?  	
			                            	}
			                            ?>
		                            	
	                            	</div><div class="col-md-6 projekty">
		                            	
		                            	<? 
			                            				                            	
			                            	if( @$doc['fields']['source'][0]['static']['prawo_projekty'] ) {
			                            		foreach( $doc['fields']['source'][0]['static']['prawo_projekty'] as $p ) {
				                            		if( $projekt = $projekty[ $p['projekt_id'] ] ) {
					                            		
				                            			echo $this->Dataobject->render($projekt, 'default', array(
					                            			'truncate' => 1000,
				                            			));
				                            			
				                            			if( isset($p['wynik_id']) ) {
					                            		?><p class="wynik"><?
					                            			switch( $p['wynik_id'] ) {
						                            			case '1': {
										                            ?><span class="label label-success">Przyjęto</span><?	
											                        break;		
						                            			}
						                            			case '2': {
										                            ?><span class="label label-danger">Odrzucono</span><?	
											                        break;		
						                            			}
						                            			case '3': {
										                            ?><span class="label label-primary">Skierowano do dalszych prac</span><?	
											                        break;		
						                            			}
						                            			case '4': {
										                            ?><span class="label label-primary">Rozpatrzono poprawki Senatu</span><?	
											                        break;		
						                            			}
						                            			case '5': {
										                            ?><span class="label label-default">Głosowanie odbędzie się w bloku głosowań</span><?	
											                        break;		
						                            			}
						                            			case '6': {
										                            ?><span class="label label-default">Głosowanie odbędzie się na kolejnym posiedzeniu</span><?	
											                        break;		
						                            			}
					                            			}
					                            		?></p><?
				                            			}
				                            			
				                            		}
				                            	}
				                            } else {
					                            					                            
					                            ?><p class="punkt_wynik"><?= @$doc['fields']['source'][0]['data']['sejm_posiedzenia_punkty.opis'] ?></p><?
					                            
				                            }			                            		
			                            ?>
			                            	

		                            	
	                            	</div>
                            	</div>
                            	
                            </li>
                        <? } ?>
                        
                        <? if( !empty($bufor) ) {?>
                        	<li>
                            	
                            	<? 
	                            	if( $data = $bufor ) {
		                        ?>
                            	<div class="row punkt_header">
	                            	<div class="info">
				                        <p class="numer">
					                        <a href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>">
						                        <? if($data['sejm_posiedzenia_punkty']['numer']) { ?>
						                        Punkt #<?= $data['sejm_posiedzenia_punkty']['numer'] ?> <? } else {?>
							                    Poza punktami porządku dziennego  
						                        <?}?>
						                    </a>
						                </p>
						                <p class="tytul">
					                        <a class="link-discrete" href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>"><?= $data['sejm_posiedzenia_punkty']['tytul'] ?></a>
						                </p>
			                        </div>
                            	</div>
                            	<? } ?>
                            	
                            	<div class="row">
	                            	
	                            	<div class="col-md-6">
		                            	
		                            	<? 
			                            	if( $data = $doc['_source']['data'] ) {
				                        ?>
				                        <div class="punkt">
					                        
					                        
					                        <div class="info">
						                        <? if( $data['sejm_posiedzenia_punkty']['liczba_wystapien'] ) {?><a href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>"><img src="http://resources.sejmometr.pl/stenogramy/punkty/<?= $data['sejm_posiedzenia_punkty']['id'] ?>.jpg" /></a><? } ?>
						                        <p class="stats"><?= $data['sejm_posiedzenia_punkty']['stats_str_pl'] ?></p>
					                        </div>
					                        
					                        <?
					                        if( @$doc['fields']['source'][0]['static']['istotne_glosowania_ids'] ) {
						                    ?><ul class="glosowania"><?
												foreach( $doc['fields']['source'][0]['static']['istotne_glosowania_ids'] as $glosowanie_id ) {
													if( array_key_exists($glosowanie_id, $glosowania) ) {
													?><li><?
														echo $this->Dataobject->render($glosowania[$glosowanie_id], 'default', array(
					                            			'truncate' => 1000,
				                            			));
													?></li><?
													}
												}	
											?></ul><?
							                }
							                ?>
					                        
					                        
				                        </div>	
				                        <?  	
			                            	}
			                            ?>
		                            	
	                            	</div><div class="col-md-6 projekty">
		                            	
		                            	<? 
			                            				                            	
			                            	if( @$doc['fields']['source'][0]['static']['prawo_projekty'] ) {
			                            		foreach( $doc['fields']['source'][0]['static']['prawo_projekty'] as $p ) {
				                            		if( $projekt = $projekty[ $p['projekt_id'] ] ) {
					                            		
				                            			echo $this->Dataobject->render($projekt, 'default', array(
					                            			'truncate' => 1000,
				                            			));
				                            			
				                            			if( isset($p['wynik_id']) ) {
					                            		?><p class="wynik"><?
					                            			switch( $p['wynik_id'] ) {
						                            			case '1': {
										                            ?><span class="label label-success">Przyjęto</span><?	
											                        break;		
						                            			}
						                            			case '2': {
										                            ?><span class="label label-danger">Odrzucono</span><?	
											                        break;		
						                            			}
						                            			case '3': {
										                            ?><span class="label label-primary">Skierowano do dalszych prac</span><?	
											                        break;		
						                            			}
						                            			case '4': {
										                            ?><span class="label label-primary">Rozpatrzono poprawki Senatu</span><?	
											                        break;		
						                            			}
						                            			case '5': {
										                            ?><span class="label label-default">Głosowanie odbędzie się w bloku głosowań</span><?	
											                        break;		
						                            			}
						                            			case '6': {
										                            ?><span class="label label-default">Głosowanie odbędzie się na kolejnym posiedzeniu</span><?	
											                        break;		
						                            			}
					                            			}
					                            		?></p><?
				                            			}
				                            			
				                            		}
				                            	}
				                            } else {
					                            					                            
					                            ?><p class="punkt_wynik"><?= @$doc['fields']['source'][0]['data']['sejm_posiedzenia_punkty.opis'] ?></p><?
					                            
				                            }			                            		
			                            ?>
			                            	

		                            	
	                            	</div>
                            	</div>
                            	
                            </li>
                        <? } ?>
                        
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <? } ?>

</div>



