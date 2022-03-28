<?php
/**
 * Exemplo de como requisitar o access_token que é a chave para ultilizar a API
 * Author: Team Developers DirectCall
 * Data: 2013-03-14
 * Referencia: http://doc.directcallsoft.com/pages/viewpage.action?pageId=524516
 */

// URL que será feita a requisição
$url = "https://api.directcallsoft.com/request_token";

// CLIENT_ID que é fornecido pela DirectCall (Seu e-mail)
$client_id = "**********";
// CLIENT_SECRET que é fornecido pela DirectCall (Código recebido por SMS)
$client_secret = "*********";

// Dados em formato QUERY_STRING
$data = http_build_query(array('client_id' => $client_id, 'client_secret' => $client_secret));

$ch = 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$return = curl_exec($ch);
		
		curl_close($ch);
		
		// Converte os dados de JSON para ARRAY
		$dados = json_decode($return, true);
		
		//Token
		$access_token = $dados['access_token'];
