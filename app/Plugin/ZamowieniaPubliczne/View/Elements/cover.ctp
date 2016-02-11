<div class="col-xs-12">

    <div class="appBanner">

		<h1 class="appTitle">Zamówienia publiczne</h1>
        <p class="appSubtitle">Sprawdzaj kto otrzymuje zamówienia publiczne. Znajdź zlecenie dla swojej organizacji.</p>
		
		<form action="/zamowienia_publiczne" method="get">
	        <div class="appSearch form-group">
				<div class="input-group">
					<input name="q" class="form-control" placeholder="Szukaj w zamówieniach publicznych..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
	                        <span class="glyphicon glyphicon-search"></span>
	                    </button>
					</span>
				</div>
	        </div>
		</form>

    </div>
    
    <div class="blocks">        
				
		<? if (@$dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
            <div class="block block-simple nobg block-size-sm col-xs-12">
                <header>Rozstrzygnięcia zamówień publicznych:</header>
                <section>
                    <?= $this->element('Dane.zamowienia_publiczne', array(
                        'histogram' => $dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets'],
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