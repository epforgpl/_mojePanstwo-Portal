<? if (@$data['aggregations']['announcements']['range']['stats']) { ?>
	<div class="agg stats" data-agg_id="stats">
		<? if( $data['aggregations']['announcements']['range']['stats']['count'] || $data['aggregations']['announcements']['range']['stats']['sum'] ) {?>
		<div class="row">
			<div class="col-md-12">
				<p><?= pl_dopelniacz($data['aggregations']['announcements']['range']['stats']['count'], 'rozstrzygnięcie', 'rozstrzygnięcia', 'rozstrzygnięć') ?>, na sumę <strong><?= number_format_h($data['aggregations']['announcements']['range']['stats']['sum']) ?> PLN</strong></p>
			</div>
		</div>
		<? } ?>
	</div>
<? } ?>

<? if (@$data['hits']['hits']) { ?>
	<div class="agg agg-Dataobjects dokumenty" data-agg_id="dokumenty">
	    <? if (@$data['hits']['hits']) { ?>
	        <ul class="dataobjects">
	            <? foreach ($data['hits']['hits'] as $doc) {?>
	                <li>
	                    <?
	                      echo $this->Dataobject->render($doc);
	                    ?>
	                </li>
	            <? } ?>
	        </ul>
	    <? } ?>
	</div>
<? } ?>

<? if (@$data['aggregations']['announcements']['range']['contractors']['ranking']['buckets']) {
	echo $this->element('Dane.DataBrowser/zamowienia_publiczne-wykonawcy', array(
        'id' => 'wykonawcy',
        'data' => $data['aggregations']['announcements']['range']['contractors']['ranking'],
        'map' => array(
            'chooseRequest' => '#',
            'field' => 'wykonawca_id',
        ),
    ));
} ?>