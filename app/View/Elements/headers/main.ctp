<div id="portal-header" class="mp-sticky">
    <?php
    echo $this->Element('Paszport.modal_login');
    echo $this->Element('modals/suggester', array(
        'placeholder' => __("LC_SEARCH_PUBLIC_DATA_PLACEHOLDER"),
        'action' => '/',
    ));
    ?>

    <? if (isset($crossdomain_login_token) || isset($crossdomain_logout)) { ?>
        <div id="cross-domain-login" class="hidden">
            <?
            $crossdomain_hosts = array();
            if ($current_host == PK_DOMAIN) {
                array_push($crossdomain_hosts, PORTAL_DOMAIN);
            } else {
                array_push($crossdomain_hosts, PK_DOMAIN);
            }

            if (isset($crossdomain_login_token)) {
                foreach ($crossdomain_hosts as $host) {
                    echo '<img src="http://' . $host . '/cross-domain-login?token=' . $crossdomain_login_token . '">';
                }
            }

            if (isset($crossdomain_logout)) {
                foreach ($crossdomain_hosts as $host) {
                    echo '<img src="http://' . $host . '/cross-domain-logout">';
                }
            }

            ?>
        </div>
    <?php } ?>
    <div>
        <div class="mpLogoBlock">
            <a href="/" target="_self">
                <img id="mp-logo" src="/img/mp-logo-new.svg" title="moje Państwo"/>
            </a>
        </div>
        <ul class="app-icons pull-left">
            <li>
                <a class="_mPSearch _appBlock _appBlockBackground" href="/#szukaj">
                    <span class="_mPAppIcon" data-icon="&#xe600;"></span>
                </a>
            </li>
            <? /*
            <li>
                <a class="_mPAppsList _appBlock _appBlockBackground" href="/moje-powiadomienia" target="_self">
                    <span class="_mPAppIcon" data-icon-applications="&#xe60a;"></span>
                    <span class="_mPAppBadge badge">0</span>
                </a>
            </li>
            */ ?>
            <li class="apps">
                <a class="_mPAppsList _appBlock _appBlockBackground" href="/#aplikacje" target="_self">
                    <span class="_mPAppIcon glyphicon glyphicon-th"></span>
                </a>
                <div class="appsList">
                    <ul class="appListUl">
                        <? $i = 0;
                        foreach ($_applications as $app_id => $app) {
                            if ($app['tag'] == 1) {
                                $path = (isset($app['path']) && !empty($app['path'])) ? $app['path'] : $app_id;
                                $icon_link = '/' . $path . '/icon/icon_' . $app_id . '.svg';

                                if ($i == 9) {
                                    echo '</ul><a href="#appsMore" class="btn btn-link appListMore">Więcej</a><ul class="appListUl moreList">';
                                }
                                $i++;
                                ?>
                                <li>
                                    <a target="_self" href="<?= $app['href'] ?>"
                                       class="_mPAppsList _appBlock _appBlockBackground text-center">
                                        <img src="<?= $icon_link ?>" class="_mPAppIcon icon"/>
                                        <p class="_mPAppLabel"><?= $app['name'] ?></p>
                                    </a>
                                </li>
                                <?
                            }
                        }
                        foreach ($_applications as $app_id => $app) {
                            if ($app['tag'] == 2) {
                                $path = (isset($app['path']) && !empty($app['path'])) ? $app['path'] : $app_id;
                                $icon_link = '/' . $path . '/icon/icon_' . $app_id . '.svg';

                                if ($i == 9) {
                                    echo '</ul><a href="#appsMore" class="btn btn-link appListMore">Więcej</a><ul class="appListUl moreList">';
                                }
                                $i++;
                                ?>
                                <li>
                                    <a target="_self" href="<?= $app['href'] ?>"
                                       class="_mPAppsList _appBlock _appBlockBackground text-center">
                                        <img src="<?= $icon_link ?>" class="_mPAppIcon icon"/>
                                        <p class="_mPAppLabel"><?= $app['name'] ?></p>
                                    </a>
                                </li>
                                <?
                            }
                        }
                        ?>
                    </ul>
                    <? if ($i >= 9) {
                        echo '<a href="#appsLess" class="btn btn-link appListLess">Mniej</a>';
                    } ?>
                </div>
            </li>
        </ul>
        <ul class="user-icons pull-right">
            <li class="login">
                <?php if ($this->Session->read('Auth.User.id')) { ?>
                    <?php if ($this->Session->read('Auth.User.username')) {
                        $name = $this->Session->read('Auth.User.username');
                    } else {
                        $name = $this->Session->read('Auth.User.personal_name') . ' ' . $this->Session->read('Auth.User.personal_lastname');
                    } ?>

                    <div class="optionsBtn">
                        <?php if ($this->Session->read('Auth.User.photo_small')) {
                            echo '<img class="avatar" src="' . $this->Session->read('Auth.User.photo_small') . '" alt=""/>';
                        } else {
                            echo '<span class="_mPAppIcon _mPIconUser roundBorder" data-icon="&#xe620;"></span>';
                        } ?>

                        <p class="name" title="<?php echo $name; ?>"><?php
                            echo $this->Text->truncate($name, 12, array(
                                    'ellipsis' => '...',
                                    'exact' => true
                                )
                            ); ?></p>
                    </div>
                    <ul id="mPUserOptions" class="optionsList">
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
                    <a class="_specialCaseLoginButton" href="<?php echo $this->Html->url('/login'); ?>">
                        <i class="_mPAppIcon _mPIconUser" data-icon="&#xe620;"></i>
                    </a>
                <?php } ?>
            </li>
        </ul>
    </div>
</div>
