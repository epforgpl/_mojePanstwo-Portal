<?

$this->Combinator->add_libs('css', $this->Less->css('media-cover', array('plugin' => 'Media')));

$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Media.media-cover');

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

    <? if(isset($twitterAccountTypes) && isset($twitterAccountType)) { ?>
        <ul class="nav nav-pills margin-top-15">
            <? foreach($twitterAccountTypes as $type => $label) { ?>
                <li<? if($twitterAccountType == $type) echo ' class="active"' ?>>
                    <a href="/media<? if($type != '0') echo '?type=' . $type ?>">
                        <?= $label ?>
                    </a>
                </li>
            <? } ?>
        </ul>
    <? } ?>

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
                    <div class="agg agg-ColumnsHorizontal" data-image_field="image_url" data-label_field="name"
                         data-counter_field="engagement_count" data-choose-request="media?conditions[twitter.twitter_account_id]="
                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['timerange']['accounts'])) ?>">
                        <div class="chart"></div>
                    </div>
                </div>
            </section>
	    </div>
    <? } ?>
	
	<? // debug( @$dataBrowser['aggs']['tweets']['timerange']['tags']['tags'] ); ?>
	<? // debug( @$dataBrowser['aggs']['tweets']['timerange']['sources']['buckets'] ); ?>
	
    <!--<div class="block col-xs-12">
        <header>Najpopularniejsze hashtagi</header>
        <section class="aggs-init">
            <ul id="tagsCloud">

            </ul>
        </section>
    </div>-->

</div>
