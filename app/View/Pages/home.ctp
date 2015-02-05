<?php $this->Combinator->add_libs('css', $this->Less->css('home')) ?>
<?php $this->Combinator->add_libs('js', 'home') ?>

<div id="home" class="fullPageHeight noRestriction"
     style="background-image: url('/img/home/backgrounds/home-background-default.jpg')">
    <?php /*
    <div class="grid">
        <ul>
            <li data-x="1" data-y="1" data-col="2">Zamówienia publiczne</li>
            <li data-x="0" data-y="2" data-col="2">Ustawy</li>
            <li data-x="2" data-y="3" data-row="3">Wniosek</li>
            <li data-x="7" data-y="1" data-row="2" data-col="2">Dochody</li>
        </ul>
    </div>
    */ ?>
    <div class="container startWindow">
        <div class="windowSet col-xs-12 col-sm-10 col-md-6 col-sm-offset-1 col-md-offset-3">
            <div class="basicOptions row">
                <div class="col-xs-6 part">
                    <div class="observeBrick mainBrick">
                        <div class="title">Obserwuj</div>
                        <span class="line"></span>

                        <div class="description">
                            Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non
                            felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula.
                        </div>
                        <div class="action">
                            <a href="/obserwuj" target="_self" class="btn btn-primary btn-lg">Zacznij obserwować</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 part">
                    <div class="shoutBrick mainBrick">
                        <div class="title">Komunikuj</div>
                        <span class="line"></span>

                        <div class="description">
                            Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non
                            felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula.
                        </div>
                        <div class="action">
                            <a href="/pisma" target="_self" class="btn btn-primary btn-lg">Napisz pismo</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popularApps row">
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/dane" target="_self">
                    <img alt="Dane" src="/dane/icon/dane.svg">

                    <p>Dane</p>
                </a>
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/kto_tu_rzadzi" target="_self">
                    <img alt="Kto tu rządzi?" src="/KtoTuRzadzi/icon/kto_tu_rzadzi.svg">

                    <p>Kto tu rządzi?</p>
                </a>
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/krs" target="_self">
                    <img alt="Krajowy Rejestr Sądowy" src="/krs/icon/krs.svg">

                    <p>Krajowy Rejestr Sądowy</p>
                </a>
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/prawo" target="_self">
                    <img alt="Prawo" src="/prawo/icon/prawo.svg">

                    <p>Prawo</p>
                </a>
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/media" target="_self">
                    <img alt="Media" src="/media/icon/media.svg">

                    <p>Media</p>
                </a>
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/apps" target="_self">
                    <i class="_mPAppIcon" data-icon-new="&#xe800;" alt="Wszystkie aplikacje"></i>

                    <p>Wszystkie aplikacje</p>
                </a>
            </div>
        </div>
    </div>
    <div class="options">
        <ul>
            <li><?php echo $this->Html->link(__('LC_FOOTER_ABOUT_US'), '/oportalu', array('target' => '_self')); ?></li>
            <li><?php echo $this->Html->link(__('LC_FOOTER_API'), '/api', array('target' => '_self')); ?></li>
            <li><?php echo $this->Html->link(__('LC_FOOTER_REGULATIONS'), '/regulamin', array('target' => '_self')); ?></li>
            <li><?php echo $this->Html->link(__('LC_FOOTER_REPORT_BUG'), '/zglosblad', array('target' => '_self')); ?></li>
            <li><?php /*echo $this->Html->link(__('LC_FOOTER_CONTACT_US'), '/kontakt', array('target' => '_self'));*/ ?></li>
            <li class="last"><a href="#" target="_self">Personalizuj</a></li>
        </ul>
    </div>
</div>