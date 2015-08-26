<? echo $this->Element('dataobject/pageBegin'); ?>

	<div class="row">
		<div class="col-md-9">
	
		    <div class="block block-simple col-xs-12">
		        <header>Główne parametry budżetu:</header>
		        <section class="aggs-init margin-sides-20">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    
		                    <? // debug($object->getData()) ?>
		                    
		                </div>
		            </div>
		        </section>
		    </div>
		    
		    <div class="block block-simple col-xs-12">
		        <header>Wydatki według działów:</header>
		        <section class="aggs-init margin-sides-20">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    
		                    
		                </div>
		            </div>
		        </section>
		    </div>
    
		</div><div class="col-md-3">

            <ul class="dataHighlights rightColumn margin-top-15">
        	<?
			    $isap_status_str = $object->getData('prawo.isap_status_str');
			    if (isset($isap_status_str) && !empty($isap_status_str)) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Status</p>

			            <p class="_value"><?= $isap_status_str; ?></p>
			        </li>
			    <? } ?>

			    <?
			    $data_wydania = $object->getData('prawo.data_wydania');
			    if (isset($data_wydania) && !empty($data_wydania) && ($data_wydania != '0000-00-00')) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Data wydania</p>

			            <p class="_value"><?= $this->Czas->dataSlownie($data_wydania); ?></p>
			        </li>
			    <? } ?>

			    <?
			    $data_wejscia_w_zycie = $object->getData('prawo.data_wejscia_w_zycie');
			    if (isset($data_wejscia_w_zycie) && !empty($data_wejscia_w_zycie) && ($data_wejscia_w_zycie != '0000-00-00')) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Data wejścia w życie</p>

                        <p class="_value"><?= $this->Czas->dataSlownie($data_wejscia_w_zycie); ?></p>
			        </li>
			    <? } ?>

                <?
			    if ( $organ = $object->getData('prawo.isap_organ_wydajacy_str') ) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Organ wydający</p>

                        <p class="_value"><?= $organ ?></p>
			        </li>
                <? } ?>
        	</ul>

        </div>
	</div>

<?= $this->Element('dataobject/pageEnd'); ?>
