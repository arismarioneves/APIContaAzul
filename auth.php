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

// Autorizando o aplicativo
echo "<a href='https://api.contaazul.com/auth/authorize?redirect_uri={$redirect_uri}&client_id={$client_id}&scope={$scope}&state={$state}'>Autorizar</a>";
