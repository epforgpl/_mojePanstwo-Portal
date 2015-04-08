<?

	$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
	$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
	$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
	$this->Combinator->add_libs('js', 'Dane.view-gminy');
	
	if ($object->getId() == '903') {
	    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
	    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
	}

?>
<div class="objectSideInner">
	
	<? if( $szef = $object->getLayer('szef') ) { ?>
	<div class="block">
	
		<ul class="dataHighlights side">

			<li class="dataHighlight big">
	            <p class="_label"><?= $szef['stanowisko'] ?></p>
	
	            <div class="">
	                <p class="_value"><?= $szef['kandydat_nazwa'] ?></p>
	            </div>
	        </li>
						
	        <li class="dataHighlight">
	            <p class="_label">Komitet</p>
	
	            <div class="">
	                <p class="_value"><?= $szef['komitet_nazwa'] ?></p>
	            </div>
	        </li>
	        
	        <li class="dataHighlight">
	            <p class="_label pull-left">Liczba głosów</p>
	
	            <div class="">
	                <p class="_value pull-right"><?= number_format_h($szef['liczba_glosow']); ?></p>
	            </div>
	        </li>
	        
	        <li class="dataHighlight">
	            <p class="_label pull-left">Poparcie</p>
	
	            <div class="">
	                <p class="_value pull-right"><?= round($szef['procent_glosow'], 1) ?>%</p>
	            </div>
	        </li>
	        
		</ul>
	</div>
	<? } ?>
	
	
	<div class="block">		
		
	    <ul class="dataHighlights side">
	
	
	        <li class="dataHighlight">
	            <p class="_label pull-left">Liczba ludności</p>
	
	            <div class="">
	                <p class="_value pull-right"><?= number_format_h($object->getData('liczba_ludnosci')); ?></p>
	            </div>
	        </li>
	
	        <li class="dataHighlight">
	            <p class="_label pull-left">Powierzchnia</p>
	
	            <div>
	                <p class="_value pull-right"><?= number_format($object->getData('powierzchnia'), 0); ?> km<sup>2</sup></p>
	            </div>
	        </li>
	        
	    </ul>
	</div>
	
	
	<div class="block">
	
		<ul class="dataHighlights side">
	
	        <li class="dataHighlight">
	            <p class="_label">Dochody roczne gminy</p>
	
	            <div>
	                <p class="_value"><?= number_format_h($object->getData('dochody_roczne')); ?> PLN</p>
	            </div>
	        </li>
	
	        <li class="dataHighlight">
	            <p class="_label">Wydatki roczne gminy</p>
	
	            <div>
	                <p class="_value"><?= number_format_h($object->getData('wydatki_roczne')); ?> PLN</p>
	            </div>
	        </li>
	
	        <li class="dataHighlight">
	            <p class="_label">Deficyt roczny gminy</p>
	
	            <div>
	                <p class="_value"><?= number_format_h($object->getData('zadluzenie_roczne')); ?> PLN</p>
	            </div>
	        </li>
	
	
	    </ul>
	
	    <ul class="dataHighlights side hide">
	
	        <li class="dataHighlight">
	            <p class="_label">Kod TERYT</p>
	
	            <div>
	                <p class="_value"><?= $object->getData('teryt'); ?></p>
	            </div>
	        </li>
	
	        <li class="dataHighlight">
	            <p class="_label">Kod NTS</p>
	
	            <div>
	                <p class="_value"><?= $object->getData('nts'); ?></p>
	            </div>
	        </li>
	
	        <li class="dataHighlight topborder">
	            <p class="_label">Biuletyn Informacji Publicznej</p>
	
	            <div>
	                <p class="_value"><?= $object->getData('bip_www'); ?></p>
	            </div>
	        </li>
	
	    </ul>
    
	</div>

    <p style="display: none;" class="text-center showHideSide">
        <a class="a-more">Więcej &darr;</a>
        <a class="a-less hide">Mniej &uarr;</a>
    </p>

</div>