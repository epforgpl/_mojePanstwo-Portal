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

    <div class="col-xs-12 col-sm-9 margin-top-10 margin-sides-15">

        <div id="accountsSwitcher" class="appMenuStrip row">

            <? if(isset($twitterTimeranges) && isset($twitterTimerange)) { ?>
                <div class="appSwitchers">
                    <div class="dataWrap">
                        <div class="pull-left">
                            <p class="_label">Analizowany okres:</p>
                            <ul class="nav nav-pills">
                                <? foreach($twitterTimeranges as $key => $value) { ?>
                                    <li<? if($twitterTimerange == $key) echo ' class="active"' ?>>
                                        <a href="/dane/twitter_accounts/<?= $object->getId(); ?>?t=<?= $key ?>">
                                            <?= $value ?>
                                        </a>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>
                        <div class="pull-right">
                            <ul class="nav nav-pills">
                                <li<? if( isset($this->request->query['t']) && ($this->request->query['t']==$last_month_report['param']) ) echo ' class="active"' ?>>
                                    <a href="/dane/twitter_accounts/<?= $object->getId(); ?>?t=<?= $last_month_report['param'] ?>"><?= $last_month_report['label'] ?></a>
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
                                                            <a href="/dane/twitter_accounts/<?= $object->getId(); ?>?t=<?= $range['param'] ?>">
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

        <? if( @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts_by_mentions']['accounts'] ) { ?>
            <div class="block block-simple col-xs-12">
                <header title="accounts_by_mentions.">accounts_by_mentions:</header>
                <section class="aggs-init">
                    <div class="dataAggs">
                        <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"  data-label_field="screen_name" data-choose-request="/media?conditions[twitter.twitter_account_id]="
                             data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts_by_mentions']['accounts']['ids'])) ?>">
                            <div class="chart"></div>
                        </div>
                    </div>
                </section>
            </div>
        <? } ?>

        <? if( @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['mentions_by_account']['accounts'] ) { ?>
            <div class="block block-simple col-xs-12">
                <header title="mentions_by_account.">mentions_by_account:</header>
                <section class="aggs-init">
                    <div class="dataAggs">
                        <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"  data-label_field="screen_name" data-choose-request="/media?conditions[twitter.twitter_account_id]="
                             data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['mentions_by_account']['accounts']['ids'])) ?>">
                            <div class="chart"></div>
                        </div>
                    </div>
                </section>
            </div>
        <? } ?>

        <div class="dataWrap">
            <? if (@$dataBrowser['aggs']['tweets']['timerange']['top']['hits']['hits']) { ?>
                <div class="block block-simple col-xs-12">
                    <header>Najpopularniejsze treści na Twitterze:</header>
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
        </div>

        <? if (@$dataBrowser['aggs']['tweets']['tags']['tags']['buckets'] &&
        count($dataBrowser['aggs']['tweets']['tags']['tags']['buckets'])) { ?>
            <div class="block block-simple col-xs-12">

                <header>
                    <div class="dataWrap">Najpopularniejsze hashtagi</div>
                </header>

                <section class="aggs-init">
                    <ul id="tagsCloud">
                        <? $tags = $dataBrowser['aggs']['tweets']['tags']['tags'];
                        $max = 0; $max_size = 60;
                        foreach ($tags['buckets'] as $tag) {
                            if($tag['doc_count'] > $max)
                                $max = $tag['doc_count'];
                        }

                        $size = $max_size / $max;

                        foreach ($tags['buckets'] as $tag) { ?>
                            <li style="font-size: <?= ((int) ($tag['doc_count']) * $size) + 10 ?>px;">
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

        <? if (@$dataBrowser['aggs']['tweets_whitout_account_type_id']['types']['buckets']) { ?>
            <div class="block block-simple col-xs-12">
                <header>Najczęściej używane aplikacje:</header>
                <section class="aggs-init">
                    <div class="row">
                        <? foreach ($dataBrowser['aggs']['tweets_whitout_account_type_id']['types']['buckets'] as $b) { ?>
                            <div class="col-sm-12">
                                <ul class="list-group reset margin-bottom-0">
                                    <? foreach ($b['sources']['buckets'] as $s) { ?>
                                        <? if(@$s['label']['buckets'][0]['doc_count']) { ?>
                                            <li class="list-group-item">
                                                <span class="badge"><?= $s['label']['buckets'][0]['doc_count'] ?></span>
                                                <?= $s['label']['buckets'][0]['key'] ?>
                                            </li>
                                        <? } ?>
                                    <? } ?>
                                </ul>
                            </div>
                        <? } ?>
                    </div>
                </section>
            </div>
        <? } ?>

    </div>
