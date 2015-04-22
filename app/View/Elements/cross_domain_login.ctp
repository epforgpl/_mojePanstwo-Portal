<span id="cross-domain-login" style="display: none">
<?
    $crossdomain_hosts = array();
    if ($current_host == PK_DOMAIN) {
        array_push($crossdomain_hosts, PORTAL_DOMAIN);
    } else {
        array_push($crossdomain_hosts, PK_DOMAIN);
    }

    if (isset($crossdomain_login_token)) {
        foreach($crossdomain_hosts as $host) {
            echo '<img src="http://'. $host .'/cross-domain-login?token=' . $crossdomain_login_token . '">';
        }
    }

    if (isset($crossdomain_logout)) {
        foreach($crossdomain_hosts as $host) {
            echo '<img src="http://'. $host .'/cross-domain-logout">';
        }
    }

    ?>
</span>