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
                        
                        <p class="subh">Program Przejrzysty Kraków, prowadzony przez Fundację Stańczyka, ma na celu wieloaspektowy monitoring życia publicznego w Krakowie. W ramach programu prowadzony jest obecnie monitoring Rady Miasta i Dzielnic Krakowa. </p>
                        
                    </div>
                </div>
                <div class="_mPSearchOutside">
                    <form class="suggesterBlock" action="/dane">
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
                                    <img class="icon" src="/Powiadomienia/icon/powiadomienia.svg" alt=""/>Zacznij
                                    obserwować</a>
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
                                    <img class="icon" src="/Pisma/icon/pisma.svg" alt=""/>Napisz pismo</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popularApps">
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow" target="_self">
                        <img class="svg" alt="Aktualności" src="/PrzejrzystyKrakow/img/icon/aktualnosci.svg">

                        <p>Aktualności</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/rada"
                       target="_self">
                        <img class="svg" alt="Rada miasta" src="/PrzejrzystyKrakow/img/icon/rada_miasta.svg">

                        <p>Rada miasta</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/urzad"
                       target="_self">
                        <img class="svg" alt="Urząd Miasta" src="/PrzejrzystyKrakow/img/icon/urzad_miasta.svg">

                        <p>Urząd Miasta</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/organizacje"
                       target="_self">
                        <img class="svg" alt="Organizacje" src="/PrzejrzystyKrakow/img/icon/organizacje.svg">

                        <p>Organizacje</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/zamowienia"
                       target="_self">
                        <img class="svg" alt="Zamówienia publiczne"
                             src="/PrzejrzystyKrakow/img/icon/zamowienia_publiczne.svg">

                        <p>Zamówienia publiczne</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/wybory"
                       target="_self">
                        <img class="svg" alt="Wybory" src="/PrzejrzystyKrakow/img/icon/wybory.svg">

                        <p>Wybory</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>