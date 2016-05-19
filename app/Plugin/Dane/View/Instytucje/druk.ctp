<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $druk,
    'objectOptions' => array(
	    'truncate' => 1000,
	    'mode' => 'subobject',
	),
));
?><div class="prawo row">

    <div class="col-md-9">
        <div class="object">
            <?= $this->Document->place($druk->getData('dokument_id')) ?>
        </div>
    </div><div class="col-md-3">
	    
	    <? if( $druk_projekty ) {?>
	    <div class="block margin-top-20">
	        <header>Więcej szczegółów o projekcie:</header>
			
	        <section class="aggs-init nopadding">
	            <div class="dataAggs">
	                <div class="agg agg-Dataobjects">
	                    <ul class="dataobjects">
	                        <? 
		                        foreach ($druk_projekty as $doc) {
	                        ?>
	                            <li class="margin-sides-10"><?= $this->Dataobject->render($doc, 'default-nothumb'); ?></li>
	                        <? } ?>
	                    </ul>
	                </div>
	            </div>
	        </section>
	    </div>
	    <? } ?>
	    
    </div>


</div><?
echo $this->Element('dataobject/pageEnd');