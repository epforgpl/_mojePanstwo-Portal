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
                    <?php if ($this->Session->read('Auth.User.username')) {
                        $name = $this->Session->read('Auth.User.username');
                    } else {
                        $name = $this->Session->read('Auth.User.personal_name') . ' ' . $this->Session->read('Auth.User.personal_lastname');
                    }
                    ?>
                    <div class="name" title="<?php echo $name; ?>"><?php
                        echo $this->Text->truncate($name, 12, array(
                                'ellipsis' => '...',
                                'exact' => true
                            )
                        ); ?></div>
                    <img class="avatar<?php if ($this->Session->read('Auth.User.photo_small')) {
                        echo '" src="' . $this->Session->read('Auth.User.photo_small');
                    } else {
                        echo ' default" src="/img/avatars/avatar_default.svg';
                    } ?>" alt=""/>
                    <div class="optionsBtn" data-toggle="collapse"
                         data-target="#mPUserOptions" aria-expanded="false" aria-controls="mPUserOptions">
                        <span class="glyphicon" aria-hidden="true">&#x25BC;</span>
                    </div>
                    <ul id="mPUserOptions" class="optionsList collapse">
                        <li>
                            <a href="<?php echo $this->Html->url(array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'profile')); ?>"
                               target="_self"><?php echo __('LC_COCKPITBAR_USER_BASIC_INFO'); ?></a>
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

                    <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_USER_PUBLIC_DATA'); ?></p>
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
</div>