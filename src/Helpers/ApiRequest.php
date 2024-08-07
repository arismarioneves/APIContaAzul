<?php

namespace ContaAzul\Helpers;

class ApiRequest
{
    private $headers;
    private $baseUrl = 'https://api.contaazul.com/';

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    private function request(string $endpoint, string $method, array $params = [], bool $json = false): string
    {
        $url = $this->baseUrl . $endpoint;
        $curl = curl_init();

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $this->headers
        ];

        if ($json) {
            $options[CURLOPT_POSTFIELDS] = json_encode($params);
            $this->headers[] = 'Content-Type:application/json';
        } else {
            $options[CURLOPT_POSTFIELDS] = http_build_query($params);
        }

        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    public function get(string $endpoint, array $params = []): string
    {
        $query = http_build_query($params);
        $endpoint = $query ? "{$endpoint}?{$query}" : $endpoint;
        return $this->request($endpoint, 'GET');
    }

    public function post(string $endpoint, array $params = [], bool $json = false): string
    {
        return $this->request($endpoint, 'POST', $params, $json);
    }

    public function put(string $endpoint, array $params = [], bool $json = false): string
    {
        return $this->request($endpoint, 'PUT', $params, $json);
    }

    public function delete(string $endpoint, array $params = []): string
    {
        return $this->request($endpoint, 'DELETE', $params);
    }
}
