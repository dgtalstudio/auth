<?php
function param($param, $v = false, $isPost = true) {
	$var = $isPost ? $_POST : $_SERVER;
	return isset($var[$param]) && $var[$param] ? $var[$param] : $v;
}

function isAjax($with = 'XMLHttpRequest') {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === $with;
}

function cors($domain = 'http://localhost') {
	// $origin = param('HTTP_ORIGIN', $domain, false);
	// $pattern = '/^http(s)?:\/\/(.+\.)?(localhost\:1234|lagden\.in)$/i';
	// $res = preg_match($pattern, $origin);
	// $origin = $res ? $origin : $domain;

	// header("Access-Control-Allow-Origin: {$origin}");
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type, Content-MD5, X-Requested-With');
	header('Access-Control-Allow-Credentials: true');
}
