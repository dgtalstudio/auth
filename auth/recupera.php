<?php
require_once dirname(__FILE__).'/helpers.php';
cors();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	// Dados
	$campos = ['email'];

	$dados = [];
	foreach ($campos as $c) {
		$dados[$c] = param($c);
	}

	// Default Response
	$json_response = [
		'success' => false,
		'message' => 'Falha no servidor'
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
			'Email' => $dados['email']
		];

		// Debug
		// var_dump($client->__getFunctions());
		// var_dump($args);

		// Chamada
		$method = 'RecuperarSenha';
		$res = $client->$method($args);

		// Response
		if (isset($res->Retorno) && $res->Retorno) {
			$r = explode('|', $res->Retorno);
			if (count($r) === 2) {
				$json_response['success'] = boolval($r[0]);
				$json_response['message'] = $r[1];
			}
		}
	} catch (Exception $e) {
		$json_response['error'] = $e->getMessage();
	}

	// Json Response
	header('Content-Type: application/json');
	echo json_encode($json_response);
}

die;
