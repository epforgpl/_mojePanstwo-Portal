<?

$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>

<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
		<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
	
		    <? if(isset($_submenu) && isset($_submenu['items'])) {
		
		        if (!isset($_submenu['base']))
		            $_submenu['base'] = $object->getUrl();
		
		        echo $this->Element('Dane.DataBrowser/browser-menu', array(
		            'menu' => $_submenu,
		        ));
		
		    } ?>
	    
		</div>
	</div>
	<div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
	    
			
		<h1 class="smaller margin-top-15">Umowy zawierane przez Urząd Miasta Kraków</h1>
	    
	    <div class="row">
	        <div class="col-sm-12">
	
	
	                <? if (@$dataBrowser['aggs']['umowy']['dni']['buckets']) { ?>
	                    <div class="block block-simple nobg">
	                        <header>Wartość brutto podpisywanych umów:</header>
	                        <section>
	                            <?= $this->element('Dane.highstock_browser', array(
	                                'histogram' => $dataBrowser['aggs']['umowy']['dni']['buckets'],
	                                'preset' => 'krakow_umowy',
	                                'options' => array(
	                                    'more' => array(
	                                        'url' => '/dane/gminy/903,krakow/umowy',
	                                        'convert' => true,
	                                    ),
	                                    'aggs' => array(
	                                        'umowy' => array(
	                                            'size' => 5,
	                                        ),
	                                        'wykonawcy' => array(),
	                                        'rodzaje_budzet' => array(),
	                                        'rodzaje_wolumen' => array(),
	                                        'jednostki' => array(),
	                                        'tryby' => array(),
	                                    ),
	                                    'mode' => 'medium',
	                                ),
	                            )); ?>
	                        </section>
	                    </div>
	                <? } ?>
	
	
	        </div>
	    </div>
	    
	    
	</div>
</div>
