<?php

$requireAutoload = __DIR__ . '/vendor/autoload.php';
require $requireAutoload;

use AE8\ContaAzul\ContaAzul;
use AE8\ContaAzul\Helpers\Helpers;

// Variáveis necessárias para inicialização
$client_id = "CLIENT_ID";
$client_secret = "SECRET_ID";
$redirect_uri = "URL_DE_REDIRECIONAMENTO";
$scope = "sales";
$state = Helpers::generateRandomString(16);

// Instanciando a classe
$apiContaazul = new ContaAzul($client_id, $client_secret, $redirect_uri, $scope, $state);

//---

// Usando a API
$endpoint = "v1/sales/sellers";
$parametros = [];
$token = "TOKEN";
$metodo = "GET";

$request = $apiContaazul->request($endpoint, $parametros, $token, $metodo);

header('Content-Type: application/json');
echo $request;
