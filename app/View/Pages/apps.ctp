<?php $this->Combinator->add_libs('css', $this->Less->css('home')) ?>

<div id="home" class="fullPageHeight"
     style="background-image: url('/img/home/backgrounds/home-background-default.jpg')">
    <div class="_handler container">
        <div class="startWindow col-xs-12 col-md-10 col-md-offset-1">
            <div class="windowSet">
                <div class="popularApps row">
                    <a class="homePageIcon col-xs-12 col-sm-3 col-md-2" href="/dane" target="_self">
                        <img class="svg" alt="Dane" src="/dane/icon/dane.svg">

                        <p>Dane</p>
                    </a>
                    <?php if (!empty($_APPLICATIONS)) {
                        foreach ($_APPLICATIONS as $app) {
                            if ($app['home'] == '1') {
                                if ($app['type'] == 'app') {
                                    ?>
                                    <a class="homePageIcon col-xs-12 col-sm-3 col-md-2" href="/<?= $app['slug'] ?>">
                                        <img class="svg"
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
    </div>
</div>