<?php $this->Combinator->add_libs('css', $this->Less->css('home')) ?>

<div id="home" class="fullPageHeight noRestriction"
     style="background-image: url('/img/home/backgrounds/home-background-default.jpg')">
    <div class="container startWindow">
        <div class="windowSet col-xs-12 col-sm-10 col-md-6 col-sm-offset-1 col-md-offset-3">
            <div class="popularApps row">
                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/dane" target="_self">
                    <img alt="Dane" src="/dane/icon/dane.svg">

                    <p>Dane</p>
                </a>
                <?php if (!empty($_APPLICATIONS)) {
                    foreach ($_APPLICATIONS as $app) {
                        if ($app['home'] == '1') {
                            if ($app['type'] == 'app') {
                                ?>
                                <a class="homePageIcon col-xs-6 col-sm-4 col-md-2" href="/<?= $app['slug'] ?>">
                                    <img
                                        src="/<?= $app['plugin'] ?>/icon/<?= $app['slug'] ?>.svg"
                                        alt="<?= $app['name'] ?>"/>

                                    <p><?= $app['name'] ?></p>
                                </a>
                            <?php }
                        }
                    }
                } ?>
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