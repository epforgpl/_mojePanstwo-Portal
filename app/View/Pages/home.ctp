<?php
$this->Combinator->add_libs('css', $this->Less->css('home'));
$this->Combinator->add_libs('js', 'home');
?>

<div id="home" class="fullPageHeight mpBackgroundSet"
     style="background-image: url(<?php echo $_layout['body']['wallpaper']; ?>)">
    <div class="_handler">
        <div class="container">
            <div class="startWindow col-xs-12 col-md-10 col-md-offset-1">
                <div class="windowSet">
                    <div class="_mPSearchOutside">
                        <form class="suggesterBlock" action="/dane">
                            <div class="main_input">
                                <i class="glyph-addon" data-icon="&#xe600;"></i>
                                <input name="q" value="" type="text" autocomplete="off"
                                       class="datasearch form-control input-lg"
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
                                    <i class="icon" <? if ($a['icon']) {
                                        echo 'data-icon-applications="' . $a['icon'] . '"';
                                    } else {
                                        echo 'data-icon="&#xe612;"';
                                    } ?>></i>

                                    <p><?= $a['name'] ?></p>
                                </a>
                            <? }
                        } ?>
                    </div>

                    <? /*
                    <div class="basicOptions">
                        <div class="col-xs-12 col-sm-6 part">
                            <div class="observeBrick mainBrick">
                                <div class="title">Obserwuj</div>
                                <span class="line"></span>

                                <div class="description">
                                    Otrzymuj powiadomienia o aktywnościach urzędów, urzędnikow oraz firm, którymi jesteś
                                    zainteresowany.
                                </div>
                                <div class="action">
                                    <? if ($this->Session->read('Auth.User.id')) { ?>
                                        <a href="/moje-dane" target="_self" class="btn btn-primary btn-icon">
                                            <img class="icon" src="/MojeDane/icon/powiadomienia.svg" alt=""/>Moje Dane
                                        </a>
                                    <? } else { ?>
                                        <a href="/moje-dane/jak_to_dziala" target="_self"
                                           class="btn btn-primary btn-icon">
                                            <img class="icon" src="/MojeDane/icon/powiadomienia.svg" alt=""/>Zacznij
                                            obserwować
                                        </a>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 part">
                            <div class="shoutBrick mainBrick">
                                <div class="title">Komunikuj</div>
                                <span class="line"></span>

                                <div class="description">
                                    Wysyłaj wnioski o udostępnienie informacji publicznych oraz inne pisma do urzędów i
                                    dziel się nimi w mediach społecznościowych.
                                </div>
                                <div class="action">

                                    <? if ($this->Session->read('Auth.User.id')) { ?>
                                        <a href="/moje-pisma" target="_self" class="btn btn-primary btn-icon">
                                            <img class="icon" src="/MojeDane/icon/powiadomienia.svg" alt=""/>Moje Pisma
                                        </a>
                                    <? } else { ?>
                                        <a href="/moje-pisma/nowe" target="_self" class="btn btn-primary btn-icon">
                                            <img class="icon" src="/MojeDane/icon/powiadomienia.svg" alt=""/>Napisz
                                            Pismo
                                        </a>
                                    <? } ?>

                                </div>
                            </div>
                        </div>
                    </div>
					*/ ?>

                    <div class="appsList">
                        <h2>Raporty</h2>
                        <? foreach ($_applications as $a) {
                            if ($a['tag'] == 2) { ?>
                                <a class="homePageIcon col-xs-6 col-sm-4 col-md-3" href="<?= $a['href'] ?>">
                                    <i class="icon" <? if ($a['icon']) {
                                        echo 'data-icon-applications="' . $a['icon'] . '"';
                                    } else {
                                        echo 'data-icon="&#xe612;"';
                                    } ?>></i>

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