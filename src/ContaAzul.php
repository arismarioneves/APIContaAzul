<?php

namespace ContaAzul;

use ContaAzul\Auth\Auth;
use ContaAzul\Helpers\ApiRequest;

class ContaAzul
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $scope;
    private $state;
    private $authHeader;
    private $authCode;

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

    public function requestToken(string $code): object
    {
        $this->authCode = $code;
        $auth = new Auth($this);
        return $auth->getToken();
    }

    public function requestRefreshedToken(string $refresh_token): object
    {
        $auth = new Auth($this);
        return $auth->refreshToken($refresh_token);
    }

    public function request(string $endpoint, array $params, string $token, string $method): object
    {
        $apiRequest = new ApiRequest(["Authorization: Bearer {$token}"]);
        return json_decode($apiRequest->{$method}($endpoint, $params));
    }
}
