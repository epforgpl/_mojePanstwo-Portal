<?
// echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));


echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $zmiana,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));

?>

    <div class="krsPodmiotZmiana row">

        <div class="col-md-3 objectSide">
            <div class="objectSideInner rrs">


                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Szczegóły</h2>
                    </div>

                    <ul class="dataHighlights side">

						
						<li class="dataHighlight">
                            <p class="_label pull-left">Dział</p>
                            <p class="_value pull-right"><?= $zmiana->getData('numer_dzialu') ?></p>                                
                        </li>
                        
                        <li class="dataHighlight">
                            <p class="_label pull-left">Rubryka</p>
                            <p class="_value pull-right"><?= $zmiana->getData('numer_rubryki') ?></p>                                
                        </li>
                        
                        <li class="dataHighlight">
                            <p class="_label pull-left">Rejestr</p>
                            <p class="_value pull-right"><?= $zmiana->getData('rejestr_nr') ?></p>                                
                        </li>
						
						<? /*
	                    <li class="dataHighlight">
	                        <a href="/interpelacje"><span
	                                class="icon icon-moon">&#xe614;</span>Interpelacje <span
	                                class="glyphicon glyphicon-chevron-right"></a>
	                    </li>
	                    */ ?>
					
					</ul>
                    
                </div>
				

                <div class="block">

                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a target="_blank" href="/dane/msig_dzialy/<?= $zmiana->getData('dzial_id') ?>"><span
                                    class="glyphicon glyphicon-link"></span>MSiG<span
                                    class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                    </ul>

                </div>


            </div>
        </div>

        <div class="col-lg-9 nopadding">
            <div class="object">
				
				<? if( $details = $zmiana->getLayer('details') ) {?>		
                
                <? if( $details['data'] ) {?>
                <div class="block">
	                <div class="block-header">
		                <h2 class="label">Zmiany</h2>
	                </div>
	                <div class="content">
		                <?= $this->element('Dane.objects/krs_podmioty_zmiany/' . $zmiana->getData('typ_id'), array(
		                	'data' => $details['data'],
		                )); ?>
	                </div>
	            
                </div>
                <? } ?> 
                
                <? if( $details['tresc'] ) {?>
                <div class="block">
	                <div class="block-header">
		                <h2 class="label">Oryginalna treść</h2>
	                </div>
	                <div class="content">
		                <?= $details['tresc'] ?>
	                </div>
	            
                </div>
                <? } ?> 
                <? } ?>

            </div>
        </div>

    </div>

<? echo $this->Element('dataobject/pageEnd');