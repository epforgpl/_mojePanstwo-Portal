<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('css', $this->Less->css('sejm', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>
<div class="col-md-9">

    <div class="blocks">
		
		
        <? 
	        /*
	    if ( $doc = @$dataBrowser['aggs']['all']['sejm_posiedzenia']['top']['hits']['hits'][0]['fields']['source'][0] ) { 
        ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header><a href="/dane/instytucje/3214/posiedzenia/<?= $doc['data']['sejm_posiedzenia.id'] ?>"><?= $doc['data']['sejm_posiedzenia.tytul'] ?></a></header>
				
                <section class="aggs-init">	
					
                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects sejm_posiedzenie">
                            
                            <div class="row">
	                            
	                            <div class="col-md-5">
		                            <ul class="stats">
		                                <li>
		                                    <p><span class="glyphicon glyphicon-ok"></span> Przyjęto 40 ustaw, 20 uchwał i 3 wnioski.</p>
		                                    <p><span class="glyphicon glyphicon-remove"></span> Odrzucono 12 ustaw i 2 uchwały.</p>
		                                    <p><span class="glyphicon glyphicon-arrow-right"></span> Do dalszych prac skierowano 13 uchwał.</p>
		                                </li>
		                            </ul>
	                            </div><div class="col-md-7 text-center">
		                            
		                            <div class="row">
			                            <div class="col-md-6">
				                            <p>Największa zgodność:</p>
				                            <p class="number">36,2%</p>
			                            </div><div class="col-md-6">
				                            <p>Najmniejsza zgodność:</p>
				                            <p class="number">58,2%</p>
			                            </div>
		                            </div>
		                            
	                            </div>		                            
		                            
                            </div>
                            <div class="row">
	                            <div class="buttons" style="margin-top: 0;">
	                                <a href="/dane/instytucje/3214/posiedzenia/<?= $doc['data']['sejm_posiedzenia.id'] ?>" class="btn btn-primary btn-xs">Zobacz więcej</a>
	                            </div>
                            </div>

                        </div>
                    </div>

                </section>
            </div>
        <? } */ ?>
				
		<? if (@$dataBrowser['aggs']['all']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Rozstrzygnięcia zamówień publicznych:</header>
                <section>
                    <?= $this->element('Dane.zamowienia_publiczne', array(
                        'histogram' => $dataBrowser['aggs']['all']['zamowienia_publiczne_dokumenty']['dni']['buckets'],
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

        <? if (@$dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits']) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Najnowsze pozycje w dzienniku urzędowym:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['prawo_urzedowe']['top']['hits']['hits'] as $doc) { ?>
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