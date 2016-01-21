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
<div class="col-xs-12 col-sm-4 col-md-1-5 noleftpadding dataAggsContainer">
    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

        <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>

        <? if (isset($twitterAccountTypes)) { ?>
            <?= $this->Element('Media.twitter-account-suggestion', array(
                'types' => $twitterAccountTypes
            )); ?>
        <? } ?>

    </div>
</div>

<div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
    <div class="dataWrap">
        <div class="appBanner">
            <h1 class="appTitle">
                <?= isset($accountTypeLabel) ? $accountTypeLabel : 'Państwo na Twitterze' ?>
            </h1>
            <p class="appSubtitle">Zobacz kto i jak wykorzystuje media społecznościowe w debacie publicznej.</p>
        </div>
    </div>

    <div id="accountsSwitcher" class="appMenuStrip row">
        <? if (isset($twitterTimeranges) && isset($twitterTimerange)) { ?>
            <div class="appSwitchers">
                <div class="dataWrap">
                    <div class="pull-left">
                        <p class="_label">Analizowany okres:</p>
                        <ul class="nav nav-pills">
                            <? foreach ($twitterTimeranges as $key => $value) { ?>
                                <li<? if ($twitterTimerange == $key) echo ' class="active"' ?>>
                                    <a href="/media?t=<?= $key ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>">
                                        <?= $value ?>
                                    </a>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <ul class="nav nav-pills">
                            <li<? if (isset($this->request->query['t']) && ($this->request->query['t'] == $last_month_report['param'])) echo ' class="active"' ?>>
                                <a href="/media?t=<?= $last_month_report['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>"><?= $last_month_report['label'] ?></a>
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
                                                        <a href="/media?t=<?= $range['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>">
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
        <div class="chart"
             data-aggs='<?= json_encode($dataBrowser['aggs']['tweets']['global_timerange']['selected_accounts']['histogram']) ?>'
             data-xmax='<?= json_encode(isset($timerange['xmax']) ? $timerange['xmax'] : false) ?>'
             data-range='<?= json_encode($timerange['range']) ?>'>
            <div class="spinner grey">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="dataWrap">
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
    </div>

    <div class="dataWrap">

        <? // debug($dataBrowser['aggs']['accounts']); ?>

        <? if ($hits = @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['top']['hits']['hits']) {
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
            <div class="block col-xs-12">
                <header>Najbardziej angażujące tweety:<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip"
                                                         data-placement="right"
                                                         title="Tweety, które uzyskały najwięszką liczbę retweetów, polubień i komentarzy."></i>
                </header>
                <section class="aggs-init">
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

        <? if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement']['buckets']) { ?>
            <div class="block col-xs-12">
                <header>Najbardziej angażujące profile:<i class="glyphicon glyphicon-question-sign"
                                                          data-toggle="tooltip"
                                                          data-placement="right"
                                                          title="Profile, których tweety uzyskały największe liczby retweetów, polubień i komentarzy."></i>
                </header>
                <section class="aggs-init">
                    <div class="dataAggs">
                        <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"
                             data-image_field="image_url" data-label_field="name"
                             data-counter_field="engagement_count"
                             data-choose-request="/dane/twitter_accounts/"
                             data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement'])) ?>">
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

        <? if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_tweets']['buckets']) { ?>
            <div class="block col-xs-12">
                <header>Najwięcej tweetów napisali:</header>
                <section class="aggs-init">
                    <div class="dataAggs">
                        <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"
                             data-image_field="image_url" data-label_field="name"
                             data-choose-request="/dane/twitter_accounts/"
                             data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_tweets'])) ?>">
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

        <? if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement_tweets']['buckets']) { ?>
            <div class="block col-xs-12">
                <header>Najwięcej zaangażowania w przeliczeniu na 1 tweeta:<i class="glyphicon glyphicon-question-sign"
                                                                              data-toggle="tooltip"
                                                                              data-placement="right"
                                                                              title="Profile, które uzyskały najwięcej retweetów, polubień i komentarzy, w przeliczeniu na 1 tweeta."></i>
                </header>
                <section class="aggs-init">
                    <div class="dataAggs">
                        <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"
                             data-image_field="image_url" data-label_field="name" data-counter_field="engagement_count"
                             data-choose-request="/dane/twitter_accounts/"
                             data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement_tweets'])) ?>">
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


        <? if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['mentions']['accounts']['ids']['buckets']) { ?>
            <div class="block col-xs-12">
                <header>Najczęściej wzmiankowani:<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip"
                                                    data-placement="right"
                                                    title="Profile, które były najczęściej wzmiankowane w innych tweetach i ich retweetach."></i>
                </header>
                <section class="aggs-init">
                    <div class="dataAggs">
                        <div class="agg agg-ColumnsHorizontal"
                             data-chart-height="1500"
                             data-label-width="150"
                             data-label_field="name"
                             data-image_field="photo"
                             data-choose-request="/dane/twitter_accounts/"
                             data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['mentions']['accounts']['ids'])) ?>">
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
        <? if ($tags = @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['tags']['tags']['buckets']) {
        $max = 0;
        foreach ($tags as $t)
            if ($t['rn']['engagement_count']['value'] > $max)
                $max = $t['rn']['engagement_count']['value'];

        if (!$max)
            $max = 1;
        ?>
        <div class="block col-xs-12">
            <header>
                <div class="dataWrap">Najbardziej angażujące hashtagi:<i class="glyphicon glyphicon-question-sign"
                                                                         data-toggle="tooltip" data-placement="right"
                                                                         title="Hashatagi osadzone w tweetach, które osiągneły największą liczbę retweetów, polubień i komentarzy."></i>
                </div>
            </header>
        </div>
    </div>
    <section class="aggs-init row">
        <ul id="tagsCloud">
            <? foreach ($tags as $tag) { ?>
                <li style="font-size: <?= 20 + (70 * $tag['rn']['engagement_count']['value'] / $max) ?>px;">
                    <a href="/media/tweety?conditions[twitter.tags]=<?
                    $parms = $tag['key'];
                    if (isset($timerange["range"])) {
                        $parms .= '&conditions[date]=[' . date('Y-m-d', $timerange["range"]['min']) . ' TO ' . date('Y-m-d', $timerange["range"]['max']) . ']';
                    }
                    if (isset($twitterAccountType) && $twitterAccountType !== '0') {
                        $parms .= '&conditions[twitter_accounts.typ_id]=' . $twitterAccountType;
                    }
                    echo $parms;
                    ?>">
                        <?= $tag['label']['buckets'][0]['key'] ?>
                    </a>
                </li>
            <? } ?>
        </ul>
    </section>
    <div class="dataWrap">
        <? } ?>

        <? if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['sources']) { ?>
            <div class="block col-xs-12">
                <header>Najczęściej używane aplikacje:</header>
                <section class="aggs-init margin-sides-10">
                    <div class="pie"
                         data-json='<?= json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['sources']['buckets']); ?>'
                         data-parms="<?
                         $parms = '';

                         if (isset($timerange["range"])) {
                             $parms .= '&conditions[date]=[' . date('Y-m-d', $timerange["range"]['min']) . ' TO ' . date('Y-m-d', $timerange["range"]['max']) . ']';
                         }
                         if (isset($twitterAccountType) && $twitterAccountType !== '0') {
                             $parms .= '&conditions[twitter_accounts.typ_id]=' . $twitterAccountType;
                         }
                         echo $parms;
                         ?>">
                        <div class="spinner grey">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                </section>
            </div>
        <? } ?>
    </div>
</div>
