<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('css', $this->Less->css('sejm', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');


$this->Combinator->add_libs('css', $this->Less->css('view-instytucje-cover-sejm', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-instytucje-cover-sejm');
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));


$options = array(
    'mode' => 'init',
);

?>
<div class="col-md-9">

    <div class="blocks">

        <? if(@$okregi) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Okręgi:</header>
                <div class="row">
                    <div class="col-sm-8">
                        <div id="map"></div>
                    </div>
                    <div class="col-sm-4">
                        <h4>Okregi według numerów</h4>
                        <div class="row">
                            <? foreach($okregi as $i => $okrag) { ?>
                                <button id="okrag<?= $okrag[0]; ?>" data-index="<?= $i; ?>" type="button" class="btn btn-link okrag"><?= $okrag[1]; ?></button>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <div data-name="okregi" data-value='<?= json_encode($okregi) ?>'></div>
            </div>
        <? } ?>

		<? if (@$dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Najnowsze akty prawne:</header>

                <section class="aggs-init">

                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits']) { ?>
                                <ul class="dataobjects">
                                    <? foreach ($dataBrowser['aggs']['all']['prawo']['top']['hits']['hits'] as $doc) { ?>
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
		
        <? /*
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
        
    echo $this->element('tools/datasets', array(
	    'items' => array(
		    array(
                'id' => 'poslowie',
                'dataset' => 'poslowie',
                'label' => 'Posłowie',
            ),
            array(
                'id' => 'posiedzenia',
                'dataset' => 'sejm_posiedzenia',
                'label' => 'Posiedzenia Sejmu',
            ),
            array(
                'id' => 'wystapienia',
                'dataset' => 'sejm_wystapienia',
                'label' => 'Wystąpienia',
            ),
            array(
                'id' => 'glosowania',
                'dataset' => 'sejm_glosowania',
                'label' => 'Głosowania',
            ),
            array(
                'id' => 'druki',
                'dataset' => 'sejm_druki',
                'label' => 'Druki sejmowe',
            ),
            array(
                'id' => 'interpelacje',
                'dataset' => 'sejm_interpelacje',
                'label' => 'Interpelacje',
            ),
            array(
                'id' => 'kluby',
                'dataset' => 'sejm_kluby',
                'label' => 'Kluby',
            ),
            array(
                'id' => 'komisje',
                'dataset' => 'sejm_komisje',
                'label' => 'Komisje',
            ),
            array(
                'id' => 'dezyderaty',
                'dataset' => 'sejm_dezyderaty',
                'label' => 'Dezyderaty komisji',
            ),
            array(
                'id' => 'komisje_opinie',
                'dataset' => 'sejm_komisje_opinie',
                'label' => 'Opinie komisji sejmowych',
            ),
            array(
                'id' => 'komisje_uchwaly',
                'dataset' => 'sejm_komisje_uchwaly',
                'label' => 'Uchwały komisji',
            ),
            array(
                'id' => 'komunikaty',
                'dataset' => 'sejm_komunikaty',
                'label' => 'Komunikaty Kancelarii Sejmu',
            ),
            array(
                'id' => 'okregi',
                'dataset' => 'sejm_okregi',
                'label' => 'Okręgi wyborcze do Sejmu',
            ),                            
            array(
                'id' => 'poslowie_oswiadczenia_majatkowe',
                'dataset' => 'poslowie_oswiadczenia_majatkowe',
                'label' => 'Oświadczenia majątkowe posłów',
            ),
            array(
                'id' => 'poslowie_rejestr_korzysci',
                'dataset' => 'poslowie_rejestr_korzysci',
                'label' => 'Rejestr korzyści posłów',
            ),
            array(
                'id' => 'poslowie_wspolpracownicy',
                'dataset' => 'poslowie_wspolpracownicy',
                'label' => 'Współpracownicy posłów',
            )
	    ),
    ));
    ?>

</div>