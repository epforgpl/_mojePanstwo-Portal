<?
$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Dane.sejm-posiedzenie.js');

$glosowania = array();
if( @$dataBrowser['aggs']['glosowania']['top']['hits']['hits'] ) 
	foreach( $dataBrowser['aggs']['glosowania']['top']['hits']['hits'] as $b )
		if( !empty($b['_source']['data']['sejm_glosowania']['punkt_id']) )
			foreach( $b['_source']['data']['sejm_glosowania']['punkt_id'] as $punkt_id )
				$glosowania[ $punkt_id ][] = $b;

?>

<div class="margin-top-10">
	
	<div class="row">
		<div class="col-md-12">
	
			<div class="block nobg">
			    <header>Przebieg posiedzenia:</header>
			    <section class="content">
				    
				    <div class="agg agg-Dataobjects">
		                <ul class="dataobjects row margin-top--20">
		                    <? 
			                    foreach( $dataBrowser['aggs']['stenogramy']['top']['hits']['hits'] as $doc ) { 
		                    ?>
		                    <li class="margin-top-40 col-md-4">
		                    	<?= $this->Dataobject->render($doc, 'sejm_posiedzenia/dzien'); ?>
		                    </li>
		                    <? } ?>
		                </ul>
		            </div>
				    
			    </section>
			</div>
			
			<div class="block" id="punkty">
			    <header>Punkty porządku dziennego:</header>
			    <section class="content">
				    
	                <div class="agg agg-Dataobjects">
	                    <ul class="dataobjects punkt-projekty margin-sides-10">
	                        <? 
		                        $bufor = array();
		                        $iterator = 0;
		                        
		                        $add_dive = false;
		                        
		                        foreach (@$dataBrowser['aggs']['punkty']['top']['hits']['hits'] as $doc) {
			                        
			                        $iterator++;
			                        $data = $doc['_source']['data'];
			                        
			                        if( !$data['sejm_posiedzenia_punkty']['numer'] ) {
			                        	$bufor = $doc;
			                        	continue;
			                        }
			                        
	                        ?>
	                        
	                        <? if( !$add_dive && ($iterator>3) ) { $add_dive = true;?>
	                        	<div class="add_div" style="display: none;">
	                        <? } ?>
	                        
	                            <li class="punkt">
	                            	
	                            	<?
		                            	$options = array();
		                            	if( array_key_exists($data['sejm_posiedzenia_punkty']['id'], $glosowania) )
		                            		$options['glosowania'] = $glosowania[$data['sejm_posiedzenia_punkty']['id']];
		                            	echo $this->Dataobject->render($doc, 'sejm_posiedzenia/punkt', $options);
	                            	?>
	                            	
	                            </li>
	                        <? } ?>
	                        
	                        <? if( !empty($bufor) ) {?>
	                        	<li class="punkt">
	                            	
	                            	<?
		                            	echo $this->Dataobject->render($bufor, 'sejm_posiedzenia/punkt');
	                            	?>
	                            	
	                            </li>
	                        <? } ?>
	                        
	                        <? if( $add_dive ) { ?>
	                        	</div>
	                        <? } ?>
	                        
	                    </ul>
	                    <div class="btns">
		                    <p class="btn-more"><a href="#">Zobacz wszystkie punkty &darr;</a></p>
		                    <p class="btn-less" style="display: none;"><a href="#">Zobacz mniej &uarr;</a></p>
	                    </div>
	                </div>
				    
			    </section>
			</div>
				
		</div>
	</div>

</div>



