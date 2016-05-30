<header>
    <div id="_mPCockpitMobile">
        <div class="_mPShowMenu">
            <button type="button" class="tcon tcon-menu--xcross" aria-label="toggle menu">
                <span class="tcon-menu__lines" aria-hidden="true"></span>
                <span class="tcon-visuallyhidden">toggle menu</span>
            </button>
        </div>
        <div class="_mPLogo">
            <a href="/" target="_self" title="Link do strony głównej">
                <img src="/icon/moje_panstwo_logo.svg" title="moje Państwo" alt="Logo Mojego Państwa"/>
            </a>
        </div>
    </div>
    <?php echo $this->Element('sidebars/bar', array(
        'mode' => @$statusbarMode,
        'applications' => array(
            'list' => @$_APPLICATIONS,
            'perPage' => 6,
            'perRow' => 3,
        ),
        'applicationCurrent' => @$_APPLICATION,
        'applicationCrumbs' => @$statusbarCrumbs,
        'streams' => $this->Session->read('Auth.User.streams'),
    ));
    /*echo $this->Element('Paszport.modal_login');
    echo $this->Element('modals/suggester', array(
        'placeholder' => __("LC_SEARCH_PUBLIC_DATA_PLACEHOLDER"),
        'action' => '/dane',
    ));*/
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
</header>
