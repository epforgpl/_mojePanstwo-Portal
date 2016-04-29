<?
$this->Combinator->add_libs('css', $this->Less->css('warstwy', array('plugin' => 'Mapa')));
$this->Combinator->add_libs('css', $this->Less->css('ngo', array('plugin' => 'Ngo')));
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Ngo.ngo');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Dane.dataset-observe.js');

echo $this->element('modals/dataset-observe', $observe_params);

?>


<div class="col-xs-12">

    <div class="appBanner">

        <h1 class="appTitle">Organizacje pozarządowe</h1>
        <p class="appSubtitle">Poznaj scenę organizacji obywatelskich w Polsce.</p>

        <form action="/ngo" method="get">
            <div class="appSearch form-group">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Szukaj w NGO..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
					</span>
                </div>
            </div>
        </form>

    </div>


    <div class="row">
        <div class="col-md-4">

            <?
            $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
            ?>

            <div class="banner block margin-top-0">
                <div>
                    <div class="img-cog pull-left">
                        <span class="object-icon icon-datasets-strony"></span>
                    </div>
                    <p class="headline margin-top-20"><strong>Zarządzaj profilem</strong> <br/>swojej organizacji!</p>
                </div>
                <div class="description margin-top-10">
                    <p class="min-height">Dodawaj działania swojej organizacji, uaktualniaj i modyfikuj jej dane. Znajdź
                        organizację i poproś o uprawnienia do zarządzania jej profilem.</p>
                    <div class="text-left"><a href="/ngo/organizacje" class="szukajOrganizajiBtn">Znajdź
                            organizację &raquo;</a></div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <div class="banner block margin-top-0">
                <div>
                    <div class="img-cog pull-left">
                        <span class="object-icon icon-datasets-miejsca"></span>
                    </div>
                    <p class="headline margin-top-20"><strong>Zobacz mapę</strong> <br/> organizacji pozarządowych</p>
                </div>
                <div class="description margin-top-10">
                    <p class="min-height">Zobacz gdzie w Polsce działają organizacje pozarządowe. Znajdź organizacje w
                        swojej okolicy.</p>
                    <div class="text-left"><a href="/mapa/ngo" class="">Przejdź do mapy &raquo;</a></div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <?= $this->Element('Ngo.ngo-email-subscription') ?>

        </div>
    </div>

    <div class="row margin-top-10">
        <div class="col-md-8">

            <? if ($docs = @$dataBrowser['aggs']['konkursy']['top']['hits']['hits']) { ?>
                <div class="block">
                    <header>Konkursy dla organizacji pozarządowych:</header>
                    <div class="buttons larger">
                        <? if ($observe_params['object']->getLayer('subscription')) { ?>
                            <a class="dataset-observe-button" href="#">Subskrybujesz...</a>
                        <? } else { ?>
                            Poszukujesz finansowanie dla swojej organizacji? <a class="dataset-observe-button" href="#">Subskrybuj
                                informacje o nowych konkursach »</a>
                        <? } ?>
                    </div>
                    <section class="content">
                        <div class="agg agg-Dataobjects">
                            <ul class="dataobjects img-nopadding" style="margin: 0 20px;">
                                <? foreach ($docs as $doc) { ?>
                                    <li class="margin-top-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>

                        <div class="buttons">
                            <a href="/ngo/konkursy" class="btn btn-xs btn-primary margin-sides-5">Zobacz
                                więcej &raquo;</a> <? if ($observe_params['object']->getLayer('subscription')) { ?><a
                                href="#"
                                class="margin-sides-5 dataset-observe-button">Subskrybujesz...</a><? } else { ?><a
                                href="#"
                                class="btn btn-xs btn-success margin-sides-5 dataset-observe-button">Subskrybuj &raquo;</a><? } ?>
                        </div>
                    </section>
                </div>
            <? } ?>

        </div>
        <div class="col-md-4">

            <? if ($docs = @$dataBrowser['aggs']['zbiorki']['top']['hits']['hits']) { ?>
                <div class="block bgA">
                    <header>Najnowsze zbiórki publiczne:</header>
                    <section class="content">
                        <div class="agg agg-Dataobjects">
                            <ul class="dataobjects" style="margin: 0 20px;">
                                <? foreach ($docs as $doc) { ?>
                                    <li class="margin-top-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>

                        <div class="buttons">
                            <a href="/ngo/zbiorki" class="btn btn-xs btn-primary">Zobacz więcej &raquo;</a>
                        </div>
                    </section>
                </div>
            <? } ?>

            <a href="/ngo/zbiorki_publiczne" class="banner transferuj block">
                <span class="pull-right object-icon icon-datasets-zbiorki_publiczne"
                      style="font-size: 70px; margin: 10px 20px 0 0;"></span>
                <p style="color:#000;"><strong>Rozlicz</strong> zbiorkę publiczną!</p>

                <button class="btn btn-sm btn-primary" type="button">Wypełnij formularz</button>
            </a>

            <? if ($docs = @$dataBrowser['aggs']['sprawozdania_opp']['top']['hits']['hits']) { ?>
                <div class="block bgA">
                    <header>Sprawozdania organizacji pożytku publicznego:</header>
                    <section class="content">
                        <div class="agg agg-Dataobjects">
                            <ul class="dataobjects img-nopadding" style="margin: 0 20px;">
                                <? foreach ($docs as $doc) { ?>
                                    <li class="margin-top-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>

                        <div class="buttons">
                            <a href="/ngo/sprawozdania_opp" class="btn btn-xs btn-primary">Zobacz więcej &raquo;</a>
                        </div>
                    </section>
                </div>
            <? } ?>

        </div>
    </div>


    <div id="actions-newest" class="block block-simple">
        <header>Najnowsze działania organizacji pozarządowych:</header>
        <section class="content">
            <div class="row">
                <? foreach ($dataBrowser['aggs']['dzialania']['top']['hits']['hits'] as $dzialanie) { ?>
                    <div class="action col-sm-4">
                        <h4>
                            <a href="/dane/<?= $dzialanie['_source']['data']['dzialania']['dataset']; ?>/<?= $dzialanie['_source']['data']['dzialania']['object_id']; ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>">
                                <?= $this->Text->truncate($dzialanie['_source']['data']['dzialania']['tytul'], 100); ?>
                            </a>
                        </h4>
                        <? if ($dzialanie['_source']['data']['dzialania']['photo'] == '1') { ?>
                            <div class="photo">
                                <a href="/dane/<?= $dzialanie['_source']['data']['dzialania']['dataset']; ?>/<?= $dzialanie['_source']['data']['dzialania']['object_id']; ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>"><img
                                        alt="<?= $dzialanie['_source']['data']['dzialania']['tytul']; ?>"
                                        src="http://sds.tiktalik.com/portal/2/pages/dzialania/<?= $dzialanie['fields']['id'][0]; ?>.jpg"/></a>
                            </div>
                        <? } else { ?>
                            <div class="photo">
                                <a href="/dane/<?= $dzialanie['_source']['data']['dzialania']['dataset']; ?>/<?= $dzialanie['_source']['data']['dzialania']['object_id']; ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>"><img
                                        alt="<?= $dzialanie['_source']['data']['dzialania']['tytul']; ?>"
                                        src="/Ngo/icon/side_ngo.svg"/></a>
                            </div>
                        <? } ?>
                        <p class="owner"><?= @$dzialanie['_source']['data']['dzialania']['owner_name'] ?></p>

                        <div class="desc">
                            <?= @$this->Text->truncate($dzialanie['_source']['data']['dzialania']['podsumowanie'], 200) ?>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="text-center margin-top-20">
                <a class="btn btn-xs btn-primary" href="/ngo/dzialania">Zobacz więcej &raquo;</a>
            </div>
        </section>
    </div>

    <? if ($docs = @$dataBrowser['aggs']['pisma']['top']['hits']['hits']) { ?>
        <div class="block block-simple">
            <header class="nopadding">Pisma:</header>
            <section class="content margin-top-10">

                <div class="agg agg-Dataobjects">
                    <ul class="dataobjects">
                        <? foreach ($docs as $doc) { ?>
                            <li class="margin-top-10">
                                <?
                                echo $this->Dataobject->render($doc, 'default');
                                ?>
                            </li>
                        <? } ?>
                    </ul>
                    <div class="buttons text-center margin-top-10">
                        <a href="/ngo/pisma" class="btn btn-primary btn-xs">Zobacz więcej &raquo;</a>
                    </div>
                </div>

            </section>
        </div>
    <? } ?>

    <h2 class="appInnerTitle">Działania organizacji pozarządowych na Twitterze:</h2>

    <div id="accountsSwitcher" class="appMenuStrip">
        <? if (isset($twitterTimeranges) && isset($twitterTimerange)) { ?>
            <div class="appSwitchers">

                <div class="pull-left">
                    <p class="_label">Analizowany okres:</p>
                    <ul class="nav nav-pills">
                        <? foreach ($twitterTimeranges as $key => $value) { ?>
                            <li<? if ($twitterTimerange == $key) echo ' class="active"' ?>>
                                <a href="/ngo?t=<?= $key ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>">
                                    <?= $value ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </div>
                <div class="pull-right">
                    <ul class="nav nav-pills">
                        <li<? if (isset($this->request->query['t']) && ($this->request->query['t'] == $last_month_report['param'])) echo ' class="active"' ?>>
                            <a href="/ngo?t=<?= $last_month_report['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>"><?= $last_month_report['label'] ?></a>
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
                                                    <a href="/ngo?t=<?= $range['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>">
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
             data-aggs='<?= json_encode($dataBrowser['aggs']['tweets']['global_timerange']['selected_accounts']['histogram']) ?>'
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
            if ($hits = @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['top']['hits']['hits']) {

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
                    <header>Najbardziej angażujące tweety</header>
                    <section class="content">

                        <div class="block-bg-area">
                            <p class="p">Tweety, które uzyskały najwięszką liczbę retweetów, polubień i komentarzy.</p>
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
            if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement']['buckets']) {
                ?>
                <div class="block bgA">
                    <header>Najbardziej angażujące profile</header>
                    <section class="aggs-init">

                        <div class="block-bg-area">
                            <p class="p">Profile, których tweety uzyskały największe liczby retweetów, polubień i
                                komentarzy.</p>
                        </div>

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

            <?
            if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_tweets']['buckets']) {
                ?>
                <div class="block bgA">
                    <header>Najwięcej tweetów napisali</header>
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

            <?
            if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['accounts_engagement_tweets']['buckets']) {
                ?>
                <div class="block bgA">
                    <header>Najwięcej zaangażowania w przeliczeniu na 1 tweeta</header>
                    <section class="aggs-init">

                        <div class="block-bg-area">
                            <p class="p">Profile, które uzyskały najwięcej retweetów, polubień i komentarzy, w
                                przeliczeniu na 1 tweeta.</p>
                        </div>

                        <div class="dataAggs">
                            <div class="agg agg-ColumnsHorizontal" data-chart-height="1500" data-label-width="150"
                                 data-image_field="image_url" data-label_field="name"
                                 data-counter_field="engagement_count"
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

            <?
            if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['mentions']['accounts']['ids']['buckets']) {
                ?>
                <div class="block bgA">
                    <header>Najczęściej wzmiankowani</header>
                    <section class="aggs-init">

                        <div class="block-bg-area">
                            <p class="p">Profile, które były najczęściej wzmiankowane w innych tweetach i ich
                                retweetach.</p>
                        </div>

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

            <?
            if (@$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['sources']) {
                ?>
                <div class="block bgA">
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

    <?
    if ($tags = @$dataBrowser['aggs']['tweets']['global_timerange']['target_timerange']['accounts']['tags']['tags']['buckets']) {

        $max = 0;
        foreach ($tags as $t)
            if ($t['rn']['engagement_count']['value'] > $max)
                $max = $t['rn']['engagement_count']['value'];

        if (!$max)
            $max = 1;
        ?>
        <div class="block">
            <header>Najbardziej angażujące hashtagi</header>
            <section class="aggs-init">

                <? /*
		    <div class="block-bg-area">
	            <p class="p">Hashatagi osadzone w tweetach, które osiągneły największą liczbę retweetów, polubień i komentarzy.</p>
            </div>
            */ ?>

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
        </div>
    <? } ?>

</div>













