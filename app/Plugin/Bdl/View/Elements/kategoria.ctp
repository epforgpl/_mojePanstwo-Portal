<? $this->Combinator->add_libs('css', $this->Less->css('bdl', array('plugin' => 'Bdl'))); ?>

<div class="col-xs-12 col-md-3 dataAggsContainer">
    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
</div>

<div id="bdl_div" class="col-xs-12 col-md-9">
	
	<? 
		if(@$dataBrowser['aggs']['grupy']['buckets']) { 
			foreach( $dataBrowser['aggs']['grupy']['buckets'] as $b ) {
				
				$label = @$b['label']['buckets'][0]['key'];								
				
	?>
		
		<div class="dataWrap">
		    <div class="block col-xs-12">
		        <header><?= $label ?></header>
		        <section class="aggs-init margin-sides-20">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <? if (@$b['top']['hits']['hits']) { ?>
		                        <ul class="dataobjects">
		                            <? foreach ($b['top']['hits']['hits'] as $doc) { ?>
		                                <li>
		                                    <?= $this->Dataobject->render($doc, 'default'); ?>
		                                </li>
		                            <? } ?>
		                        </ul>
		                    <? } ?>
		                </div>
		            </div>
		        </section>
		    </div>
		</div>
	    
	<? } } ?>
	
	<p class="bdl_src text-center margin-top-30 margin-bottom-20"><a href="http://stat.gov.pl/bdl/app/strona.html?p_name=indeks" target="_blank">Źródło danych (GUS)</a></p>
    
</div>