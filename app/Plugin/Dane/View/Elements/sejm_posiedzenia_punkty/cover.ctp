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
						
			<? if( $druki = $dataBrowser['aggs']['druki']['top']['hits']['hits'] ) {?>
		    <div class="block">
		        <header>Rozpatrywane druki</header>
				
		        <section class="aggs-init nopadding">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <ul class="dataobjects punkt-projekty">
		                    <? foreach( $druki as $druk ) {?>
		                    	<li class="">
			                    	<?= $this->Dataobject->render($druk, 'default'); ?>
			                    </li>
		                    <? } ?>
		                    </ul>
		                </div>
		            </div>
		        </section>
		    </div>
		    <? } ?>
			
		    
    
	    </div>
    </div>
        
</div>