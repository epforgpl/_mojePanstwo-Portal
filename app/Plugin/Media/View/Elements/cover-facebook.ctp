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
<? if (isset($twitterAccountTypes)) { ?>
    <?= $this->Element('Media.twitter-account-suggestion-modal', array(
        'types' => $twitterAccountTypes
    )); ?>
<? } ?>

<script type="text/javascript">
	var _medium = '<?= $medium ?>';
</script>

<div class="col-xs-12">

    <div class="appBanner">
        <h1 class="appTitle">Państwo w mediach społecznościowych</h1>
        <p class="appSubtitle">Zobacz kto i jak wykorzystuje media społecznościowe w debacie publicznej.</p>
		
		<form action="" method="get">
	        <div class="appSearch form-group">
				<div class="input-group">
					<input name="q" class="form-control" placeholder="Szukaj w mediach społecznościowych..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
	                        <span class="glyphicon glyphicon-search"></span>
	                    </button>
					</span>
				</div>
	        </div>
		</form>
    </div>
    
    <div id="mediumSwitcher">
	    <ul>
		    <li>
			    <a title="Analizuj aktywność na Twitterze" href="?medium=twitter"><img title="Twitter" src="/media/img/twitter<? if( $medium == 'twitter' ) {?>-active<? } ?>.svg" /></a>
		    </li>
		    <li>
			    <a title="Analizuj aktywność na Facebooku" href="?medium=facebook"><img title="Facebook" src="/media/img/facebook<? if( $medium == 'facebook' ) {?>-active<? } ?>.svg" /></a>
		    </li>
	    </ul>
    </div>
    
    <div id="accountsSwitcher" class="appMenuStrip">
        <? if (isset($twitterTimeranges) && isset($twitterTimerange)) { ?>
            <div class="appSwitchers">
                
                <div class="pull-left">
                    <p class="_label">Analizowany okres:</p>
                    <ul class="nav nav-pills">
                        <? foreach ($twitterTimeranges as $key => $value) { ?>
                            <li<? if ($twitterTimerange == $key) echo ' class="active"' ?>>
                                <a href="/media?t=<?= $key ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>&medium=facebook">
                                    <?= $value ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </div>
                <div class="pull-right">
                    <ul class="nav nav-pills">
                        <li<? if (isset($this->request->query['t']) && ($this->request->query['t'] == $last_month_report['param'])) echo ' class="active"' ?>>
                            <a href="/media?t=<?= $last_month_report['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>&medium=<?= $medium ?>"><?= $last_month_report['label'] ?></a>
                        </li>

                        <? if (isset($dropdownRanges)) { ?>
                            <li<? if ($twitterTimerange == $key) echo ' class="active"' ?>>
                                <div class="dropdown">
                                    <button class="clear dropdown-toggle" type="button" id="dropdownRanges"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Więcej <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownRanges">
                                        <? foreach ($dropdownRanges as $dropdown) { ?>
                                            <li class="dropdown-title"><?= $dropdown['title'] ?></li>
                                            <? foreach ($dropdown['ranges'] as $range) { ?>
                                                <li<? if ($twitterTimerange == $range['param'] && strlen($twitterTimerange) === strlen($range['param'])) echo ' class="active"'; ?>>
                                                    <a href="/media?t=<?= $range['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>&medium=<?= $medium ?>">
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
        <? } ?>
    </div>
		
    <div class="mediaHighstockPicker">
        <div class="chart"
             data-aggs='<?= json_encode($dataBrowser['aggs']['posts']['global_timerange']['selected_accounts']['histogram']) ?>'
             data-xmax='<?= json_encode(isset($timerange['xmax']) ? $timerange['xmax'] : false) ?>'
             data-range='<?= json_encode($timerange['range']) ?>'>
            <div class="spinner grey">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
	        
        <div class="range">
            <div class="row">
                <div class="col-md-5">
                    <p class="display"><?= $this->Czas->dataSlownie($timerange['labels']['min']) ?> <span
                            class="separator">&mdash;</span> <?= $this->Czas->dataSlownie($timerange['labels']['max']) ?>
                    </p>
                </div>
                <div class="col-md-7">
                    <a href="#" class="switcher hidden"
                       data-type="<? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo $twitterAccountType; ?>">
                        <span class="icon" data-icon="&#xe604;"></span>
                        Zastosuj
                    </a>
                    <a href="#" class="cancel hidden"
                       data-type="<? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo $twitterAccountType; ?>">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        Anuluj
                    </a>
                </div>
            </div>
        </div>

    </div>
	
	
	
	<div class="row">

		<div class="col-md-8">
			
			<?
			if ($hits = @$dataBrowser['aggs']['posts']['global_timerange']['target_timerange']['accounts']['top']['hits']['hits']) {
		        
		        if ($timerange['init']) {
		            $docs = array();
		            foreach ($hits as $hit)
		                $docs[$hit['fields']['date'][0]] = $hit;
		
		            unset($hits);
		            krsort($docs);
		            $docs = array_values($docs);
		        } else {
		            $docs = $hits;
		        }
		        
	        ?>
	        <div class="block">
	            <header>Najbardziej angażujące posty</header>
	            <section class="content">
		            
		            <div class="block-bg-area">
			            <p class="p">Posty, które uzyskały najwięszką liczbę polubień, komentarzy i udostępień.</p>
		            </div>
		            
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	                        <ul class="dataobjects">
	                            <? foreach ($docs as $doc) { ?>
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
			
		</div>
		
		<div class="col-md-4">

			
			<?
							
			if (@$dataBrowser['aggs']['posts']['global_timerange']['target_timerange']['accounts']['accounts_engagement']['buckets']) {
			?>
	        <div class="block bgA">
	            <header>Najbardziej angażujące profile</header>
	            <section class="aggs-init">
	                
	                <div class="block-bg-area">
			            <p class="p">Profile, których posty uzyskały największe liczby polubień, komentarzy i udostępień.</p>
		            </div>
	                
	                <div class="dataAggs">
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"
	                         data-image_field="image_url" data-label_field="name"
	                         data-counter_field="engagement_count"
	                         data-choose-request="/dane/fb_accounts/"
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['posts']['global_timerange']['target_timerange']['accounts']['accounts_engagement'])) ?>">
	                        <div class="chart">
	                            <div class="spinner grey">
	                                <div class="bounce1"></div>
	                                <div class="bounce2"></div>
	                                <div class="bounce3"></div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </section>
	        </div>
		    <? } ?>
		    
		    
		    <?
		    if (@$dataBrowser['aggs']['posts']['global_timerange']['target_timerange']['accounts']['accounts_posts']['buckets']) {
		    ?>
	        <div class="block bgA">
	            <header>Najwięcej postów napisali</header>
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"
	                         data-image_field="image_url" data-label_field="name"
	                         data-choose-request="/dane/fb_accounts/"
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['posts']['global_timerange']['target_timerange']['accounts']['accounts_posts'])) ?>">
	                        <div class="chart">
	                            <div class="spinner grey">
	                                <div class="bounce1"></div>
	                                <div class="bounce2"></div>
	                                <div class="bounce3"></div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </section>
	        </div>
		    <? } ?>
		    
		    <?
		    if (@$dataBrowser['aggs']['posts']['global_timerange']['target_timerange']['accounts']['accounts_engagement_posts']['buckets']) {
		    ?>
	        <div class="block bgA">
	            <header>Najwięcej zaangażowania w przeliczeniu na 1 posta</header>
	            <section class="aggs-init">
	                
	                <div class="block-bg-area">
			            <p class="p">Profile, które uzyskały najwięcej polubień, komentarzy i udostępień, w przeliczeniu na 1 posta.</p>
		            </div>
	                
	                <div class="dataAggs">
	                    <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"
	                         data-image_field="image_url" data-label_field="name" data-counter_field="engagement_count"
	                         data-choose-request="/dane/fb_accounts/"
	                         data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['posts']['global_timerange']['target_timerange']['accounts']['accounts_engagement_posts'])) ?>">
	                        <div class="chart">
	                            <div class="spinner grey">
	                                <div class="bounce1"></div>
	                                <div class="bounce2"></div>
	                                <div class="bounce3"></div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </section>
	        </div>
		    <? } ?>
		    
			
		</div>
		
	</div>
		
	
</div>