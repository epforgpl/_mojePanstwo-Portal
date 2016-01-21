<div id="_mPCockpit">
    <div class="_mPBasic">
        <div class="_mPLogo">
            <a href="/" target="_self" title="Link do strony głównej">
                <img src="/icon/moje_panstwo_logo.svg" title="moje Państwo" alt="Logo Mojego Państwa"/>
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
                    <?php if ($this->Session->read('Auth.User.photo_small')) {
                        echo '<img class="avatar" src="' . $this->Session->read('Auth.User.photo_small') . '" alt=""/>';
                    } else {
                        echo '<span class="_mPAppIcon _mPIconUser roundBorder" data-icon="&#xe620;"></span>';
                    } ?>
                    <div class="optionsBtn" data-toggle="collapse"
                         data-target="#mPUserOptions" aria-expanded="false" aria-controls="mPUserOptions">
                        <span class="glyphicon" aria-hidden="true">&#x25BC;</span>
                    </div>
                    <ul id="mPUserOptions" class="optionsList collapse">
                        <li>
                            <a href="<?php echo $this->Html->url(array('plugin' => 'Start', 'controller' => 'Account', 'action' => 'index')); ?>"
                               target="_self"><?php echo __('LC_COCKPITBAR_USER_BASIC_INFO'); ?></a>
                        </li>
                        <!-- TODO Przywrocic konczac #521
                        <li>
                            <a href="<?php echo $this->Html->url(array('plugin' => 'paszport', 'controller' => 'api_apps', 'action' => 'index')); ?>"
                               target="_self"><?php echo __('LC_COCKPITBAR_USER_BASIC_APPS'); ?></a>
                        </li>
                        -->
                        <li>
                            <a href="<?php echo $this->Html->url('/logout'); ?>"
                               target="_self"><?php echo __('LC_COCKPITBAR_LOGOUT'); ?></a>
                        </li>
                    </ul>
                <?php } else { ?>
                    <a class="_specialCaseLoginButton"
                       href="<?php echo $this->Html->url('/login'); ?>">
                        <span class="_mPAppIcon _mPIconUser" data-icon="&#xe620;"></span>

                        <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_LOGIN'); ?></p>
                    </a>
                <?php } ?>
            </div>
            <div
                class="_mPSearch _appBlock _appBlockBackground<? if ($appSelected == 'search') echo " _appBlockActive"; ?>">
                <div class="_mPTitle">
                    <span class="_mPAppIcon" data-icon="&#xe600;"></span>

                    <p class="_mPAppLabel"><?php echo __('LC_COCKPITBAR_USER_SEARCH'); ?></p>
                    <? /* <span class="_mPAppBadge badge">Przykład znacznika libczy przy ikonie</span> */ ?>
                </div>
            </div>
            <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected === '') echo " _appBlockActive"; ?>"
               href="/" target="_self">
                <div class="_mPTitle">
                    <span class="_mPAppIcon" data-icon="&#xe61e;"></span>

                    <p class="_mPAppLabel">Aplikacje</p>
                </div>
            </a>
            <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected == 'powiadomienia') echo " _appBlockActive"; ?>"
               href="/moje-powiadomienia" target="_self">
                <div class="_mPTitle">
                    <span class="_mPAppIcon" data-icon-applications="&#xe60a;"></span>

                    <p class="_mPAppLabel">Powiadomienia</p>
                </div>
            </a>
            <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected == 'pisma') echo " _appBlockActive"; ?>"
               href="/moje-pisma" target="_self">
                <div class="_mPTitle">
                    <span class="_mPAppIcon" data-icon-applications="&#xe60b;"></span>

                    <p class="_mPAppLabel">Pisma</p>
                </div>
            </a>
            <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected == 'kolekcje') echo " _appBlockActive"; ?>"
               href="/moje-kolekcje" target="_self">
                <div class="_mPTitle">
                    <span class="glyphicon glyphicon-folder-open _mPAppIcon" aria-hidden="true"></span>
                    <p class="_mPAppLabel">Kolekcje</p>
                </div>
            </a>
            <? if (isset($isAdmin) && $isAdmin === true) { ?>
                <a class="_mPAppsList _appBlock _appBlockBackground<? if ($appSelected == 'admin') echo " _appBlockActive"; ?>"
                   href="/admin" target="_self">
                    <div class="_mPTitle">
                        <span class="glyphicon glyphicon-cog _mPAppIcon" aria-hidden="true"></span>
                        <p class="_mPAppLabel">Admin</p>
                    </div>
                </a>
            <? } ?>

        </div>
        <div class="_mPSystem">
            <div class="_mPRunning">
            </div>
        </div>
    </div>
</div>
