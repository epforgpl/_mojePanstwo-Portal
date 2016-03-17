<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>
<div class="row">
	<div class="col-md-12">
		
		<div class="appBanner margin-top--25 margin-bottom-30">
			<form method="get" action="">
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
	                        'request' => array(
		                        'instytucja_id' => $object->getId(),
	                        ),
	                        'more' => array(
	                        	'url' => $object->getUrl() . '/zamowienia_rozstrzygniete',
	                        	'convert' => true,
	                        ),
	                        'aggs' => array(
	                        	'stats' => array(), 
	                        	'dokumenty' => array(
		                        	'size' => 5,
	                        	), 
	                        	'wykonawcy' => array(),
	                        ),
	                        'mode' => 'medium',
	                    )); ?>
	                </section>
	            </div>
	        <? } ?>
	        
	    </div>
	    
	    <div class="row margin-top-20">
	        <div class="col-md-8 text-center">
	            <div class="buttons">
	                <a href="?q=" class="btn btn-primary btn-xs">Zobacz ostatnie zamówienia &raquo;</a>
	            </div>
	        </div>
	    </div>
	
	</div>
</div>