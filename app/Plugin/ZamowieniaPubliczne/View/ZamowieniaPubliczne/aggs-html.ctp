<? if (@$data['aggregations']['stats']) { ?>
	<div class="agg stats" data-agg_id="stats">
		<? if( $data['aggregations']['stats']['count'] || $data['aggregations']['stats']['sum'] ) {?>
		<div class="row">
			<div class="col-md-12">
				<p><?= pl_dopelniacz($data['aggregations']['stats']['count'], 'zamówienie', 'zamówienia', 'zamówień') ?>, na sumę <strong><?= number_format_h($data['aggregations']['stats']['sum']) ?> PLN</strong></p>
			</div>
		</div>
		<? } ?>
	</div>
<? } ?>

<? if (@$data['aggregations']['dokumenty']) { ?>
	<div class="agg agg-Dataobjects dokumenty" data-agg_id="dokumenty">
	    <? if (@$data['aggregations']['dokumenty']['hits']['hits']) { ?>
	        <ul class="dataobjects">
	            <? foreach ($data['aggregations']['dokumenty']['hits']['hits'] as $doc) {?>
	                <li>
	                    <?
	                      echo $this->Dataobject->render($doc, 'zamowienia_publiczne_dokumenty');
	                    ?>
	                </li>
	            <? } ?>
	        </ul>
	    <? } ?>
	</div>
<? } ?>

<? if (@$data['aggregations']['wykonawcy']['wykonawca']['buckets']) {
	echo $this->element('Dane.DataBrowser/zamowienia_publiczne-wykonawcy', array(
        'id' => 'wykonawcy',
        'data' => $data['aggregations']['wykonawcy']['wykonawca'],
        'map' => array(
            'chooseRequest' => '#',
            'field' => 'wykonawca_id',
        ),
    ));
} ?>