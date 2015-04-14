<header>
    <div id="_mPCockpitMobile">
        <div class="_mPShowMenu">
            <button type="button" class="tcon tcon-menu--xcross" aria-label="toggle menu">
                <span class="tcon-menu__lines" aria-hidden="true"></span>
                <span class="tcon-visuallyhidden">toggle menu</span>
            </button>
        </div>
        <div class="_mPLogo">
            <a href="/" target="_self">
                <img src="/icon/moje_panstwo_logo.svg" title="moje Państwo"/>
            </a>
        </div>
    </div>
    <?php echo $this->Element('bar', array(
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
    echo $this->Element('Paszport.modal_login');
    ?>
</header>