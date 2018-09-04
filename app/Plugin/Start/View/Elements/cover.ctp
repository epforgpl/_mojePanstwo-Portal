<?
$this->Combinator->add_libs('css', $this->Less->css('homepage', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.homepage.js');
?>

<div id="homepage" class="col-xs-12">
    <div class="appBanner">
        <h1 class="appTitle">mojePaństwo</h1>
        <p class="appSubtitle"><?= __("LC_START_PORTAL_MOTTO") ?></p>

        <div class="_mPSearchOutside appSearch form-group">
            <form action="/" method="get">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="<?= __("LC_START_PORTAL_SEARCH") ?>" type="text"
                           autocomplete="off"/>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
					</span>
                </div>
            </form>
            <p class="text-center margin-top-10"><a href="/dane"><?= __("LC_START_PORTAL_WHAT_SEARCH") ?> &raquo;</a></p>
        </div>

    </div>
	
	<div class="alert alert-registry text-center mt-4">
		<h3 class="alert-heading">Szukasz danych z Krajowego Rejestru Sądowego?</h3>
        <p>Przenieśliśmy je na nasz nowy portal <a href="https://rejestr.io">Rejestr.io</a></p>
        <p><a href="https://rejestr.io"><img src="http://registry.local/img/logo.svg" /></a></p>
        <p><a href="https://rejestr.io">Przejdź do portalu Rejestr.io &raquo;</a></p>
	</div>

    <div class="appContent row">
        <div class="appsList">
            <? foreach ($_applications as $app_id => $a) {
                if ($a['tag'] == 1) {
                    $path = (isset($a['path']) && !empty($a['path'])) ? $a['path'] : $app_id;

                    $icon_link = '/' . $path . '/icon/icon_' . $app_id . '.svg';
                    $icon_side = '/' . $path . '/icon/side_' . $app_id . '.svg';
                    ?>
                    <a class="col-xs-12 col-sm-6" href="<?= $a['href'] ?>" target="_self">
                        <div class="appBorder">
                            <div class="col-xs-12 col-md-8">
                                <div class="mainpart">
                                    <img src="<?= $icon_link ?>" class="icon"/>
                                    <strong><?= $a['name_' . $_lang] ?></strong>
                                </div>
                                <div class="subpart">
                                    <? if (isset($a['subname_' . $_lang]) && !empty($a['subname_' . $_lang])) { ?>
                                        <p class="title"><?= $a['subname_' . $_lang] ?></p>
                                    <? } ?>
                                    <? if (isset($a['desc_' . $_lang]) && !empty($a['desc_' . $_lang])) { ?>
                                        <p class="text"><?= $a['desc_' . $_lang] ?></p>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 sideIcon">
                                <img src="<?= $icon_side ?>" class="img-responsive"/>
                            </div>
                        </div>
                    </a>
                <? }
            } ?>
        </div>

        <div class="reportsList">
            <? foreach ($_applications as $app_id => $a) {
                if ($a['tag'] == 2) {
                    $path = (isset($a['path']) && !empty($a['path'])) ? $a['path'] : $app_id;

                    $icon_link = '/' . $path . '/icon/icon_' . $app_id . '.svg';
                    $icon_side = '/' . $path . '/icon/side_' . $app_id . '.svg';
                    ?>
                    <a class="col-xs-12 col-sm-6" href="<?= $a['href'] ?>" target="_self">
                        <div class="appBorder">
                            <div class="col-xs-8">
                                <div class="mainpart">
                                    <img src="<?= $icon_link ?>" class="icon"/>
                                    <strong><?= $a['name'] ?></strong>
                                </div>
                                <div class="subpart">
                                    <? if (isset($a['subname']) && !empty($a['subname'])) { ?>
                                        <p class="title"><?= $a['subname'] ?></p>
                                    <? } ?>
                                    <? if (isset($a['desc']) && !empty($a['desc'])) { ?>
                                        <p class="text"><?= $a['desc'] ?></p>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="col-xs-4 sideIcon">
                                <img src="<?= $icon_side ?>" class="img-responsive"/>
                            </div>
                        </div>
                    </a>
                <? }
            } ?>
        </div>
    </div>
</div>
