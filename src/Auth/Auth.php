<?php

namespace AE8\ContaAzul\Auth;

use AE8\ContaAzul\Helpers\ApiRequest;

class Auth
{
    private $request;
    private $apiRequest;

    public function __construct($request)
    {
        $this->request = $request;
        $this->apiRequest = new ApiRequest($request->authHeader);
    }

    public function getToken(): object
    {
        $params = [
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->request->redirect_uri,
            'code' => $this->request->authCode
        ];

        $response = $this->apiRequest->post('oauth2/token', $params);
        return json_decode($response);
    }

    public function refreshToken(string $refresh_token): object
    {
        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token
        ];

        $response = $this->apiRequest->post('oauth2/token', $params);
        return json_decode($response);
    }
}
