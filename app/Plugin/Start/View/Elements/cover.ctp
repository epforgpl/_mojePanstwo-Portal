<? $this->Combinator->add_libs('css', $this->Less->css('homepage', array('plugin' => 'Start'))); ?>

<div id="homepage" class="col-xs-12">
    <div class="appBanner">
        <h1 class="appTitle">mojePaństwo</h1>
        <p class="appSubtitle">Lorem ipsum placeholder</p>

        <div class="appSearch form-group">
            <div class="input-group">
                <input class="form-control" placeholder="Szukaj w danych publicznych..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
					</span>
            </div>
        </div>
    </div>

    <div class="appContent row">
        <div class="appsList">
            <? foreach ($_applications as $a) {
                if ($a['tag'] == 1) {
                    $icon = ($a['icon']) ? 'data-icon-applications="' . $a['icon'] . '"' : 'data-icon="&#xe612;"';
                    $icon_link = $a['href'] . '/icon/icon_' . str_replace("/", "", $a['href']) . '.svg';
                    $icon_side = $a['href'] . '/icon/side_' . str_replace("/", "", $a['href']) . '.svg';
                    ?>
                    <a class="col-xs-12 col-sm-6" href="<?= $a['href'] ?>" target="_self">
                        <div class="appBorder">
                            <div class="col-xs-8">
                                <div class="mainpart">
                                    <? /*<span class="icon" <?= $icon; ?>></span>*/ ?>
                                    <img src="<?= $icon_link ?>" class="icon"/>
                                    <strong><?= $a['name'] ?></strong>
                                </div>
                                <div class="subpart">
                                    <p class="title">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas
                                        vitae hendrerit metus. Aenean at lacus tempus leo molestie fermentum. Curabitur
                                        malesuada tortor sed tincidunt tempor. Curabitur pellentesque tellus sit amet
                                        risus vestibulum, sit amet tincidunt nisl tincidunt.</p>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <?/*<span class="img-responsive" alt="" <?= $icon; ?>></span>*/ ?>
                                <img src="<?= $icon_side ?>" class="img-responsive"/>
                            </div>
                        </div>
                    </a>
                <? }
            } ?>
        </div>

        <div class="reportsList">
            <? foreach ($_applications as $a) {
                if ($a['tag'] == 2) {
                    $icon = ($a['icon']) ? 'data-icon-applications="' . $a['icon'] . '"' : 'data-icon="&#xe612;"';
                    $icon_link = $a['href'] . '/icon/icon_' . str_replace("/", "", $a['href']) . '.svg';
                    $icon_side = $a['href'] . '/icon/side_' . str_replace("/", "", $a['href']) . '.svg';
                    ?>
                    <a class="col-xs-12 col-sm-6" href="<?= $a['href'] ?>" target="_self">
                        <div class="appBorder">
                            <div class="col-xs-8">
                                <div class="mainpart">
                                    <? /* <span class="icon" <?= $icon; ?>></span>*/ ?>
                                    <img src="<?= $icon_link ?>" class="icon"/>
                                    <strong><?= $a['name'] ?></strong>
                                </div>
                                <div class="subpart">
                                    <p class="title">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas
                                        vitae hendrerit metus. Aenean at lacus tempus leo molestie fermentum. Curabitur
                                        malesuada tortor sed tincidunt tempor. Curabitur pellentesque tellus sit amet
                                        risus vestibulum, sit amet tincidunt nisl tincidunt.</p>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <?/*<span class="img-responsive" alt="" <?= $icon; ?>></span>*/ ?>
                                <img src="<?= $icon_side ?>" class="img-responsive"/>
                            </div>
                        </div>
                    </a>
                <? }
            } ?>
        </div>
    </div>
</div>
