<?php
$this->Combinator->add_libs('css', $this->Less->css('home'));
$this->Combinator->add_libs('js', 'home');
?>

<div id="home" class="fullPageHeight">
    <div class="_handler">
        <div class="container">
            <div class="startWindow col-xs-12 col-md-10 col-md-offset-1">
                <div class="windowSet">
                    <div class="_mPSearchOutside">
                        <form class="suggesterBlock" action="/dane">
                            <div class="main_input">
                                <span class="glyph-addon" data-icon="&#xe600;"></span>
                                <input name="q" value="" type="text" autocomplete="off"
                                       class="datasearch form-control input-lg"
                                       data-autocompletion="true"
                                       placeholder="<?= __("LC_SEARCH_PUBLIC_DATA_PLACEHOLDER") ?>" <?php if (isset($app)) {
                                    echo 'data-app="' . $app . '"';
                                } ?> />
                            </div>
                        </form>
                    </div>

                    <div class="appsList">
                        <h2>Aplikacje</h2>
                        <? foreach ($_applications as $a) {
                            if ($a['tag'] == 1) { ?>
                                <a class="homePageIcon col-xs-6 col-sm-4 col-md-3" href="<?= $a['href'] ?>"
                                   target="_self">
                                    <span class="icon" <? if ($a['icon']) {
                                        echo 'data-icon-applications="' . $a['icon'] . '"';
                                    } else {
                                        echo 'data-icon="&#xe612;"';
                                    } ?>></span>

                                    <p><?= $a['name'] ?></p>
                                </a>
                            <? }
                        } ?>
                    </div>

                    <div class="appsList">
                        <h2>Raporty</h2>
                        <? foreach ($_applications as $a) {
                            if ($a['tag'] == 2) { ?>
                                <a class="homePageIcon col-xs-6 col-sm-4 col-md-3" href="<?= $a['href'] ?>">
                                    <span class="icon" <? if ($a['icon']) {
                                        echo 'data-icon-applications="' . $a['icon'] . '"';
                                    } else {
                                        echo 'data-icon="&#xe612;"';
                                    } ?>></span>

                                    <p><?= $a['name'] ?></p>
                                </a>
                            <? }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
