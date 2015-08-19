<div class="col-xs-12 col-md-3 dataAggsContainer">
    <? echo $this->Element('Dane.DataBrowser/aggs', array(
        	'data' => $dataBrowser,
    )); ?>
</div>

<div class="col-xs-12 col-md-9">
	
	<? 
		if(@$dataBrowser['aggs']['grupy']['buckets']) { 
			foreach( $dataBrowser['aggs']['grupy']['buckets'] as $b ) {
				
				$label = $b['label'];
				$label = 'Label';
				
	?>
	
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
	    
	<? } } ?>
    
</div>