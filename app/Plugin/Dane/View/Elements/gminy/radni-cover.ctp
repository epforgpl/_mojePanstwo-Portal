<?
$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>
<div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
	<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
		
	    <? if(isset($_submenu) && isset($_submenu['items'])) {
	
	        if (!isset($_submenu['base']))
	            $_submenu['base'] = $object->getUrl();
	
	        echo $this->Element('Dane.DataBrowser/browser-menu', array(
	            'menu' => $_submenu,
	        ));
	
	    } ?>
	
	    <?
	    $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
	    $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
	    $this->Combinator->add_libs('js', 'Pisma.pisma-button');

		echo $this->element('tools/vote');

	    echo $this->element('tools/pismo', array(
	        'label' => '<strong>Wyślij pismo</strong> do Rady Miasta',
	        'adresat' => 'rada_gminy:' . $object->getId() .'',
	    ));
	    ?>
    
	</div>
</div>
<div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
	
	<div class="dataWrap">
		
		<? if( isset($dataBrowser['browserTitleElement']) && $dataBrowser['browserTitleElement'] ) { ?>
			<?= $this->element($dataBrowser['browserTitleElement']) ?>
		<? } elseif( isset($dataBrowser['browserTitle']) ) { ?>
			<h1 class="smaller margin-top-15"><?= $dataBrowser['browserTitle'] ?></h1>
		<? } ?>
		
	    <?= $this->element('Dane.DataBrowser/browser-content-filters', array(
	    	'class' => 'margin-top-15',
	    )) ?>
	
	    <div class="databrowser-panels">
	
	        <? if ($object->getId() == 903) { ?>
	
	            <div class="databrowser-panel">
	                <div class="aggs-init">
	
	                    <div class="dataAggs">
	                        <div class="agg agg-Dataobjects">
	                            <? if ($dataBrowser['aggs']['radni']['top']['hits']['hits']) { ?>
	                                <ul class="dataobjects row radni_cover">
	                                    <? foreach ($dataBrowser['aggs']['radni']['top']['hits']['hits'] as $doc) { ?>
	                                        <li class="col-md-4">
	                                            <?
	                                            echo $this->Dataobject->render($doc, 'krakow_radni');
	                                            ?>
	                                        </li>
	                                    <? } ?>
	                                </ul>
	                            <? } ?>
	
	                        </div>
	                    </div>
	
	
	                </div>
	            </div>
	
	        <? } ?>
	    
		</div>
	
	</div>

</div>
