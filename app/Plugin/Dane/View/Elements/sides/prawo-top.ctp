<?
	$this->Combinator->add_libs('css', $this->Less->css('view-prawo', array('plugin' => 'Dane')));
?>

<div class="objectSideInner">
	
	<div class="row">
		<div class="col-md-12">
	
		    <div class="block nobg noborder fix">
		        <ul class="dataHighlights row">
					
					
					<? if ($object->getData('sygnatura')) { ?>
		                <li class="dataHighlight col-sm-3">
		                    <p class="_label">Sygnatura</p>
		
		                    <p class="_value"><?= $object->getData('sygnatura'); ?></p>
		                </li>
		            <? } ?>
		            
		            <? if ($object->getData('isap_status_str')) { ?>
		                <li class="dataHighlight col-sm-3">
		                    <p class="_label">Status</p>
		
		                    <p class="_value"><?= $object->getData('isap_status_str'); ?></p>
		                </li>
		            <? } ?>
		           		
		            <? if ($object->getData('data_wydania') && ($object->getData('data_wydania') != '0000-00-00')) { ?>
		                <li class="dataHighlight col-sm-3">
		                    <p class="_label">Data wydania</p>
		
		                    <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wydania')); ?></p>
		                </li>
		            <? } ?>
					
		            <? /* if ($object->getData('data_publikacji') && ($object->getData('data_publikacji') != '0000-00-00')) { ?>
		                <li class="dataHighlight col-sm-3">
		                    <p class="_label">Data publikacji</p>
		
		                    <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_publikacji')); ?></p>
		                </li>
		            <? } */ ?>
		
		            <? if ($object->getData('data_wejscia_w_zycie') && ($object->getData('data_wejscia_w_zycie') != '0000-00-00')) { ?>
		                <li class="dataHighlight col-sm-2">
		                    <p class="_label">Data wejścia w życie</p>
		
		                    <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wejscia_w_zycie')); ?></p>
		                </li>
		            <? } ?>
					
					<? /*
		            <li class="dataHighlight col-sm-1">
		                <p class="_label">Źródło</p>
		
		                <p class="_value sources">
		                    <?
		                    $isap_str = 'W';
		                    if ($object->getData('zrodlo') == 'DzU') {
		                        $isap_str .= 'DU';
		                    } elseif ($object->getData('zrodlo') == 'MP') {
		                        $isap_str .= 'MP';
		                    }
		
		                    $isap_str .= $object->getData('rok');
		                    $isap_str .= str_pad($object->getData('nr'), 3, "0", STR_PAD_LEFT);
		                    $isap_str .= str_pad($object->getData('poz'), 4, "0", STR_PAD_LEFT);
		                    ?>
		                    <a itemprop="sameAs" href="http://isap.sejm.gov.pl/DetailsServlet?id=<?= $isap_str ?>"
		                       target="_blank">ISAP</a>
		                </p>
		            </li>
					*/ ?>
					
		        </ul>
		    </div>
    
		</div>
	</div>

</div>