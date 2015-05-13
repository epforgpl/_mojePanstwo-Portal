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
                    <img class="avatar"
                         src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/v/t1.0-1/c0.0.160.160/p160x160/200389_203882612962896_3612896_n.jpg?oh=49af22e4cc2df7e0142baba17a2d681f&oe=55CC8588&__gda__=1440275973_10426031c15c5f885ed74b3a6901483c"
                         alt=""/>
                    <div class="optionsBtn" data-toggle="collapse"
                         data-target="#mPUserOptions" aria-expanded="false" aria-controls="mPUserOptions">
                        <span class="glyphicon" aria-hidden="true">&#x25BC;</span>
                    </div>
                    <ul id="mPUserOptions" class="optionsList collapse">
                        <li>
                            <a href="<?php echo $this->Html->url(array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'profile')); ?>"
                               target="_self">Podstawowe informacje</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/logout'); ?>"
                               target="_self"><?php echo __('LC_COCKPITBAR_LOGOUT'); ?></a>
                        </li>
                    </ul>
                <?php } else { ?>
                    <a class="_specialCaseLoginButton"
                       href="<?php echo $this->Html->url('/login'); ?>">
                        <i class="_mPAppIcon glyphicon glyphicon-user"></i>

                        <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_LOGIN'); ?></p>
                    </a>
                <?php } ?>
            </div>
            <?php if ($this->Session->read('Auth.User.id')) { ?>


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