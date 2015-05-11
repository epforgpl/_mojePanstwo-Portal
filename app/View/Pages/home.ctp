<?php $this->Combinator->add_libs('css', $this->Less->css('home')) ?>
<?php $this->Combinator->add_libs('js', 'home') ?>

<div id="home" class="fullPageHeight"
     style="background-image: url('/img/home/backgrounds/home-background-default.jpg')">
    <div class="_handler container">
        <div class="startWindow col-xs-12 col-md-10 col-md-offset-1">
            <div class="windowSet">

                <div class="basicOptions public-data">
                    <div class="col-xs-12 col-sm-12 part">
                        <div class="observeBrick mainBrick">
                            <div class="title">Dane publiczne</div>
                            <span class="line"></span>

                            <form class="suggesterBlock _mPSearchOutside" action="/dane">
                                <div class="main_input">
                                    <i class="glyph-addon" data-icon="&#xe600;"></i>
                                    <input name="q" value="" type="text" autocomplete="off"
                                           class="datasearch form-control input-lg"
                                           placeholder="<?= __("LC_SEARCH_PUBLIC_DATA_PLACEHOLDER") ?>" <?php if (isset($app)) {
                                        echo 'data-app="' . $app . '"';
                                    } ?> />
                                </div>
                            </form>

                            <div class="popularApps">
                                <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/krs" target="_self">
                                    <img class="svg" alt="Krajowy Rejestr Sądowy" src="/krs/icon/krs.svg">

                                    <p>Krajowy Rejestr Sądowy</p>
                                </a>
                                <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/kto_tu_rzadzi" target="_self">
                                    <img class="svg" alt="Kto tu rządzi?" src="/KtoTuRzadzi/icon/kto_tu_rzadzi.svg">

                                    <p>Kto tu rządzi?</p>
                                </a>

                                <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/prawo" target="_self">
                                    <img class="svg" alt="Prawo" src="/prawo/icon/prawo.svg">

                                    <p>Moja Gmina</p>
                                </a>
                                <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/media" target="_self">
                                    <img class="svg" alt="Media" src="/media/icon/media.svg">

                                    <p>Prawo</p>
                                </a>
                                <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/media" target="_self">
                                    <img class="svg" alt="Media" src="/media/icon/media.svg">

                                    <p>Zamówienia publiczne</p>
                                </a>
                                <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/media" target="_self">
                                    <img class="svg" alt="Media" src="/media/icon/media.svg">

                                    <p>Media</p>
                                </a>

                            </div>

                            <div class="action">
                                <a href="/moje-dane" target="_self" class="btn btn-primary btn-icon">
                                    <img class="icon" src="/MojeDane/icon/powiadomienia.svg" alt=""/>Więcej danych publicznych
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="basicOptions">
                    <div class="col-xs-12 col-sm-6 part">
                        <div class="observeBrick mainBrick">
                            <div class="title">Moje Dane</div>
                            <span class="line"></span>

                            <div class="description">
                                Otrzymuj powiadomienia o aktywnościach urzędów, urzędnikow oraz firm, którymi jesteś
                                zainteresowany.
                            </div>
                            <div class="action">
                                <? if ($this->Session->read('Auth.User.id')) {?>
                                    <a href="/moje-dane" target="_self" class="btn btn-primary btn-icon">
                                        <img class="icon" src="/MojeDane/icon/powiadomienia.svg" alt=""/>Moje Dane
                                    </a>
                                <? } else { ?>
                                    <a href="/moje-dane/jak_to_dziala" target="_self" class="btn btn-primary btn-icon">
                                        <img class="icon" src="/MojeDane/icon/powiadomienia.svg" alt=""/>Zacznij obserwować
                                    </a>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 part">
                        <div class="shoutBrick mainBrick">
                            <div class="title">Moje Pisma</div>
                            <span class="line"></span>

                            <div class="description">
                                Wysyłaj wnioski o udostępnienie informacji publicznych oraz inne pisma do urzędów i
                                dziel się nimi w mediach społecznościowych.
                            </div>
                            <div class="action">
                                <? if ($this->Session->read('Auth.User.id')) {?>
                                    <a href="/moje-pisma" target="_self" class="btn btn-primary btn-icon">
                                        <img class="icon" src="/MojePisma/icon/pisma.svg" alt=""/>Moje Pisma
                                    </a>
                                <? } else { ?>
                                    <a href="/moje-pisma/nowe" target="_self" class="btn btn-primary btn-icon">
                                        <img class="icon" src="/MojePisma/icon/pisma.svg" alt=""/>Napisz pismo
                                    </a>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>