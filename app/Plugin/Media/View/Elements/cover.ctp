<?

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('media-cover', array('plugin' => 'Media')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Media.media-cover');

$options = array(
    'mode' => 'init',
);

?>

<div class="col-xs-12 col-md-3 dataAggsContainer">
    <div class="sticky">
	    <? echo $this->Element('Dane.DataBrowser/aggs', array(
	        	'data' => $dataBrowser,
	    )); ?>

        <? if(isset($twitterAccountTypes)) { ?>
	        <?= $this->Element('Media.twitter-account-suggestion', array(
	            'types' => $twitterAccountTypes
	        )); ?>
	    <? } ?>
    </div>
</div>

<div class="col-xs-12 col-md-9">

	<div class="dataWrap">

		<div class="appBanner">
			<h1 class="appTitle">Media społecznościowe</h1>
			<p class="appSubtitle">Zobacz kto i jak wykorzystuje media społecznościowe w debacie publicznej.</p>
		</div>

	</div>

	<div id="accountsSwitcher" class="appMenuStrip row">
		
	    <? if(isset($twitterAccountTypes) && isset($twitterAccountType)) { ?>
	        <div class="appSwitchers">
		        <div class="dataWrap">
			        <p class="_label">Analizowane konta:</p>
			        <ul class="nav nav-pills">
			            <? foreach($twitterAccountTypes as $type => $label) { ?>
			                <li<? if($twitterAccountType == $type) echo ' class="active"' ?>>
			                    <a href="/media<? if($type != '0') echo '?type=' . $type ?>">
			                        <?= $label ?>
			                    </a>
			                </li>
			            <? } ?>
			        </ul>
		        </div>
	        </div>
	    <? } ?>
	    
	    <? if(isset($twitterTimeranges) && isset($twitterTimerange)) { ?>
	    	<div class="appSwitchers">
		        <div class="dataWrap">
			        <p class="_label">Analizowany zakres:</p>
			        <ul class="nav nav-pills">
			            <? foreach($twitterTimeranges as $type => $label) { ?>
			                <li<? if($twitterTimerange == $type) echo ' class="active"' ?>>
			                    <a href="/media<? if($type != '0') echo '?type=' . $type ?>">
			                        <?= $label ?>
			                    </a>
			                </li>
			            <? } ?>
			        </ul>
		        </div>
	        </div>
	    <? } ?>
	    
	</div>

    <div class="mediaHighstockPicker row">
        <div class="chart" data-aggs='<?= json_encode($dataBrowser['aggs']['tweets']['histogram']['histogram']) ?>'>
            <div class="spinner grey">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="text-center">
            <a href="#"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Zastosuj</a>
        </div>
    </div>
	
	<div class="dataWrap">
		<? 
		if( $hits = @$dataBrowser['aggs']['tweets']['timerange']['top']['hits']['hits'] ) { 
			
			$docs = array();
			foreach( $hits as $hit )
				$docs[ $hit['fields']['date'][0] ] = $hit;
			
			unset( $hits );
			krsort($docs);
			$docs = array_values($docs);			
				
		?>
		    <div class="block col-xs-12">
		        <header>Najpopularniejsze treści na Twitterze:</header>
		        <section class="aggs-init">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <ul class="dataobjects">
		                        <? foreach($docs as $doc) { ?>
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
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150" data-image_field="image_url" data-label_field="name"
	                         data-counter_field="engagement_count" data-choose-request="media?conditions[twitter.twitter_account_id]="
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['timerange']['accounts'])) ?>">
	                        <div class="chart"></div>
	                    </div>
	                </div>
	            </section>
		    </div>
	    <? } ?>
	</div>

	    <? if(@$dataBrowser['aggs']['tweets']['timerange']['tags']['tags']) { ?>
	        <div class="block col-xs-12">

	            <header>
		            <div class="dataWrap">Najpopularniejsze hashtagi</div>
		        </header>

	            <section class="aggs-init">
	                <ul id="tagsCloud">
	                    <? $tags = $dataBrowser['aggs']['tweets']['timerange']['tags']['tags'];
	                    foreach($tags['buckets'] as $tag) { ?>
	                        <li style="font-size: <?= (($tag['doc_count'] + 2) * 8) ?>px;">
	                            <a href="/media/tweety?conditions[twitter.tags]=<?= $tag['key'] ?>">
	                                <?= $tag['label']['buckets'][0]['key'] ?>
	                            </a>
	                        </li>
	                    <? } ?>
	                </ul>
	            </section>
	        </div>
            <p></p>
	    <? } ?>

	<div class="dataWrap">

	    <? if(@$dataBrowser['aggs']['tweets_whitout_account_type_id']['types']['buckets']) { ?>
	        <div class="block col-xs-12">
	            <header>Najczęściej używane aplikacje:</header>
	            <section class="aggs-init margin-sides-10">
	                <div class="row">
		                <? foreach( $dataBrowser['aggs']['tweets_whitout_account_type_id']['types']['buckets'] as $b ) { ?>
		                <div class="block-source col-sm-4">
			                <p class="label label-primary"><?= $twitterAccountTypes[ $b['key'] ] ?></p>
			                <ul class="list-group reset">
				                <? foreach($b['sources']['buckets'] as $s) { ?>
				                <li class="list-group-item">
				                	<span class="badge"><?= $s['label']['buckets'][0]['doc_count'] ?></span>
				                	<?= $s['label']['buckets'][0]['key'] ?>
				                </li>
				                <? } ?>
			                </ul>
		                </div>

		                <? } ?>
	                </div>
	            </section>
	        </div>
	    <? } ?>

	</div>

</div>
