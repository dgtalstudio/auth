<?php
require_once dirname(__FILE__).'/helpers.php';
cors();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	// Dados
	$campos = [
		'login__username',
		'login__password'
	];

	$dados = [];
	foreach ($campos as $c) {
		$dados[$c] = param($c);
	}

	// Methods
	$m = [
		'Login',
		'RecuperarSenha'
	];

	// Default Response
	$json_response = [
		'success' => false,
		'url' => ''
	];

	// WS Urls
	$wsdl = [
		'dev'=> 'http://45.35.96.151/eCond_UI/WS.asmx?WSDL',
		'prod'=> 'http://app.portaldeaplicacoes.com/eCond_UI/WS.asmx?WSDL'
	];

	// Stream context for SoapClient options
	$stream_context = stream_context_create([
		'ssl' => [
			'verify_peer' => false,
			'verify_peer_name' => false,
		]
	]);

	try {
		// Soap Client
		$client = new SoapClient($wsdl['prod'], [
			'trace' => 0,
			'exception' => 1,
			'connection_timeout' => 60 * 2,
			'stream_context' => $stream_context,
			'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP
		]);

		// Argumentos
		$args = [
			'Username' => $dados['login__username'],
			'Password' => $dados['login__password']
		];

		// Debug
		// var_dump($client->__getFunctions());
		// var_dump($args);
		// var_dump($m[0]);die;

		// Chamada
		$method = $m[0];
		$res = $client->$method($args);

		// Response
		if (isset($res->URL) && $res->URL) {
			$url = str_replace('[[USER]]', $args['Username'], $res->URL);
			$url = str_replace('[[PASS]]', urlencode($args['Password']), $url);
			$json_response['success'] = true;
			$json_response['url'] = $url;
		}
	} catch (Exception $e) {
		$json_response['error'] = $e->getMessage();
	}

	// Json Response
	header('Content-Type: application/json');
	echo json_encode($json_response);
}

die;
