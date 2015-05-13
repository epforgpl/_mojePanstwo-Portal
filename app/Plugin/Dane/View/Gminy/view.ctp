<?php $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'jquery-tags-cloud-min'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-gminy'); ?>

<?php if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.exp', array('block' => 'scriptBlock'));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
} ?>

<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">
	<div class="col-md-9 objectMain">
	    <div class="object dataBrowser">
	    
		    <div class="block">
		        <div class="block-header">
		            <h2 class="label">Najnowsze prawo lokalne</h2>
		        </div>
		        
		        <div class="aggs-init">
										
					<div class="dataAggs">
						<div class="agg agg-Dataobjects">
						    <? if( $object_aggs['all']['gminy']['top']['hits']['hits'] ) {?>
						    <ul class="dataobjects">
							    <? foreach( $object_aggs['all']['gminy']['top']['hits']['hits'] as $doc ) {?>
							    <li>
								<?
									echo $this->Dataobject->render($doc, 'default');
								?>
							    </li>
							    <? } ?>
						    </ul>
						    <div class="buttons">
								<a href="#" class="btn btn-primary btn-sm">Zobacz więcej</a>
							</div>
						    <? } ?>
						    
						</div>
					</div>
					
					
							
				</div>
		        
		    </div>
	    
	    </div>
	</div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
