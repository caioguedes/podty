<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const API_ROOT_URL = 'http://localhost:8081/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function podcast(string $name)
    {
        return view('welcome')->with('data', [
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
