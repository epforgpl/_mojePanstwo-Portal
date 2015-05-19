<div class="objectSideInner">
      
    <div class="row">
		<div class="col-md-12">
	
		    <div class="block nobg noborder fix">
		        <ul class="dataHighlights row">
    
					
			        <li class="dataHighlight -block col-md-12" style="margin-bottom: -5px;">
			            <?
			            if ($object->getData('status_id') == '0') {
			                ?>
			                <span class="label label-success">Zamówienie otwarte</span>
			            <?
			            } elseif ($object->getData('status_id') == '2') {
			                ?>
			                <span class="label label-danger">Zamówienie rozstrzygnięte</span>
			            <?
			            }
			            ?>
			            
			            <? if($object->getData('wartosc_cena')) {?>
			            <span style="color: green; margin-left: 3px;">na kwotę <?= number_format_h($object->getData('wartosc_cena')); ?> PLN</span>
			            <? } ?>
			            
			        </li>
			        		        
		
			
			        

			    </ul>

		    </div>
		</div>
    </div>  
     
    <div class="row">
		<div class="col-md-6">
	
		    <div class="block nobg noborder fix">
		        <ul class="dataHighlights row">
    
					<li class="dataHighlight inl col-md-12">
			            <p class="_label pull-left">Zamawiający</p>
			
			            <p class="_value"><a
			                    href="/dane/zamowienia_publiczne_zamawiajacy/<?= $object->getData('zamawiajacy_id'); ?>"><?= $object->getData('zamawiajacy_nazwa'); ?></a></p>
			        </li>
			        
			        <li class="dataHighlight inl col-md-12">
			            <p class="_label pull-left">Tryb</p>
			
			            <p class="_value"><?= $object->getData('zamowienia_publiczne_tryby.nazwa') ?></p>
			        </li>
					
					<? /* if (($object->getData('kryterium_kod') == 'A') || ($object->getData('kryterium_kod') == 'B')) { ?>
			            <li class="dataHighlight col-md-12">
			                <p class="_label">Kryteria</p>
			
			                <? if ($object->getData('kryterium_kod') == 'A') { ?>
			                    <p class="_value">Najniższa cena</p>
			                <? } elseif (($object->getData('kryterium_kod') == 'B') && !empty($details['kryteria'])) { ?>
			
			                    <ul class="_value ulx">
			                        <? foreach ($details['kryteria'] as $kryterium) { ?>
			                            <li><?= $kryterium['nazwa'] ?> - <?= $kryterium['punkty'] ?>%</li>
			                        <? } ?>
			                    </ul>
			
			                <? } ?>
			
			            </li>
			
					<? } */ ?>
			        
			        <? /*
			        <li class="dataHighlight col-md-12">
			            <p class="_label">Tryb</p>
			
			            <p class="_value"><?= $object->getData('zamowienia_publiczne_tryby.nazwa') ?></p>
			        </li>
					*/ ?>
	

			    </ul>

		    </div>
		</div>
		<div class="col-md-6">
	
		    <div class="block nobg noborder fix">
		        <ul class="dataHighlights row">
					 
					<? if( $object_aggs['all']['dokumenty']['wykonawcy']['top']['buckets'] ) {?>   
					<li class="dataHighlight col-md-12">
			            <p class="_label">Wykonawcy</p>
						
						<? foreach( $object_aggs['all']['dokumenty']['wykonawcy']['top']['buckets'] as $b ) { ?>
						
			            <p class="_value"><a href="#"><?= $b['nazwa']['buckets'][0]['key'] ?></a> - <?= number_format_h($b['cena']['value']) ?> <?= $b['waluta']['buckets'][0]['key'] ?></p>
			            
			            <? } ?>
			        </li>
					<? } ?>
			        
			        
			        <? /*
			        <li class="dataHighlight col-md-12">
			            <p class="_label">Rodzaj</p>
			
			            <p class="_value"><?= $object->getData('zamowienia_publiczne_rodzaje.nazwa') ?></p>
			        </li>
					*/ ?>

			    </ul>

		    </div>
		</div>
    </div>
    
    

</div>