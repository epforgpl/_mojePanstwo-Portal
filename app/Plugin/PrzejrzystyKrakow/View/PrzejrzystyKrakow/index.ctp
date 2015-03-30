<?php $this->Combinator->add_libs('css', $this->Less->css('home')) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('przejrzysty_krakow', array('plugin' => 'PrzejrzystyKrakow'))) ?>
<?php $this->Combinator->add_libs('js', 'home') ?>

<div id="home" class="fullPageHeight przejrzystyKrakow">
    <div class="_handler container">
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
                                Wysyłaj wnioski o udostępnienie informacji publicznych oraz inne pisma do urzędów i
                                dziel się nimi w mediach społecznościowych.
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
                        <img class="svg" alt="Aktualności" src="/PrzejrzystyKrakow/img/icons/aktualnosci.svg">

                        <p>Aktualności</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/rada"
                       target="_self">
                        <img class="svg" alt="Rada miasta" src="/PrzejrzystyKrakow/img/icons/rada_miasta.svg">

                        <p>Rada miasta</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/urzad"
                       target="_self">
                        <img class="svg" alt="Urząd Miasta" src="/PrzejrzystyKrakow/img/icons/urzad_miasta.svg">

                        <p>Urząd Miasta</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/organizacje"
                       target="_self">
                        <img class="svg" alt="Organizacje" src="/PrzejrzystyKrakow/img/icons/organizacje.svg">

                        <p>Organizacje</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/zamowienia"
                       target="_self">
                        <img class="svg" alt="Zamówienia publiczne"
                             src="/PrzejrzystyKrakow/img/icons/zamowienia_publiczne.svg">

                        <p>Zamówienia publiczne</p>
                    </a>
                    <a class="homePageIcon col-xs-6 col-sm-3 col-md-2" href="/dane/gminy/903,krakow/wybory"
                       target="_self">
                        <img class="svg" alt="Wybory" src="/PrzejrzystyKrakow/img/icons/wybory.svg">

                        <p>Wybory</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>