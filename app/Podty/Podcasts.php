<?php
namespace App\Podty;

class Podcasts
{
    private $api;

    public function __construct(ApiClient $apiClient)
    {
        $this->api = $apiClient;
    }

    public function top($quantity = 24)
    {
        return $this->returnDefaultResponse(
            $this->api->get('feeds/top/' . $quantity)
        );
    }
    
    private function returnDefaultResponse($response)
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
