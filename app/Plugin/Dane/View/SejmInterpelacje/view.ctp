<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejminterpelacje', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'toolbar'); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

<div class="row">
	<div class="col-xs-12 col-md-3">
	    
	    <div class="dataFeed">
		    <div class="object col-feed-main">
			    <h2>Dokumenty</h2>
		        <? echo $this->Element('Dane.DataFeed/feed-min', array(
			    	'selected' => array(
				    	'dataset' => $dokument->getDataset(),
				    	'id' => $dokument->getId(),
			    	),
			    	'theme' => $dokument->getDataset(),
			    )); ?>
		    </div>
	    </div>
	    
	    
	</div>
	<div class="col-xs-12 col-md-9 objectMain">
	    <div class="object">
	        
	        <?
            if ( !($dokument->getLayer('teksty')) && $dokument->getData('dokument_id')) {

                echo $this->Document->place($dokument->getData('dokument_id'));

            } else {
                ?>

                <? foreach ($dokument->getLayer('teksty') as $tekst) { ?>
                    <div class="block" style="margin: 20px 0;">
                        <div class="block-header">
                            <h2 class="label"><?= $dokument->getData('nazwa') ?></h2>
                        </div>
                        <div class="content" style="margin: 25px;">
                            <?= $tekst['html'] ?>
                        </div>
                    </div>
                <? } ?>

            <? } ?>
	        
	    </div>
	</div>
</div>


<?= $this->Element('dataobject/pageEnd'); ?>