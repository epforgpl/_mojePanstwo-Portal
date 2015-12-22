<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-wpf', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

    switch (Configure::read('Config.language')) {
        case 'pol':
            $lang = "pl-PL";
            break;
        case 'eng':
            $lang = "en-EN";
            break;
    };
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=places&language=' . $lang, array('block' => 'scriptBlock'));
}

$this->Combinator->add_libs('js', 'Dane.view-gminy-wpf');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

echo $this->Element('dataobject/pageBegin');

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $program,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $object->getUrl();
?>


<div class="col-xs-12 col-md-9 objectMain">
    <div class="object">

		<? 
			$przedsiewziecia = $program->getLayer('przedsiewziecia');
	        foreach ($przedsiewziecia as $p) {

	            $static = array(
	                'years' => array()
	            );
	
	            for ($i = 2016; $i <= 2052; $i++) {
	                $static['years'][] = array(
	                    $i,
	                    $p['limit_' . $i]
	                );
	            }
	            
        ?>
		
			<? if( count($przedsiewziecia)>1 ) {?>	
				<div class="block block-simple" style="padding: 0 10px;">
					<ul class="dataHighlights oneline">
		                <? foreach (array(
		                                array(
		                                    'field' => 'cel',
		                                    'label' => 'Cel'
		                                ),
		                                array(
		                                    'field' => 'jednostka',
		                                    'label' => 'Jednostka'
		                                ),
		                                array(
		                                    'field' => 'okres_od',
		                                    'label' => 'Okres Od'
		                                ),
		                                array(
		                                    'field' => 'okres_do',
		                                    'label' => 'Okres do'
		                                ),
		                                array(
		                                    'field' => 'nr',
		                                    'label' => 'Numer'
		                                ),
		                                array(
		                                    'field' => 'laczne_naklady_fin',
		                                    'label' => 'Łączne nakłady finansowe'
		                                ),
		                                array(
		                                    'field' => 'limit_zobowiazan',
		                                    'label' => 'Limit zobowiązań'
		                                ),
		                            ) as $f) {
		                    if (isset($p[$f['field']]) && trim($p[$f['field']]) != '') { ?>
		                        <li class="dataHighlight col-sm-6">
		                            <p class="_label"><?= $f['label'] ?></p>
		                            <p class="_value"><?=
		                                in_array($f['field'], array('laczne_naklady_fin', 'limit_zobowiazan')) ?
		                                    number_format_h($p[$f['field']]) . ' zł' : $p[$f['field']]
		                                ?></p>
		                        </li>
		                    <? }
		                } ?>
		            </ul>
				</div>
		    <? } ?>

			<? if (isset($p['opis']) && strlen($p['opis']) > 10) { ?>                
			<div class="block block-simple col-xs-12">
	            <header>Opis</header>
	            <section class="content textBlock descBlock">
	                <div class="text"><?= $p['opis'] ?></div>
	            </section>
	        </div>
	        <? } ?>
	        
	        
	        <div class="block block-simple col-xs-12">
	            <header>Finansowanie w latach</header>
	            <section class="content">
	                <div
		                class="krakowWpfProgramStatic margin-top-20"
		                data-static="<?= htmlspecialchars(json_encode($static)); ?>">
		            </div>
	            </section>
	        </div>
	        
	        <? 
		    $lat = null;
		    $lon = null;
	        if(
	        	$can_edit ||
	        	(
		        	( $location = $program->getLayer('location') ) &&
		        	( $lat = $location['lat'] ) && 
		        	( $lon = $location['lon'] )
	        	)
	        ) {
		        
		        if( $can_edit && ($location = $program->getLayer('location')) ) {
			        $lat = $location['lat'];
			        $lon = $location['lon'];
		        }
		        
	        ?>
	        <div class="block block-simple col-xs-12">
	            <header>Lokalizacja</header>
	            <section class="content">
	            
                    <div class="krakowWpfPlaceMarker margin-top-20">
						
                        <div id="map" data-lat="<?= $lat ?>" data-lon="<?= $lon ?>"></div>
                        
                        <? if ($can_edit) { ?>
                        	<input id="pac-input" class="controls" type="text" placeholder="Wpisz adres" value="Kraków, ">
                            <form id="map_form" class="text-center" method="post" action="<?= $this->request->here; ?>.json">
                                <input type="hidden" name="lat" value="" />
                                <input type="hidden" name="lon" value="" />
                                <input type="hidden" name="zoom" value="" />
                                <button type="submit" class="btn btn-success margin-top-10">Zapisz lokalizację</button>
                            </form>
                        <? } ?>
                        
                    </div>
		            
	            </section>
	        </div>
	        <? } ?>
	        
	        
        
        <? } ?>
        
        
    </div>
</div><div class="col-xs-12 col-md-3 objectSide">
	
	<ul class="dataHighlights">
        <li class="dataHighlight">
            <p class="_label">Liczba przedsięwzięć</p>
            <p class="_value"><?= $program->getData('ilosc') ?></p>
        </li>
        <li class="dataHighlight">
            <p class="_label">Łączne nakłady finansowe</p>
            <p class="_value"><?= number_format_h($program->getData('laczne_naklady_fin')) ?> zł</p>
        </li>
        <li class="dataHighlight">
            <p class="_label">Limit zobowiązań</p>
            <p class="_value"><?= number_format_h($program->getData('limit_zobowiazan')) ?> zł</p>
        </li>
        <li class="dataHighlight">
            <p class="_label">Okres od</p>
            <p class="_value"><?= $program->getData('okres_od') ?></p>
        </li>
        <li class="dataHighlight">
            <p class="_label">Okres do</p>
            <p class="_value"><?= $program->getData('okres_do') ?></p>
        </li>
    </ul>
	
</div>


    



<? echo $this->Element('dataobject/pageEnd');
