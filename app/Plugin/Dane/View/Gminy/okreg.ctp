<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okregi', array('plugin' => 'Dane')));
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-okregi');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $okreg,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));

?>
    <div class="row">

		<div class="col-sm-8">
	        
	        <div class="block block-simple col-xs-12 margin-top-0">
		        <header>Mapa okręgu</header>
		        <section class="aggs-init margin-sides-10">
		             <div id="okreg_map" class="object"></div>
			        <div data-name="okreg" data-content='<?= $okreg->getLayers('geo') ?>'></div>
		        </section>
		    </div>
	        
	        <? if( @$okreg_aggs['radni']['hits']['hits'] ) { ?>
	        <div class="block block-simple col-xs-12">
		        <header>Radni wybrani w tym okręgu</header>
		        <section class="aggs-init">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
	                        <ul class="dataobjects">
	                            <? foreach ($okreg_aggs['radni']['hits']['hits']['hits'] as $doc) { ?>
	                                <li>
	                                    <?=  $this->Dataobject->render($doc, 'default'); ?>
	                                </li>
	                            <? } ?>
	                        </ul>
		                </div>
		            </div>
		        </section>
		    </div>
		    <? } ?>        
	        
	    </div>

	    <div class="col-sm-4">

            <ul class="dataHighlights rightColumn margin-top-30">
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Rok</p>
                    <p class="_value"><?= $okreg->getData('rok') ?></p>
                </li>

                <? if($okreg->getData('liczba_mieszkańców')) { ?>
                    <li class="dataHighlight col-xs-12">
                        <p class="_label">Liczba mieszkańców</p>
                        <p class="_value"><?= $okreg->getData('liczba_mieszkańców') ?></p>
                    </li>
                <? } ?>

                <li class="dataHighlight col-xs-12">
                    <p class="_label">Liczba mandatów</p>
                    <p class="_value"><?= $okreg->getData('liczba_mandatow') ?></span></p>
                </li>

                <li class="dataHighlight col-xs-12">
                    <p class="_label">Ilość mieszkańców / Norma przedstawicielstwa <span style="color: rgba(160, 25, 27, 0.78);">*</span></p>
                    <p class="_value"><?= $okreg->getData('liczba_miesz_norma_przedst') ?></p>
                </li>
            </ul>

	        <p class="text-muted">
	            <span style="color: rgba(160, 25, 27, 0.78);">*</span> Norma przedstawicielska -
	            określa ilość mandatów przypadających na dany okręg. Jest obliczana przez
	            podzielenie liczby mieszkańców gminy przez liczbę radnych wybieranych do danej rady.
	            By ustalić liczbę mandatów w danym okręgu wyborczym, stosuje się normę
	            przedstawicielską. Ułamki równe lub większe od 1/2, jakie wynikają z zastosowania
	            normy przedstawicielstwa, zaokrągla się w górę do liczby całkowitej.
	        </p>

	        <p>
	            <a target="_blank" href="/dane/gminy/903,krakow/rada_uchwaly/18316">
	                Źródło
	            </a>
	        </p>

	    </div>



	</div>
<?
echo $this->Element('dataobject/pageEnd');
