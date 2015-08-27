<?

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('media-cover', array('plugin' => 'Media')));

$this->Combinator->replace_lib_or_add('js', '../plugins/highcharts/js/highcharts', '../plugins/highstock/js/highstock');
$this->Combinator->replace_lib_or_add('js', '../plugins/highcharts/locals', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Media.media-cover');

$options = array(
    'mode' => 'init',
);

?>
<div class="row">
    <div class="col-xs-12 col-md-12">

        <? if(@$dataBrowser['aggs']['tweets']['histogram']['histogram']['buckets']) { ?>
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
        <? } ?>

        <div class="dataWrap">
            <? if (@$dataBrowser['aggs']['tweets']['timerange']['top']['hits']['hits']) { ?>
                <div class="block col-xs-12">
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

        <? if (@$dataBrowser['aggs']['tweets']['timerange']['tags']['tags'] &&
        count($dataBrowser['aggs']['tweets']['timerange']['tags']['tags']['buckets'])) { ?>
            <div class="block col-xs-12">

                <header>
                    <div class="dataWrap">Najpopularniejsze hashtagi</div>
                </header>

                <section class="aggs-init">
                    <ul id="tagsCloud">
                        <? $tags = $dataBrowser['aggs']['tweets']['timerange']['tags']['tags'];
                        foreach ($tags['buckets'] as $tag) { ?>
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

            <? if (@$dataBrowser['aggs']['tweets_whitout_account_type_id']['types']['buckets']) { ?>
                <div class="block col-xs-12">
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

    </div>
</div>
