<?
$this->Combinator->add_libs('css', $this->Less->css('homepage', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.homepage.js');
?>

<div id="homepage" class="col-xs-12">
    <div class="appBanner">
        <h1 class="appTitle">mojePaństwo</h1>
        <p class="appSubtitle">Fundament działalności aktywnego obywatela i działacza</p>

        <div class="_mPSearchOutside appSearch form-group">
            <form action="/" method="get">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Szukaj w danych publicznych..." type="text"
                           autocomplete="off"/>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
					</span>
                </div>
            </form>
            <p class="text-center margin-top-10"><a href="/dane">Zobacz jakie dane przeszukujemy &raquo;</a></p>
        </div>

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
