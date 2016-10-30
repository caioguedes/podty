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
            'base_uri' => env('API_BASE_URL'),
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
    public function get($resource)
    {
        try {
            $response = ($this->client->get($resource)->getBody()->getContents());
        } catch (\Exception $exception) {
            return [];
        }

        $response = json_decode($response, true);

        return $response;
    }

    public function post($resource)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_BASE_URL') . $resource,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_USERPWD => env('API_AUTH_USER') . ":" . env('API_AUTH_PASS')
        ));

        curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        if ($status_code >= 400) {
            return false;
        }

        return true;
    }

    public function patch($resource)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_BASE_URL') . $resource,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_USERPWD => env('API_AUTH_USER') . ":" . env('API_AUTH_PASS')
        ));

        curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        if ($status_code >= 400) {
            return false;
        }

        return true;
    }

    public function put($resource)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_BASE_URL') . $resource,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_USERPWD => env('API_AUTH_USER') . ":" . env('API_AUTH_PASS')
        ));

        curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        if ($status_code >= 400) {
            return false;
        }

        return true;
    }

    public function delete($resource)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_BASE_URL') . $resource,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_USERPWD => env('API_AUTH_USER') . ":" . env('API_AUTH_PASS')
        ));

        curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        if ($status_code >= 400) {
            return false;
        }

        return true;
    }
}
