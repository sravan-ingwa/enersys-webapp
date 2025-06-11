<?php

	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "enersys";
	$baseUrl = "http://localhost/enersys/";
	$newBaseUrl = "http://localhost/enersys/";
	$localUrl = "http://localhost/enersys/";

	$oktaBaseUrl = "http://103.12.118.115";
	$oktaPreviewUrl = "https://Enersys-apac.oktapreview.com/oauth2/default/v1";
	$oktaClientKey = "0oaj3n4bvvT60gYuW0h7";
	$oktaRedirectUri = $oktaBaseUrl . "/okta/redirect.php";
	$oktaState = "state-296bc9a0-a2a2-4a57-be1a-d0e2fd9bb601";
	$oktaURI = $oktaPreviewUrl . "/authorize?response_mode=form_post&client_id=$oktaClientKey&response_type=token&scope=openid+profile+email&redirect_uri=$oktaRedirectUri&state=$oktaState&nonce=g5ly497e8ps";

	$envSms = [
		'send' => false,
		'url' => "http://bhashsms.com/api/sendmsg.php",
		'user' => 'enersyscare',
		'pass' => 'sairaam@5050',
		'sender' => 'EnrSys',
		'priority' => 'ndnd',
		'stype' => 'normal',
	];

?>