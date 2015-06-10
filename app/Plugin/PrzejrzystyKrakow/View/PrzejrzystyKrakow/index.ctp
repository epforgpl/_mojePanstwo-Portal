<?php $this->Combinator->add_libs('css', $this->Less->css('home')) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('przejrzysty_krakow', array('plugin' => 'PrzejrzystyKrakow'))) ?>
<?php $this->Combinator->add_libs('js', 'home') ?>

<div id="home" class="fullPageHeight przejrzystyKrakow">
    <div class="_handler container">
        <div class="startWindow col-xs-12 col-md-10 col-md-offset-1">
            <div class="windowSet">
                <div class="headerBar">
                    <div class="col-xs-12">
                        <img class="img-responsive" src="/Dane/img/customObject/krakow/logo_pkrk.png" alt="PKRK"/>

                        <h1>Przejrzysty Kraków</h1>

                        <p class="subh text-center">Portal oparty o dane publiczne o Krakowie. Prowadzony przez Fundację
                            Stańczyka.</p>
                    </div>
                </div>
                <div class="_mPSearchOutside">
                    <form class="suggesterBlock" action="http://przejrzystykrakow.pl/">
                        <div class="main_input">
                            <i class="glyph-addon" data-icon="&#xe600;"></i>
                            <input name="q" value="" type="text" autocomplete="off"
                                   class="datasearch form-control input-lg"
                                   placeholder="<?= __("Szukaj w Przejrzystym Krakowie...") ?>" <?php if (isset($app)) {
                                echo 'data-app="' . $app . '"';
                            } ?> />
                        </div>
                    </form>
                </div>
                <div class="basicOptions">
                    <div class="col-xs-12 col-sm-6 part">
                        <div class="observeBrick mainBrick">
                            <div class="title">Obserwuj</div>
                            <span class="line"></span>

                            <div class="description">
                                Otrzymuj powiadomienia o aktywnościach Rady Miasta, Prezydenta Krakowa i innych danych.
                            </div>
                            <div class="action">
                                <a href="/powiadomienia" target="_self" class="btn btn-primary btn-icon">
                                    <span class="glyphicon icon" data-icon-applications="&#xe60a;"
                                          aria-hidden="true"></span> <span
                                        class="btn-text">Zacznij obserwować</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 part">
                        <div class="shoutBrick mainBrick">
                            <div class="title">Komunikuj</div>
                            <span class="line"></span>

                            <div class="description">
                                Wysyłaj pisma do radnych Krakowa i instytucji miejskich.
                            </div>
                            <div class="action">
                                <a href="/pisma" target="_self" class="btn btn-primary btn-icon">
                                    <span class="glyphicon icon" data-icon-applications="&#xe60b;"
                                          aria-hidden="true"></span> <span
                                        class="btn-text">Napisz pismo</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <? /* Wszystkie poyzcje z menu, poza zamowieniami publicznymi i KRS */ ?>
                <div class="appsList">
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow" target="_self">
                        <img alt="Aktualności" src="/PrzejrzystyKrakow/img/icon/aktualnosci.svg">
                        <i class="icon" data-icon-pk=""></i>

                        <p>Aktualności</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/rada"
                       target="_self">
                        <img alt="Rada miasta" src="/PrzejrzystyKrakow/img/icon/rada_miasta.svg">

                        <p>Rada miasta</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/urzad"
                       target="_self">
                        <img alt="Urząd Miasta" src="/PrzejrzystyKrakow/img/icon/urzad_miasta.svg">

                        <p>Urząd Miasta</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/dzielnice"
                       target="_self">
                        <img alt="Organizacje" src="/PrzejrzystyKrakow/img/icon/dzielnice.svg">

                        <p>Dzielnice</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/druki"
                       target="_self">
                        <img alt="Rada miasta" src="/PrzejrzystyKrakow/img/icon/proces.svg">

                        <p>KRS</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/radni"
                       target="_self">
                        <img alt="Rada miasta" src="/PrzejrzystyKrakow/img/icon/radni_miasta.svg">

                        <p>Finanse</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/radni"
                       target="_self">
                        <img alt="Rada miasta" src="/PrzejrzystyKrakow/img/icon/radni_miasta.svg">

                        <p>Powiązania</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>