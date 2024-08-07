<?php

namespace AE8\ContaAzul;

use AE8\ContaAzul\Auth\Auth;
use AE8\ContaAzul\Helpers\ApiRequest;

class ContaAzul
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    public $scope;
    public $state;
    public $authHeader;
    public $authCode;

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope, string $state)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
        $this->state = $state;
        $this->authHeader = [
            'Authorization: Basic ' . base64_encode("{$client_id}:{$client_secret}")
        ];
    }

    public function requestToken(string $code)
    {
        $this->authCode = $code;
        $auth = new Auth($this);
        return $auth->getToken();
    }

    public function refreshToken(string $refresh_token)
    {
        $auth = new Auth($this);
        return $auth->refreshToken($refresh_token);
    }

    public function request($endpoint, $parametros, $token, $type)
    {
        $apiRequest = new ApiRequest(["Authorization: Bearer $token"]);
        $response = $apiRequest->{$type}($endpoint, $parametros);
        return $response;
    }
}
