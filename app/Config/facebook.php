<?php
/**
 * Get an api_key and secret from facebook and fill in this content.
 * save the file to app/Config/facebook.php
 */
$config = array(
	'Facebook' => array(
		'appId'  => FACEBOOK_appId,
		'apiKey' => FACEBOOK_apiKey,
		'secret' => FACEBOOK_secret,
		'cookie' => true,
		'locale' => 'en_US',
	)
);
?>