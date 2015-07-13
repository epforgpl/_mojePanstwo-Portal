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
	                      echo $this->Dataobject->render($doc, 'default');
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