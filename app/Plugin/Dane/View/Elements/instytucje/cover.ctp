<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>

<div class="row">
	
	<div class="col-md-9">
	
	    <div class="blocks">
	
	
	        <? if (@$dataBrowser['aggs']['prawo']['top']['hits']['hits']) { ?>
	            <div class="block block-simple block-size-sm col-xs-12">
	                <header>Najnowsze akty prawne:</header>
	
	                <section class="aggs-init">
	
	                    <div class="dataAggs">
	                        <div class="agg agg-Dataobjects">
	                            <? if ($dataBrowser['aggs']['prawo']['top']['hits']['hits']) { ?>
	                                <ul class="dataobjects">
	                                    <? foreach ($dataBrowser['aggs']['prawo']['top']['hits']['hits'] as $doc) { ?>
	                                        <li>
	                                            <?
	                                            echo $this->Dataobject->render($doc, 'default');
	                                            ?>
	                                        </li>
	                                    <? } ?>
	                                </ul>
	                                <div class="buttons">
				                        <a href="<?= $object->getUrl() ?>/prawo" class="btn btn-primary btn-xs">Zobacz więcej</a>
				                    </div>
	                            <? } ?>
	
	                        </div>
	                    </div>
	
	                </section>
	                
	                
	            </div>
	        <? } ?>
					
			<? if (@$dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
	            <div class="block block-simple block-size-sm col-xs-12">
	                <header>Rozstrzygnięcia zamówień publicznych:</header>
	                <section>
	                    <?= $this->element('Dane.zamowienia_publiczne', array(
	                        'histogram' => $dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets'],
	                        'request' => array(
		                        'instytucja_id' => $object->getId(),
	                        ),
	                        'more' => $object->getUrl() . '/zamowienia',
	                        'aggs' => array(
	                        	'stats' => array(), 
	                        	'dokumenty' => array(), 
	                        ),
	                    )); ?>
	                </section>
	            </div>
	        <? } ?>
	
	        <? if (@$dataBrowser['aggs']['prawo_urzedowe']['top']['hits']['hits']) { ?>
	            <div class="block block-simple block-size-sm col-xs-12">
	                <header>Najnowsze pozycje w dzienniku urzędowym:</header>
	
	                <section class="aggs-init">
	
	                    <div class="dataAggs">
	                        <div class="agg agg-Dataobjects">
	                            <? if ($dataBrowser['aggs']['prawo_urzedowe']['top']['hits']['hits']) { ?>
	                                <ul class="dataobjects">
	                                    <? foreach ($dataBrowser['aggs']['prawo_urzedowe']['top']['hits']['hits'] as $doc) { ?>
	                                        <li>
	                                            <?
	                                            echo $this->Dataobject->render($doc, 'default');
	                                            ?>
	                                        </li>
	                                    <? } ?>
	                                </ul>
	                                <div class="buttons">
	                                    <a href="#" class="btn btn-primary btn-xs">Zobacz więcej</a>
	                                </div>
	                            <? } ?>
	
	                        </div>
	                    </div>
	
	                </section>
	            </div>
	        <? } ?>
	
	
	    </div>
	
	</div>
	<div class="col-md-3">
	    <?
		    
	    if ($adres = $object->getData('adres_str')) {
	        $adres = str_ireplace('ul.', '<br/>ul.', $adres) . ', Polska';
	        echo $this->element('Dane.adres', array(
	            'adres' => $adres,
	        ));
	    }
	    
	    $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
	
	    $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
	    $this->Combinator->add_libs('js', 'Pisma.pisma-button');
	    echo $this->element('tools/pismo', array());
	
	    $page = $object->getLayer('page');
	    if (!$page['moderated'])
	        echo $this->element('tools/admin', array());
	    ?>
	
	</div>

</div>