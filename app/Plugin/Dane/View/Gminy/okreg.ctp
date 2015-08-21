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
	        <div id="okreg_map" class="object"></div>
	        <div data-name="okreg" data-content='<?= $okreg->getLayers('geo') ?>'></div>
	    </div>

	    <div class="col-sm-4">

            <ul class="dataHighlights rightColumn">
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
                    <p class="_label" data-toggle="tooltip" data-placement="bottom" title="Norma przedstawicielska -
	            określa ilość mandatów przypadających na dany okręg. Jest obliczana przez
	            podzielenie liczby mieszkańców gminy przez liczbę radnych wybieranych do danej rady.
	            By ustalić liczbę mandatów w danym okręgu wyborczym, stosuje się normę
	            przedstawicielską. Ułamki równe lub większe od 1/2, jakie wynikają z zastosowania
	            normy przedstawicielstwa, zaokrągla się w górę do liczby całkowitej.">Ilość mieszkańców / Norma przedstawicielstwa</p>
                    <p class="_value"><?= $okreg->getData('liczba_miesz_norma_przedst') ?></p>
                </li>
            </ul>

	        <p>
	            <a target="_blank" href="/dane/gminy/903,krakow/rada_uchwaly/18316">
	                Źródło
	            </a>
	        </p>

	    </div>



	</div>
<?
echo $this->Element('dataobject/pageEnd');
