<?
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>

<div class="col-xs-12 col-md-3 dataAggsContainer">
    <? echo $this->Element('Dane.DataBrowser/aggs', array(
        	'data' => $dataBrowser,
    )); ?>
</div>

<div class="col-xs-12 col-md-9">
		
	<? if( @$dataBrowser['aggs']['tweets']['timerange']['top']['hits']['hits'] ) { ?>
	    <div class="block col-xs-12">
	        <header>Najpopularniejsze treści na Twitterze</header>
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-Dataobjects">
	                    <ul class="dataobjects">
	                        <? foreach ($dataBrowser['aggs']['tweets']['timerange']['top']['hits']['hits'] as $doc) { ?>
	                            <li>
	                                <?= $this->Dataobject->render($doc, 'default') ?>
	                            </li>
	                        <? } ?>
	                    </ul>
	                </div>
	            </div>
	        </section>
	    </div>
    <? } ?>
    
	<? if( @$dataBrowser['aggs']['tweets']['timerange']['accounts']['buckets'] ) { ?>
		<div class="block col-xs-12">
	        <header>Najpopularniejsze konta na Twitterze</header>
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-Dataobjects">
	                    <ul class="dataobjects">
	                        <? foreach ($dataBrowser['aggs']['tweets']['timerange']['accounts']['buckets'] as $doc) { ?>
	                            <li>
	                                <? 
		                                
		                                $doc = array(
			                                'id' => $doc['key'],
			                                'name' => $doc['name']['buckets'][0]['key'],
			                                'type' => $doc['account_type']['buckets'][0]['key'],
			                                'image_url' => $doc['image_url']['buckets'][0]['key'],
			                                'count' => $doc['doc_count'],
			                                'engagement_count' => $doc['engagement_count']['value'],
		                                );
		                                
		                                debug($doc);
		                            ?>
	                            </li>
	                        <? } ?>
	                    </ul>
	                </div>
	            </div>
	        </section>
	    </div>
    <? } ?>

    
</div>