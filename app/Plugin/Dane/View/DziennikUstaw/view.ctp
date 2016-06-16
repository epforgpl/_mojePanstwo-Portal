<? echo $this->Element('dataobject/pageBegin'); ?>


    <div class="row">

        <div class="object col-md-9">
            <?= $this->Document->place($object->getData('dokument_id')) ?>
        </div><div class="col-md-3">

            <ul class="dataHighlights overflow-auto margin-top-10">
        	<?
			    $isap_status_str = $object->getData('isap_status_str');
			    if (isset($isap_status_str) && !empty($isap_status_str)) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Status</p>

			            <p class="_value"><?= $isap_status_str; ?></p>
			        </li>
			    <? } ?>

			    <?
			    $data_wydania = $object->getData('data_wydania');
			    if (isset($data_wydania) && !empty($data_wydania) && ($data_wydania != '0000-00-00')) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Data wydania</p>

			            <p class="_value"><?= $this->Czas->dataSlownie($data_wydania); ?></p>
			        </li>
			    <? } ?>

			    <?
			    $data_wejscia_w_zycie = $object->getData('data_wejscia_w_zycie');
			    if (isset($data_wejscia_w_zycie) && !empty($data_wejscia_w_zycie) && ($data_wejscia_w_zycie != '0000-00-00')) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Data wejścia w życie</p>

                        <p class="_value"><?= $this->Czas->dataSlownie($data_wejscia_w_zycie); ?></p>
			        </li>
			    <? } ?>

                <?
			    if ( $organ = $object->getData('isap_organ_wydajacy_str') ) { ?>
                    <li class="dataHighlight col-xs-12">
			            <p class="_label">Organ wydający</p>

                        <p class="_value"><?= $organ ?></p>
			        </li>
                <? } ?>
        	</ul>
        	
        	
        	<?
	        	$isap_id = 'W';
	        	$isap_id .= ($object->getData('zrodlo')=='MP') ? 'MP' : 'DU';
	        	$isap_id .= str_pad($object->getData('rok'), 4, '0', STR_PAD_LEFT);
	        	$isap_id .= str_pad($object->getData('nr'), 3, '0', STR_PAD_LEFT);
	        	$isap_id .= str_pad($object->getData('poz'), 4, '0', STR_PAD_LEFT);	        	
        	?>
        	
        	<div class="margin-top-20">
	        	<p class="_src text-left"><a href="http://dziennikustaw.gov.pl/DU/<?= $object->getData('rok') ?>/<?= $object->getData('poz') ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> Źródło (RCL)</a></p>
	        	<p class="_src text-left"><a href="http://isap.sejm.gov.pl/DetailsServlet?id=<?= $isap_id ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> Źródło (ISAP)</a></p>
        	</div>
        	

        </div>


    </div>


<?= $this->Element('dataobject/pageEnd'); ?>
