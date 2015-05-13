<div id="_mPCockpit">
    <div class="_mPBasic">
        <div class="_mPLogo">
            <a href="/" target="_self">
                <img src="/icon/moje_panstwo_logo.svg" title="moje Państwo"/>
            </a>
        </div>


        <div class="_mPApplication">
            <div class="_mPPowerButton">
                <?php if ($this->Session->read('Auth.User.id')) { ?>
                    <a href="<?php echo $this->Html->url('/logout'); ?>"><?php echo __('LC_COCKPITBAR_LOGOUT'); ?></a>
                <?php } else { ?>
                    <a class="_specialCaseLoginButton"
                       href="<?php echo $this->Html->url('/login'); ?>"><?php echo __('LC_COCKPITBAR_LOGIN'); ?></a>
                <?php } ?>
            </div>
            <?php if ($this->Session->read('Auth.User.id')) { ?>
                <a class="_mPAppsList _appBlock _appBlockBackground _mPAccount<? if ($appSelected == 'paszport') echo " _appBlockActive"; ?>"
                   href="<?php echo $this->Html->url(array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'profile')); ?>"
                   target="_self">
                    <div class="_mPTitle">
                        <i class="_mPAppIcon glyphicon glyphicon-user"></i>

                        <p class="_mPAppLabel">
                            <span><?= $this->Text->truncate($this->Session->read('Auth.User.username'), 13); ?></span>
                        </p>
                    </div>
                </a>

                <? /*
                <div class="_mPUser">
                    <a href="">
                        <img src="<?php if ($this->Session->read('Auth.User.photo_small')) {
                            echo $this->Session->read('Auth.User.photo_small');
                        } else {
                            echo '/img/avatars/avatar_default.jpg';
                        } ?>"/>
                        <span></span>
                    </a>
                </div>
                */ ?>

            <?php } ?>

            <div class="_mPSearch _appBlock _appBlockBackground">
                <div class="_mPTitle">
                    <i class="_mPAppIcon" data-icon="&#xe600;"></i>

                    <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_USER_SEARCH'); ?></p>
                    <? /* <span class="_mPAppBadge badge">Przykład znacznika libczy przy ikonie</span> */ ?>
                </div>
            </div>
            <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected == 'dane') echo " _appBlockActive"; ?>"
               href="/dane" target="_self">
                <div class="_mPTitle">
                    <i class="_mPAppIcon" data-icon="&#xe61e;"></i>

                    <p class="_mPAppLabel">Dane publiczne</p>
                </div>
            </a>
            <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected == 'moje-dane') echo " _appBlockActive"; ?>"
               href="/moje-dane" target="_self">
                <div class="_mPTitle">
                    <i class="_mPAppIcon" data-icon-applications="&#xe60a;"></i>

                    <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_USER_MY_DATA'); ?></p>
                </div>
            </a>
            <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected == 'moje-pisma') echo " _appBlockActive"; ?>"
               href="/moje-pisma" target="_self">
                <div class="_mPTitle">
                    <i class="_mPAppIcon" data-icon-applications="&#xe60b;"></i>

                    <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_USER_MY_DOCS'); ?></p>
                </div>
            </a>

        </div>
        <div class="_mPSystem">
            <div class="_mPRunning">
            </div>
        </div>
    </div>
    <? /*<div class="_mPAppList">
        <?php if (!empty($_APPLICATIONS)) {
            foreach ($_APPLICATIONS as $app) {
                if ($app['home'] == '1') {
                    if ($app['type'] == 'app') {
                        ?>
                        <div class="_appBlock _appBlockBackground">
                            <a class="_appConstruct" href="/<?= $app['slug'] ?>">
                                <div class="_mPAppIcon">
                                    <img
                                        src="/<?= $app['plugin'] ?>/icon/<?= $app['slug'] ?>.svg"
                                        alt="<?= $app['name'] ?>"/>
                                </div>
                                <div class="_mPTitle"><?= $app['name'] ?></div>
                            </a>
                        </div>
                    <?php } else if ($app['Application']['type'] == 'folder') { ?>
                        <div class="_appConstruct _appFolder" data-folder-slug="/<?= $app['slug'] ?>">
                            <div class="_mpAppFolderIcon">
                                <img src="/icon/folder.svg"
                                     alt="<?= $app['name'] ?>"/>
                            </div>
                            <div class="_mPTitle"><?= $app['name'] ?></div>
                            <div class="_appList">
                                <?php foreach ($app['Content'] as $key => $appList) { ?>
                                    <div class="_appBlock _appBlockBackground">
                                        <a href="/<?= $appList['slug'] ?>">
                                            <div class="_mPAppIcon">
                                                <img src="/<?= $appList['plugin'] ?>/icon/<?= $appList['slug'] ?>.svg"
                                                     alt="<?= $appList['name'] ?>"/>
                                            </div>
                                            <div class="_mPTitle"><?= $appList['name'] ?></div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                    }
                }
            }
        } ?>
    </div>*/ ?>
</div>