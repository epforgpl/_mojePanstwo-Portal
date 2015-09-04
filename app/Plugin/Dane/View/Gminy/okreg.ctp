<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okreg', array('plugin' => 'Dane')));
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

		<div class="col-sm-7">

	        <div class="block block-simple col-xs-12">
		    	<section class="aggs-init margin-sides-10">

			    	<ul class="dataHighlights oneline">
		                <li class="dataHighlight col-xs-3">
		                    <p class="_label">Rok wyborów</p>
		                    <p class="_value"><?= $okreg->getData('rok') ?></p>
		                </li>

		                <? if($okreg->getData('liczba_mieszkancow')) { ?>
		                    <li class="dataHighlight col-xs-3">
		                        <p class="_label">Liczba mieszkańców</p>
		                        <p class="_value"><?= $okreg->getData('liczba_mieszkancow') ?></p>
		                    </li>
		                <? } ?>

		                <li class="dataHighlight col-xs-3">
		                    <p class="_label">Liczba mandatów</p>
		                    <p class="_value"><?= $okreg->getData('liczba_mandatow') ?></span></p>
		                </li>

		                <li class="dataHighlight col-xs-7">
		                    <p class="_label" data-toggle="tooltip" data-placement="bottom" title="Norma przedstawicielska -
			            określa ilość mandatów przypadających na dany okręg. Jest obliczana przez
			            podzielenie liczby mieszkańców gminy przez liczbę radnych wybieranych do danej rady.
			            By ustalić liczbę mandatów w danym okręgu wyborczym, stosuje się normę
			            przedstawicielską. Ułamki równe lub większe od 1/2, jakie wynikają z zastosowania
			            normy przedstawicielstwa, zaokrągla się w górę do liczby całkowitej.">Norma przedstawicielstwa</p>
			            <?
				            $data = $okreg->getLayer('data');
			            ?>
		                    <p class="_value"><?= $data['ilosc_miesz_norma_przedst'] ?></p>
		                </li>

		            </ul>

		    	</section>
		    </div>

	        <? if( @$okreg_aggs['radni']['hits']['hits'] ) { ?>
	        <div class="block block-simple col-xs-12">
		        <header>Radni wybrani w tym okręgu:</header>
		        <section class="aggs-init radni">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
	                        <ul class="dataobjects row radni_cover">
	                            <? foreach ($okreg_aggs['radni']['hits']['hits']['hits'] as $doc) { ?>
	                                <li class="col-sm-4">
	                                    <?=  $this->Dataobject->render($doc, 'krakow_radni'); ?>
	                                </li>
	                            <? } ?>
	                        </ul>
		                </div>
		            </div>
		        </section>
		    </div>
		    <? } ?>


		    <p class="text-center">
                <a href="/dane/gminy/903,krakow/rada_uchwaly/18316?file=412749">
	                Źródło
	            </a>
            </p>



	    </div>

	    <div class="col-sm-5">

			<div class="block col-xs-12 margin-top-10">
		        <header>Mapa okręgu:</header>
		        <section class="aggs-init nopadding">
		             <div id="okreg_map" class="object"></div>
			        <div data-name="okreg" data-content='<?= $okreg->getLayers('geo') ?>'></div>
		        </section>
		    </div>

	    </div>



	</div>
<?
echo $this->Element('dataobject/pageEnd');
