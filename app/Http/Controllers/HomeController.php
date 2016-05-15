<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class HomeController extends Controller
{
    const API_ROOT_URL = 'http://localhost:8081/';


    public function home(string $name)
    {
        return view('home')->with('data', [
            'feed' => $this->getContentFrom(self::API_ROOT_URL . "feed/$name"),
            'episodes' => $this->getContentFrom(self::API_ROOT_URL . "episodes/$name")
        ]);
    }

    private function getContentFrom($source)
    {
        $curl = curl_init($source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return json_decode(curl_exec($curl), true);
    }
}
