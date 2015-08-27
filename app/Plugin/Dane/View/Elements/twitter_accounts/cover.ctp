<div class="mediaHighstockPicker">
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
		<? if( @$dataBrowser['aggs']['tweets']['timerange']['top']['hits']['hits'] ) { ?>
		    <div class="block col-xs-12">
		        <header>Najpopularniejsze tre?ci na Twitterze:</header>
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
	            <header>Najcz??ciej u?ywane aplikacje:</header>
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