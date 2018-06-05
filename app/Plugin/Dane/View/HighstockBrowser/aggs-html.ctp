<? if (@$aggs['stats']) { ?>
	<div class="agg stats" data-agg_id="stats">
		<? if( $aggs['stats']['count'] || $aggs['stats']['sum'] ) {?>
		<div class="row">
			<div class="col-md-12">
				<p><?= pl_dopelniacz($aggs['stats']['count'], 'umowa', 'umowy', 'umów') ?>, na sumę <strong><?= number_format_h($aggs['stats']['sum']) ?> PLN</strong></p>
			</div>
		</div>
		<? } ?>
	</div>
<? } ?>

<? if (@$aggs['umowy']) { ?>
	<div class="agg agg-Dataobjects dokumenty" data-agg_id="dokumenty">
	    <? if (@$aggs['umowy']['hits']['hits']) { ?>
	        <ul class="dataobjects">
	            <? foreach ($aggs['umowy']['hits']['hits'] as $doc) {?>
	                <li>
	                    <?
	                      echo $this->Dataobject->render($doc, 'default', array(
		                      'truncate' => 10000,
	                      ));
	                    ?>
	                </li>
	            <? } ?>
	        </ul>
	    <? } ?>
	</div>
<? } ?>

<? if (@$aggs['wykonawcy']['buckets']) { 
	$id = 'wykonawcy';	
?>
	
	<div class="agg agg-ColumnsHorizontal"<? if( isset($id) ){?> data-agg_id=<?= $id ?><? } ?> data-choose-request="#"
         data-chart="<?= htmlentities(json_encode($aggs['wykonawcy'])) ?>" data-counter_field="<?= 'wartosc_brutto' ?>">
        <div class="chart"></div>
    </div>
	
<? } ?>

<? if (@$aggs['rodzaje_budzet']['buckets']) { 
	$id = 'rodzaje_budzet';	
?>
	
	<div class="agg agg-PieChart"<? if( isset($id) ){?> data-agg_id=<?= $id ?><? } ?> data-choose-request="#"
         data-chart="<?= htmlentities(json_encode($aggs['rodzaje_budzet'])) ?>" data-counter_field="<?= 'wartosc_brutto' ?>">
        <div class="chart"></div>
    </div>
	
<? } ?>

<? if (@$aggs['rodzaje_wolumen']['buckets']) { 
	$id = 'rodzaje_wolumen';	
?>
	
	<div class="agg agg-PieChart"<? if( isset($id) ){?> data-agg_id=<?= $id ?><? } ?> data-choose-request="#"
         data-chart="<?= htmlentities(json_encode($aggs['rodzaje_wolumen'])) ?>">
        <div class="chart"></div>
    </div>
	
<? } ?>

<? if (@$aggs['jednostki']['buckets']) { 
	$id = 'jednostki';	
?>
	
	<div class="agg agg-PieChart"<? if( isset($id) ){?> data-agg_id=<?= $id ?><? } ?> data-choose-request="#"
         data-chart="<?= htmlentities(json_encode($aggs['jednostki'])) ?>">
        <div class="chart"></div>
    </div>
	
<? } ?>

<? if (@$aggs['tryby']['buckets']) { 
	$id = 'tryby';	
?>
	
	<div class="agg agg-PieChart"<? if( isset($id) ){?> data-agg_id=<?= $id ?><? } ?> data-choose-request="#"
         data-chart="<?= htmlentities(json_encode($aggs['tryby'])) ?>">
        <div class="chart"></div>
    </div>
	
<? } ?>