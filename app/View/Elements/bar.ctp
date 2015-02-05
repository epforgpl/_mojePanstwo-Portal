<div id="_mPCockpit" class="col-md-2">
    <div class="_mPBasic">
        <div class="_mPLogo">
            <a href="/" target="_self">
                <strong>moje</strong>państwo
            </a>
        </div>
        <div class="_mPApplication">
            <div class="_mPSearch _appBlock _appBlockBackground">
                <div class="_mPTitle">
                    <i class="_mPAppIcon" data-icon-new="&#xe802;"></i>

                    <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_USER_SEARCH'); ?></p>
                </div>
            </div>
        </div>
        <div class="_mPSystem">
            <div class="_mPRunning">

            </div>
            <div class="_mPApplication">
                <a class="_mPAppsList _appBlock _appBlockBackground" href="/apps" target="_self">
                    <div class="_mPTitle">
                        <i class="_mPAppIcon" data-icon-new="&#xe800;"></i>

                        <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_USER_APPLICATION'); ?></p>
                    </div>
                </a>
            </div>
            <div class="_mPUser">
                <img src="<?php if ($this->Session->read('Auth.User.photo_small')) {
                    echo $this->Session->read('Auth.User.photo_small');
                } else {
                    echo '/img/avatars/avatar_default.jpg';
                } ?>"/>

                <a href="<?php echo $this->Html->url(array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'index')); ?>"><?php echo __('LC_COCKPITBAR_USER_LINK'); ?></a>
            </div>
            <div class="_mPPowerButton">
                <?php if ($this->Session->read('Auth.User.id')) { ?>
                    <a href="<?php echo $this->Html->url(array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'logout')); ?>"><?php echo __('LC_COCKPITBAR_LOGOUT'); ?></a>
                <?php } else { ?>
                    <a href="<?php echo $this->Html->url(array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'login')); ?>"><?php echo __('LC_COCKPITBAR_LOGIN'); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="_mPAppList">
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
    </div>
</div>