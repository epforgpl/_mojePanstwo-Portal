<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('css', $this->Less->css('sejm', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');


$this->Combinator->add_libs('css', $this->Less->css('view-instytucje-cover-sejm', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-instytucje-cover-sejm');

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));


$options = array(
    'mode' => 'init',
);

?>
<div class="row">
	<div class="col-md-9">
	
	    <div class="blocks">
			
			
			<? if ($docs = @$dataBrowser['aggs']['sejm_posiedzenia']['top']['hits']['hits']) { ?>
			<div class="block block-simple block-size-sm col-xs-12">
	            <header>Ostatnie posiedzenia Sejmu:</header>
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
                            <ul class="dataobjects border-bottom margin-sides-10 margin-top--10">
                                <? foreach ($docs as $doc) { ?>
                                    <li class="margin-top-15">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default', array(
                                            'truncate' => '230',
                                        ));
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons margin-bottom-10">
                                <a href="<?= $object->getUrl() ?>/posiedzenia" class="btn btn-default btn-xs">Wszystkie posiedzenia &raquo;</a>
                            </div>
	                    </div>
	                </div>
	            </section>
	        </div>
	        <? } ?>
		
			<? if(@$okregi) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Znajdź posłów reprezentujących Twój okręg wyborczy:</header>
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
                <div class="buttons margin-bottom-10">
                    <a href="<?= $object->getUrl() ?>/poslowie" class="btn btn-default btn-xs">Zobacz listę wszystkich posłów &raquo;</a>
                </div>
            </div>
	        <? } ?>
		
		
		    <? foreach( $dataBrowser['aggs']['prawo_projekty']['typy']['buckets'] as $b ) { ?>
	    	<div class="block block-simple block-size-sm col-xs-12">
                <header><?= $prawo_projekty_slownik[ $b['key'] ]['tytul'] ?></header>
                <section class="aggs-init">
                    <div class="dataAggs">
                        <div class="agg agg-Dataobjects">
                            <? if ($b['top']['hits']['hits']) { ?>
                                <ul class="dataobjects border-bottom margin-sides-10 margin-top--10">
                                    <? foreach ($b['top']['hits']['hits'] as $doc) { ?>
                                        <li class="margin-top-15">
                                            <?
                                            echo $this->Dataobject->render($doc, 'default', array(
	                                            'truncate' => '230',
                                            ));
                                            ?>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="buttons margin-bottom-10">
                                    <a href="<?= $object->getUrl() ?>/prawo_projekty?conditions[prawo_projekty.typ_id]=<?= $b['key'] ?>" class="btn btn-primary btn-xs">Zobacz więcej</a>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </section>
            </div>
		    <? } ?>
		    

			
						
			<? if (@$dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
            <div class="block block-simple block-size-sm col-xs-12">
                <header>Rozstrzygnięcia zamówień publicznych w Kancelarii Sejmu:</header>
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
	                'dataset' => 'sejm_okregi_wyborcze',
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
	            /*
	            array(
	                'id' => 'poslowie_wspolpracownicy',
	                'dataset' => 'poslowie_wspolpracownicy',
	                'label' => 'Współpracownicy posłów',
	            )
	            */
		    ),
	    ));
	    ?>
	
	</div>
</div>