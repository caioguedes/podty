<?php

namespace App\Podty;

use GuzzleHttp\Client;

class ApiClient
{
    /**
     * ApiService constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://'.env('API_BASE_URL') . '/v1/',
            'auth' => [
                env('API_AUTH_USER'),
                env('API_AUTH_PASS')
            ]
        ]);
    }

    /**
     * @param $resource
     * @return array
     */
    public function get(string $resource): array
    {
        try {
            $response = ($this->client->get($resource)->getBody()->getContents());
        } catch (\Exception $exception) {
            return [];
        }

        $response = json_decode($response, true);

        return $response;
    }

    public function post(string $resource): bool
    {
        try {
            $response = ($this->client->post($resource));
        } catch (\Exception $exception) {
            return false;
        }
        
        return !!($response->getStatusCode() < 400);
    }

    public function patch(string $resource): bool
    {
        try {
            $response = ($this->client->patch($resource));
        } catch (\Exception $exception) {
            return false;
        }
    
        return !!($response->getStatusCode() < 400);
    }

    public function put(string $resource): bool
    {
        try {
            $response = ($this->client->put($resource));
        } catch (\Exception $exception) {
            return false;
        }
    
        return !!($response->getStatusCode() < 400);
    }

    public function delete(string $resource): bool
    {
        try {
            $response = ($this->client->delete($resource));
        } catch (\Exception $exception) {
            return false;
        }
    
        return !!($response->getStatusCode() < 400);
    }
}
