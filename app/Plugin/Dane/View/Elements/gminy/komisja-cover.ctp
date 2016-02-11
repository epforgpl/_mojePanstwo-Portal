<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>

<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
				
	    <?
		    if (!isset($_submenu['base']))
	            $_submenu['base'] = $komisja->getUrl();
	
	        echo $this->Element('Dane.DataBrowser/browser-menu', array(
	            'menu' => $_submenu,
	        ));
	    ?>
	    
		</div>
	</div>
	<div class="col-md-10 nocontainer">
			
		<? if ($object->getId() == 903) { ?>
			
			<div class="row">
				<div class="col-md-10">
			
			        <div class="block block-simple margin-top-20">
			            <header>Najnowsze posiedzenia komisji:</header>
						<section class="content">
				            <div class="aggs-init">
				
				                <div class="dataAggs">
				                    <div class="agg agg-Dataobjects">
				                        <? if ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
				                            <ul class="dataobjects">
				                                <? foreach ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
				                                    <li>
				                                        <?
				                                        echo $this->Dataobject->render($doc, 'default');
				                                        ?>
				                                    </li>
				                                <? } ?>
				                            </ul>
				                            
				                        <? } ?>
				
				                    </div>
				                </div>
				
				
				            </div>
						</section>
						<div class="buttons">
                            <a href="<?= $komisja->getUrl() ?>/posiedzenia" class="btn btn-default btn-xs">Zobacz
                                więcej</a>
                        </div>
			        </div>
			
			        <div class="databrowser-panel">
			            <h2>Skład komisji:</h2>
			
			            <div class="aggs-init">
			
			                <div class="dataAggs">
			                    <div class="agg agg-Dataobjects">
			                        <? if ($dataBrowser['aggs']['radni']['top']['hits']['hits']) { ?>
			                            <ul class="dataobjects row">
			                                <? foreach ($dataBrowser['aggs']['radni']['top']['hits']['hits'] as $doc) {
			
			                                    $stanowisko = array();
			                                                                        
			                                    foreach ($doc['_source']['radni_gmin-komisje'] as $s)
			                                        if ($s['komisja_id'] == $komisja->getId())
			                                            $stanowisko = $s;
			
			                                    ?>
			                                    <li class="col-md-4" style="min-height: 160px;">
			                                        <?
			                                        echo $this->Dataobject->render($doc, 'krakow_radni_komisje', $stanowisko);
			                                        ?>
			                                    </li>
			                                <? } ?>
			                            </ul>
			                        <? } ?>
			
			                    </div>
			                </div>
			
			
			            </div>
			        </div>
				
				</div>
			</div>
				
	    <? } ?>
			
	</div>
</div>