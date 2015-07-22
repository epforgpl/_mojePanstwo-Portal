<div class="col-md-12">

    <div class="blocks">        
				
		<? if (@$dataBrowser['aggs']['all']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Rozstrzygnięcia zamówień publicznych:</header>
                <section>
                    <?= $this->element('Dane.zamowienia_publiczne', array(
                        'histogram' => $dataBrowser['aggs']['all']['zamowienia_publiczne_dokumenty']['dni']['buckets'],
                        'request' => array(),
                        'more' => array(
                        	'url' => '/zamowienia_publiczne/rozstrzygniete',
                        	'convert' => true,
                        ),
                        'aggs' => array(
                        	'stats' => array(), 
                        	'dokumenty' => array(
	                        	'size' => 10,
                        	), 
                        	'wykonawcy' => array(),
                        ),
                        'mode' => 'medium',
                    )); ?>
                </section>
            </div>
        <? } ?>
        
    </div>

</div>