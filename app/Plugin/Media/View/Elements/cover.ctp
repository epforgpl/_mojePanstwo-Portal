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
	    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>

		<? /*
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
	    */ ?>

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

	    <? if(isset($twitterTimeranges) && isset($twitterTimerange)) { ?>
	    	<div class="appSwitchers">
		        <div class="dataWrap">
			        <div class="pull-left">
				        <p class="_label">Analizowany okres:</p>
				        <ul class="nav nav-pills">
				            <? foreach($twitterTimeranges as $key => $value) { ?>
				                <li<? if($twitterTimerange == $key) echo ' class="active"' ?>>
				                    <a href="/media?t=<?= $key ?>">
				                        <?= $value ?>
				                    </a>
				                </li>
				            <? } ?>
				        </ul>
			        </div>
			        <div class="pull-right">
				        <ul class="nav nav-pills">
			                <li<? if( isset($this->request->query['t']) && ($this->request->query['t']==$last_month_report['param']) ) echo ' class="active"' ?>>
			                    <a href="/media?t=<?= $last_month_report['param'] ?>"><?= $last_month_report['label'] ?></a>
			                </li>

                            <? if(isset($dropdownRanges)) { ?>
                                <li<? if($twitterTimerange == $key) echo ' class="active"' ?>>
                                    <div class="dropdown">
                                        <button class="clear dropdown-toggle" type="button" id="dropdownRanges" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Więcej <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownRanges">
                                            <? foreach($dropdownRanges as $dropdown) { ?>
                                                <li class="dropdown-title"><?= $dropdown['title'] ?></li>
                                                <? foreach($dropdown['ranges'] as $range) { ?>
                                                    <li<? if($twitterTimerange == $range['param'] && strlen($twitterTimerange) === strlen($range['param'])) echo ' class="active"'; ?>>
                                                        <a href="/media?t=<?= $range['param'] ?>">
                                                            <?= $range['label'] ?>
                                                        </a>
                                                    </li>
                                                <? } ?>
                                            <? } ?>
                                        </ul>
                                    </div>
                                </li>
                            <? } ?>
				        </ul>
			        </div>
		        </div>
	        </div>
	    <? } ?>

	</div>

    <div class="mediaHighstockPicker row">
        <div class="chart" data-aggs='<?= json_encode($dataBrowser['aggs']['tweets']['global_timerange']['selected_accounts']['histogram']) ?>' data-xmax='<?= json_encode(isset($timerange['xmax']) ? $timerange['xmax'] : false) ?>' data-range='<?= json_encode($timerange['range']) ?>'>
            <div class="spinner grey">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="dataWrap">
            <div class="range">
                <div class="row">
                    <div class="col-md-4">
                        <p class="display"><?= $this->Czas->dataSlownie($timerange['labels']['min']) ?> <span class="separator">&mdash;</span> <?= $this->Czas->dataSlownie($timerange['labels']['max']) ?></p>
                    </div>
                    <div class="col-md-8">
                        <a href="#" class="switcher hidden">
                            <i class="icon" data-icon="&#xe604;"></i>
                            Zastosuj
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="dataWrap">


		<?
		if( $hits = @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['top']['hits']['hits'] ) {

			if( $timerange['init'] ) {
				$docs = array();
				foreach( $hits as $hit )
					$docs[ $hit['fields']['date'][0] ] = $hit;

				unset( $hits );
				krsort($docs);
				$docs = array_values($docs);
			} else {
				$docs = $hits;
			}

		?>
		    <div class="block col-xs-12">
		        <header>Najbardziej angażujące tweety:</header>
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


		<? if( @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement']['buckets'] ) { ?>
			<div class="block col-xs-12">
		        <header>Najbardziej angażujące profile:</header>
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150" data-image_field="image_url" data-label_field="name"
	                         data-counter_field="engagement_count" data-choose-request="media?conditions[twitter.twitter_account_id]="
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement'])) ?>">
	                        <div class="chart"></div>
	                    </div>
	                </div>
	            </section>
		    </div>
	    <? } ?>

	    <? if( @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_tweets']['buckets'] ) { ?>
			<div class="block col-xs-12">
		        <header>Najwięcej tweetów napisali:</header>
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150" data-image_field="image_url" data-label_field="name" data-choose-request="media?conditions[twitter.twitter_account_id]="
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_tweets'])) ?>">
	                        <div class="chart"></div>
	                    </div>
	                </div>
	            </section>
		    </div>
	    <? } ?>

	    <? if( @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement_tweets']['buckets'] ) { ?>
			<div class="block col-xs-12">
		        <header>Najwięcej zaangażowania w przeliczeniu na 1 tweeta:</header>
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150" data-image_field="image_url" data-label_field="name" data-counter_field="engagement_count" data-choose-request="media?conditions[twitter.twitter_account_id]="
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement_tweets'])) ?>">
	                        <div class="chart"></div>
	                    </div>
	                </div>
	            </section>
		    </div>
	    <? } ?>


	    <? if( @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['mentions']['accounts']['ids']['buckets'] ) { ?>
			<div class="block col-xs-12">
		        <header>Najczęściej wzmiankowani:</header>
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150" data-label_field="name" data-choose-request="media?conditions[twitter.twitter_account_id]="
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['mentions']['accounts']['ids'])) ?>">
	                        <div class="chart"></div>
	                    </div>
	                </div>
	            </section>
		    </div>
	    <? } ?>




	</div>

	    <?
	    if( $tags = @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['tags']['tags']['buckets'] ) {

			$max = 0;
			foreach( $tags as $t )
				if( $t['rn']['engagement_count']['value'] > $max )
					$max = $t['rn']['engagement_count']['value'];

			if( !$max )
				$max = 1;

	    ?>
	        <div class="block col-xs-12">

	            <header>
		            <div class="dataWrap">Najbardziej angażujące hashtagi:</div>
		        </header>

	            <section class="aggs-init">
	                <ul id="tagsCloud">
	                    <? foreach($tags as $tag) { ?>
	                        <li style="font-size: <?= 20 + (70 * $tag['rn']['engagement_count']['value'] / $max) ?>px;">
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
