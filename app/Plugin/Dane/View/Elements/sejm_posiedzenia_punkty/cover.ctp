<?
$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.sejm-posiedzenie');
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
		        <header>Debaty w tym punkcie:</header>
				
		        <section class="aggs-init nopadding">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <ul class="dataobjects debaty">
		                        <? 
			                        foreach ($dataBrowser['aggs']['debaty']['top']['hits']['hits'] as $doc) {
		                        ?>
		                            <li><?= $this->Dataobject->render($doc, 'sejm_posiedzenia_punkty/debata'); ?></li>
		                        <? } ?>
		                    </ul>
		                </div>
		            </div>
		        </section>
		    </div>
		    <? } ?>
		    
		    
		    <? if( $glosowania = $dataBrowser['aggs']['glosowania']['top']['hits']['hits'] ) {?>
		    <div class="block">
		        <header>Głosowania:</header>
				
		        <section class="aggs-init">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects" id="glosowania">
		                    <ul class="dataobjects punkt-projekty margin-top--20">
		                        <? 
			                        $hidden = false;
			                        foreach ($glosowania as $doc) {  
		                        ?>
		                            <li class="gls <? if( $doc['_source']['data']['sejm_glosowania_typy']['istotne'] ) { ?>istotne<? } else { $hidden = true; ?>mniej_istotne hidden<? } ?>">
			                        <?	
										echo $this->Dataobject->render($doc, 'default', array(
		                        			'truncate' => 185,
		                    			));
			                        ?>
		                            </li>
		                        <? }  ?>
		                    </ul>
		                    
		                    <? if($hidden) {?>
		                    <div class="btns">
			                    <p class="btn-more"><a href="#">Zobacz wszystkie głosowania &darr;</a></p>
			                    <p class="btn-less" style="display: none;"><a href="#">Zobacz tylko najważniejsze głosowania &uarr;</a></p>
		                    </div>
		                    <? } ?>
		                    
		                </div>
		            </div>
		            
		            
                    
		        </section>
		    </div>
		    <? } ?>
    
	    </div>
	    
	    <div class="col-md-6">
						
			<? if( $druki = $dataBrowser['aggs']['druki']['top']['hits']['hits'] ) {?>
		    <div class="block">
		        <header>Rozpatrywane druki:</header>
				
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