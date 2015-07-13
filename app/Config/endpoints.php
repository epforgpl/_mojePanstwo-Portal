<?php

$endpoints = array(
	'Userbar' => array(
//        'header' => 'mpapi.pl/paszport/header.json',
		'header' => 'paszport.epf.org.pl/users/client',
		'footer' => 'mpapi.pl/paszport/footer.json',
	),
	'User'    => array(
		'userinfo' => 'paszport.epf.org.pl/users/client',
	),
	'OAuth'   => array(
		'userinfo' => 'paszport.epf.org.pl/oauth/userinfo',
		'authcode' => 'paszport.epf.org.pl/oauth/authorize',
		'token'    => 'paszport.epf.org.pl/oauth/token'
	),
);

Configure::write( 'Endpoints', $endpoints );