<?
$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
?>

<div class="col-md-12">

	<? 
		
		// debug( $dataBrowser['aggs']['debaty']['top']['hits']['hits'] );
		$static = $punkt->getStatic();
					
		$projekty = array();
		if( @$dataBrowser['aggs']['projekty']['top']['hits']['hits'] ) 
			foreach( $dataBrowser['aggs']['projekty']['top']['hits']['hits'] as $b ) 
				if( @$b['fields']['id'][0] )
					$projekty[ $b['fields']['id'][0] ] = $b;
					
										
		$glosowania = array();
		if( @$dataBrowser['aggs']['glosowania']['top']['hits']['hits'] ) 
			foreach( $dataBrowser['aggs']['glosowania']['top']['hits']['hits'] as $b ) 
				if( @$b['fields']['id'][0] )
					$glosowania[ $b['fields']['id'][0] ] = $b;
											
	?>
	
    
    <div class="row margin-top-10">
	    <div class="col-md-6">
    
		    
		    
		    <? if( $dataBrowser['aggs']['debaty']['top']['hits']['hits'] ) {?>
		    <div class="block">
		        <header>Debaty w tym punkcie</header>
				
		        <section class="aggs-init">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <ul class="dataobjects">
		                        <? 
			                        foreach ($dataBrowser['aggs']['debaty']['top']['hits']['hits'] as $debata) {
				                        $data = $debata['_source']['data'];
		                        ?>
		                            <li class="punkt">
				                        <div class="info">
					                        <? if( $data['sejm_debaty']['liczba_wystapien'] ) {?><a href="/dane/instytucje/3214,sejm/debaty/<?= $data['sejm_debaty']['id'] ?>"><img src="http://resources.sejmometr.pl/stenogramy/subpunkty/<?= $data['sejm_debaty']['id'] ?>.jpg" /></a><? } ?>
					                        <p class="numer"><a href="/dane/instytucje/3214,sejm/debaty/<?= $data['sejm_debaty']['id'] ?>">Debata #<?= $data['sejm_debaty']['punkt_i'] ?></a></p>
					                        <p class="stats"><?= $data['sejm_debaty']['stats_str'] ?></p>
				                        </div>
		                            </li>
		                        <? 
			                        } 
			                    ?>
		                    </ul>
		                </div>
		            </div>
		        </section>
		    </div>
		    <? } ?>
		    
		    
		    <? if( isset($static['istotne_glosowania_ids']) && !empty($static['istotne_glosowania_ids']) ) {?>
		    <div class="block">
		        <header>Ważne głosowania</header>
				
		        <section class="aggs-init">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <ul class="dataobjects punkt-projekty">
		                        <? 
			                        foreach ($static['istotne_glosowania_ids'] as $p) { 
			                        	if( $glosowanie = $glosowania[$p] ) {
		                        ?>
		                            <li>
			                        <?	
										echo $this->Dataobject->render($glosowanie, 'default', array(
		                        			'truncate' => 1000,
		                    			));
			                        ?>
		                            </li>
		                        <? 
			                    		}
			                        } 
			                    ?>
		                    </ul>
		                </div>
		            </div>
		        </section>
		    </div>
		    <? } ?>
    
	    </div>
	    
	    <div class="col-md-6">
			
			<? debug($dataBrowser['aggs']['druki']); ?>
			
			<? if( isset($static['prawo_projekty']) && !empty($static['prawo_projekty']) ) {?>
		    <div class="block">
		        <header>Rozpatrywane druki</header>
				
		        <section class="aggs-init">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <ul class="dataobjects punkt-projekty">
		                        <? 
			                        foreach ($static['prawo_projekty'] as $p) { 
			                        	if( $projekt = $projekty[$p['projekt_id']] ) {
		                        ?>
		                            <li>
			                        <?	
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
			                        ?>
		                            </li>
		                        <? 
			                    		}
			                        } 
			                    ?>
		                    </ul>
		                </div>
		            </div>
		        </section>
		    </div>
		    <? } ?>
			
		    
    
	    </div>
    </div>
        
</div>